<?php
/* Plugin Name: CSSHero
Plugin URI: csshero.org
Description: Bringing the future of interactive Web design to a WordPress near you. Requires Wp 3.5+
Version: 2.21
Author: CssHero.org
Author URI: csshero.org
License: Commercial
*/ 


require_once ("dynamic_css.php");
require_once ("importer.php");

function wpcss_base64url_encode($data) { 
  return  rawurlencode( base64_encode( $data ) );
}

function wpcss_base64url_decode($data) { 
  return rawbase64_decode( urldecode($data)); 
} 
 

// Place in admin menu a trigger
add_action('admin_bar_menu', 'wpcss_add_toolbar_items', 100);

function wpcss_add_toolbar_items($admin_bar)
{
	if (!wpcss_check_license() or !current_user_can('edit_theme_options') 	) return;
	
	if (get_option('wpcss_hidetexttrigger')!=1)
		$admin_bar->add_menu( array(
								'id'    => 'wpcss-css-hero-go',
								'title' => 'CSS Hero',
								'href'  => csshero_get_trigger_url()
								 
							));
}
 
function wpcss_current_theme_slug()
{ 	$theme_name = wp_get_theme();
	return sanitize_title($theme_name);
}

function wpcss_handle_actions()
{		 		
		//TRIGGER POSSIBLE ACTIONS FOR ALL USERS ///////////////
		
		//SHOW DYNAMIC CSS CASE 
		if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='show_css')
		{  
		  if (is_user_logged_in()):     
			   header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
			   header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		  endif;
			   
		  header("Content-type: text/css");
		  echo  wpcss_get_dynamic_css();
		  die;
		} //END CASE
		
		
		//HISTORY OR PRESET LIST AJAX LOADING RESULT CASE
		if (  (  current_user_can('edit_theme_options') or   function_exists('chpr_roller_is_allowed_to_all') ) && isset($_GET['csshero_action']) && $_GET['csshero_action']=='list_saved_snapshots' && isset($_GET['snapshot_type']) ) 
		
		{
		  $wpcss_history_steps_array=csshero_get_saved_steps('frontend-css-step',$_GET['snapshot_type']);
		  if ($wpcss_history_steps_array)
			{ //list is not empty
			echo "<ul>";
			foreach($wpcss_history_steps_array as $history_element):
				 if ($history_element->step_active_flag=='yes' ) { $activeflag="csshero-active-history-element";     } else {$activeflag="csshero-non-active-history-element";}
				 ?>
				 <li class="<?php echo $activeflag; ?>" id="csshero-step-id-<?php echo $history_element->step_id ?>">
					<a class="preview-saved-step-trigger" href='?csshero_action=preview_step&step_id=<?php echo $history_element->step_id ?>'></a>
					<p><?php
					  if($history_element->step_type=='preset-step') echo '<i>';
					  echo $history_element->step_name;
					  if($history_element->step_type=='preset-step')echo '</i> ';
						  
					  //echo $history_element->step_time.' ';
					?>
					</p>
					<?php if (  $history_element->step_active_flag=='no' && ($_GET['snapshot_type']=='preset' OR $history_element->step_type=='history-step') ): ?>
					 <a target="_blank" class="delete-saved-step-trigger csshero-ajax-self-action"  href='?csshero_action=delete_snapshot&step_id=<?php echo $history_element->step_id ?>'>Delete</a>
					 <a class="activate-saved-step-trigger" href='?csshero_action=activate_snapshot&step_id=<?php echo $history_element->step_id ?>'>Activate</a>
					<?php endif ?>
					
				 </li>
			  <?php
			endforeach;
		    echo "</ul>";
			echo "<div id='csshero-history-actions-feedback'></div>";
			}
		  else echo "<p style='padding:10px';>None yet.</p>"; //list  is empty  
		  //check legacy & suggest history import
		  if (get_option('wpcss_sugg_hist_import_'.wpcss_current_theme_slug()))
			{
			  ?>
			  <p id="csshero-legacy-import-suggestions"> &nbsp; Do you want to import your old history settings?</p>
			  <p id="csshero-legacy-import-actions">
				 &nbsp;
				<a href="?csshero_action=import_legacy_history">YES, run the importer</a>
				<a href="?csshero_action=dont_import_legacy_history">NO, don't bug me</a>
			  </p>
			  <?php 
			}
		  //
		  
		  die;
		} //END CASE
		
		
		//EDITOR   LOADING FOR DEMO CASE //can be killed in your local install
		if (function_exists('csshero_demo_plugin_is_active')):
		
			    if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='edit_page')  {require_once('edit-page.php'); exit;}
					   
		endif; //END CASE
		
		
		
		
		//TRIGGER ACTIONS FOR LOGGED IN USERS THAT  can edit_theme_options ONLY//////////////////////////////////////////////////////////////
		if (!is_user_logged_in() OR !current_user_can('edit_theme_options')  ) return; //quit function if user cannot edit_theme_options
		 
		//IN ADMIN:
		
		//CHECK IF PRODUCT ACTIVATED, OR SHOW NOTICE
		if ( is_admin()  && !wpcss_check_license()) {add_action( 'admin_notices', 'wpcss_hero_admin_notice' ); return;}
		
		//renew cookie
		if ( is_admin() && isset($_COOKIE['csshero_is_on']) && $_COOKIE['csshero_is_on']==1  ) setcookie('csshero_is_on', 0, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);

		//IN FRONTEND:
		
		//DELETE LICENSE
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='delete_license' && is_user_logged_in()&& current_user_can('install_plugins')) {delete_option('csshero-license');wp_redirect(admin_url()); }
		
		
		
		//CHECK LICENSE DEBUG
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='check_license' && is_user_logged_in()&& current_user_can('install_plugins') && is_user_logged_in()&& current_user_can('install_plugins'))
		{
		echo wpcss_check_license(); die;
		}
		
		
		
		///// SAVING CASES //////////
			
		//THEME RESET case
		if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='reset')
		  {
			//SAVE TO NEW STORAGE AS  A NEW EMPTY STEP
			csshero_storage_save_new_step('Theme Reset '. date('h:i:s a m/d/Y', time()) , array());
			 
			//cache the CSS
			if (get_option('csshero_css_caching')==1) wpcss_generate_static_css();
			   
			include('assets/mini-redirect.php');
		  } // end case
		  
		  
		  
		//RESET QUICK CONFIG
		if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='reset_quick_config')  {delete_option('wpcss_quick_config_settings_'.wpcss_current_theme_slug()); include('assets/mini-redirect.php');}

		//useless??
		//if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='delete_theme_config')  {delete_option('wpcss_current_theme_options_array_'.wpcss_current_theme_slug());echo "Done!"; exit;}

		//REMOTE: SHARE PRESET TO CLOUD
		if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='share_preset')  { wpcss_share_current_preset(); }
		
		
		//SAVE CSSHERO DATA case																
		if (current_user_can('edit_theme_options') && isset($_POST['wpcss_submit_form'])  && $_POST['wpcss_submit_form']==1  &&  isset($_POST['csshero-livearray-saving-field']))
		  { 
			//SECURITY FIRST
			if ( empty($_POST)  or  !wp_verify_nonce($_POST['csshero_saving_nonce_field'],'csshero_saving_nonce') )  { print '<h1>Sorry, your nonce did not verify.</h1>';  exit; }
					
			//GET FROM $_POST CURRENT SETTINGS   
			$wpcss_current_settings_array= json_decode(stripslashes( ($_POST['csshero-livearray-saving-field']))); // print_r($wpcss_current_settings_array);
			
			//print_r($wpcss_current_settings_array); //useful for debug  
			
			//SAVE TO STORAGE AS  A NEW STEP
			csshero_storage_save_new_step(date('h:i:s a m/d/Y', time()), $wpcss_current_settings_array);
			
			//CACHE THE CSS
			if (get_option('csshero_css_caching')==1) wpcss_generate_static_css();
			
			if ($wpcss_current_settings_array==csshero_get_configuration_array()) die("Saved"); else die("SaveProblems");

		  } ///end SAVE CSSHERO DATA case


		//SAVE QUICK CONFIG  				
		if (isset($_POST['wpcss_submit_quick_config_form']) && $_POST['wpcss_submit_quick_config_form']==1)
		  {
			//NONCE SECURITY CHECK 
			if ( empty($_POST)  or !wp_verify_nonce($_POST['csshero_saving_nonce_field'],'csshero_saving_nonce') ) { print '<h1>Sorry, your nonce did not verify.</h1> qc01';  exit; }	
			
			$wpcss_new_quick_config=addslashes($_POST['wp-css-config-quick-editor-textarea']);
			
			//add sanitization
			wpcss_update_option('wpcss_quick_config_settings_'.wpcss_current_theme_slug(),$wpcss_new_quick_config);
			
			echo "Config Saved";die;
		  } //end case


		//GET REMOTE PRESETS & STORE LOCALLY	case																
		if (isset($_GET['wpcss_remote_get_preset'])  )
		
		  {
			if ( empty($_POST)  or  !wp_verify_nonce($_POST['csshero_saving_nonce_field'],'csshero_saving_nonce') )  { print '<h1>Sorry, your nonce did not verify.</h1>';  exit; }		
			 
			//print_r($_POST);
			$wpcss_current_settings_array= unserialize( base64_decode($_POST['preset_data']));
			
			//SAVE TO STORAGE AS  A NEW STEP
			csshero_storage_save_new_step($_POST['preset_name'], $wpcss_current_settings_array  );
			
		   ?> <script>  parent.window.location.href = "<?php echo get_bloginfo('url') ?>";  </script><?php
			 die("<h1>Activating preset... </h1>");
		
		  } //END GET REMOTE PRESETS CASE
		
		
		
		//ACTIVATE A LOCAL PRESET / HISTORY STEP case
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['csshero_action']) && $_GET['csshero_action']=='activate_snapshot')
		  {
			//global $wpcss_current_settings_array; //sara letto dopo dal ciclo dei font della header percio va settato bene
			$step_id=$_GET['step_id'];
			if (!is_numeric($step_id)) die ("<h1>Invalid step id, not numeric!");
			
			//new storage
			csshero_storage_bless_row($step_id, 'frontend-css-step');
																	  
			//cache the CSS
			if (get_option('csshero_css_caching')==1) wpcss_generate_static_css();
			include('assets/mini-redirect.php');
			
		  } //end case


		//DELETE LOCAL PRESET CASE
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['csshero_action']) && $_GET['csshero_action']=='delete_snapshot')
		  {
			if (!is_numeric($_GET['step_id'])) die ("<h1>Invalid step id, not numeric!");
			csshero_storage_delete_step($_GET['step_id']);
			die(" &nbsp; Snapshot  deleted.");
		  } //end delete case
		
		
		//DELETE ALL HISTORY CASE
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='delete_history_snapshots')
		  {
		   
			$wpcss_history_steps_array=csshero_get_saved_steps('frontend-css-step','history');
			if ($wpcss_history_steps_array)
			  foreach($wpcss_history_steps_array as $history_element):
					 if ($history_element->step_active_flag!='yes' ) csshero_storage_delete_step($history_element->step_id); 
			  endforeach;
			   
			die("History Snapshots deleted.");
		  }
		  
		  
		//SAVE AS PRESET case
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='rename_snapshot')
		
		  {
			if (csshero_storage_mark_active_step_as_preset($_GET['newname'],'frontend-css-step')) echo "Preset Saved To Site Database.";
			
			die;
		  }

		
		//EDIT PAGE LOADING case
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='edit_page')  {require_once('edit-page.php'); exit;}
						
		//CSSHERO SHUTDOWN case	
		if (isset($_GET['csshero_action']) && $_GET['csshero_action'] =="shutdown" && current_user_can("edit_theme_options") )
		  {
			setcookie('csshero_is_on', 0, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			wp_redirect(add_query_arg( array('csshero_action' => false ) ));die;
		  }
		
		//WHEN CSSHERO IS ON ELIMINATE WP ADMIN BAR WHEN PERFORMING EDITING ACTIONS
		if (isset($_COOKIE['csshero_is_on']) && $_COOKIE['csshero_is_on']==1 && current_user_can("edit_theme_options")
			&& (!isset($_GET['csshero_action']) OR  $_GET['csshero_action'] !="shutdown")
			)
		  { add_filter('show_admin_bar', '__return_false');add_filter( 'edit_post_link', '__return_false' ); }
	 
	  	//LEGACY IMPORT
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='import_legacy_history')  {csshero_import_old_history_and_presets_from_wpoptions(); exit; }
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='dont_import_legacy_history')  {csshero_dontimport_history(); exit; }

	 } //end handle actions func
	 
	 
add_action ('wp_loaded','wpcss_handle_actions');
 

function wpcss_admin_actions(){
  
		//LICENSING   ACTIVATION																				
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='activation' && is_user_logged_in()&& current_user_can('edit_theme_options'))
							
							{ //license request
							  wpcss_update_option('wpcss_accept_license','yes');
							  $data=array( 'admin_url'=>admin_url(), 'url' => get_bloginfo('wpurl'), 'email' => get_bloginfo('admin_email'),'product'=>'CSSHERO');
							  wp_redirect('http://csshero.org/request-license/?v=2&data='.wpcss_base64url_encode(serialize($data)));
								die;  
								}


		//GET REMOTE LICENSE
		
		if (!isset($_POST['wpcss_submit_form'])  && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='get_license'&& get_option('wpcss_accept_license')=='yes' && is_user_logged_in()&& current_user_can('edit_theme_options'))
					{ 
									wpcss_update_option('csshero-license',$_GET['license_key']);
			
									delete_option('wpcss_accept_license');
															
									$license=wpcss_check_license();
									if ($license!=FALSE) { ?>
													  <body style="padding: 0; margin: 0; background: #f0f4f3;">
													  <div style="margin: 0; padding:10px 100px; ">	 
															
																<img src="http://www.csshero.org/production/activation-img/new_courtesy_page.png" alt="CSS Hero Activated" style="display:block; margin: 0 auto; max-width:600px" />														
																
																<a href="<?php echo esc_url(admin_url()) ?>">
																<img src="http://www.csshero.org/production/activation-img/new_courtesy_btn.png" alt="CSS Hero Activated" style="display:block; margin: 20px auto 0; max-width:190px" />
															</a>			
													  </div>
													</body>	
														<?php die;
							}
									
									else {
												$redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
												$redirect_url_array=explode('?',$redirect_url);
												$redirect_url=$redirect_url_array[0];
												wp_redirect($redirect_url.'/?wpcss_message=activation_invalid');
										  }
									
										die;
										
					}
									
		 
		 
} //end func
 
add_action( 'admin_init', 'wpcss_admin_actions', 1 );
 
   

function wpcss_hero_admin_notice() {
    ?>
    <div class="updated">
	<h2> Welcome to CSSHero.</h2>
	<p> Let's activate your product. It's fast and easy! Click the button and let's go.</p>
	<a class="button button-primary button-hero " href="<?php echo esc_url(add_query_arg( 'wpcss_action', 'activation',admin_url() ) ) ?>">Get my key now!</a></p>
    </div>
    <?php
}


 
 
 
 
 
add_action('wp_head', 'wpcss_add_header_stuff');  //adds stuff to theme header for adding custom dynamic css and used fonts
 
function wpcss_add_header_stuff()

{
	//global $_GET; if (isset($_GET['wpcss_disable_all']) && $_GET['wpcss_disable_all']=1) return;
       
	?><!-- Start CSSHero.org Dynamic CSS & Fonts Loading -->
	 <link rel="stylesheet" type="text/css" media="all" href="<?php wp_css_print_style_url() ?>" data-apply-prefixfree />
	 <?php 	$used_fonts_array=csshero_get_used_google_fonts_array();
	 if ($used_fonts_array)
				 { ?><link href='//fonts.googleapis.com/css?family=<?php foreach($used_fonts_array as $font):  echo str_replace(' ','+',$font)."%7C";  endforeach; ?>' rel='stylesheet' type='text/css'> 	<?php } // end if
							 ?> <!-- End CSSHero.org Dynamic CSS & Fonts Loading -->    
	<?php   
}
function wp_css_print_style_url()

     {	//cached
		  if (!current_user_can('edit_theme_options') && (get_option('csshero_css_caching')==1))  //is caching flag on
		  {
			    $old_uploaded=get_option('wpcss_static_css_data');
			   if (is_array($old_uploaded) && isset($old_uploaded['file']) ) { echo ($old_uploaded['url']);  }
        
		  }
		  
		  else
		  {
		  
		  //standard
		  // ale tries to avoid the trailing slash issue
		  $s_url =  get_bloginfo('url');
		  
			if(substr($s_url, -1) != '/') {
			  	$s_url = $s_url.'/';
			}
		  
		  echo  add_query_arg(array( 'wpcss_action'=>'show_css'   ),
								   $s_url
								  );
								  
		 //echo  get_bloginfo('url')."/?wpcss_action=show_css";
		 if (   (  current_user_can('edit_theme_options') or   function_exists('chpr_roller_is_allowed_to_all') ) && isset($_GET['csshero_action']) && $_GET['csshero_action']=='preview_step' && isset($_GET['step_id']) ) echo "&amp;step_id=".$_GET['step_id'];
		 if (   (  current_user_can('edit_theme_options') or   function_exists('chpr_roller_is_allowed_to_all') )) echo "&amp;rnd=".rand(0,1024);
	 
		  } //end else
	 }
     
      

function wpcss_addscripts() {//INCLUDE JS LIBRARIES AND STUFF 
 
 
		 wp_enqueue_script('prefixfree', plugins_url('/assets/js/prefixfree.min.js', __FILE__)); //prefix free. Thanks Lea, you're a star!
 
 
}    
 
add_action('wp_enqueue_scripts', 'wpcss_addscripts');  



 

function wpcss_share_current_preset()
{
	//$the_data=(base64_encode( (get_option('wpcss_current_settings_array_'.wpcss_current_theme_slug()))));
	$the_data=base64_encode(serialize(csshero_get_configuration_array()));
	$args = array(
	'body' => array( 'site_url' => get_bloginfo('url'), 'preset_data' => $the_data, 'preset_name' => $_GET['preset_name'],'user_id' => $_GET['user_id'],  'theme_slug'=>wpcss_current_theme_slug()), 'license'=>wpcss_check_license(),
	'user-agent' => 'Css Hero'
	);
	
	$resp = wp_remote_post( 'http://csshero.org/share-preset', $args );
	print_r($resp[body]);
	die();//"Your preset has been saved."
}

  
function wpcss_check_license()
{
	return "1234567890";
  $license= get_option('csshero-license');
   if ($license !=FALSE && strlen($license)>10)
			{ return $license; 	}
		else return FALSE;
 
}


function csshero_get_used_google_fonts_array()
{
            if (   (  current_user_can('edit_theme_options') or   function_exists('chpr_roller_is_allowed_to_all') ) && isset($_GET['csshero_action']) && $_GET['csshero_action']=='preview_step' && isset($_GET['step_id']) )
												
												$wpcss_current_settings_array=csshero_get_configuration_array($_GET['step_id']);
												else
												$wpcss_current_settings_array=csshero_get_configuration_array();
            
            
            //print_r($wpcss_current_settings_array);die;
            
            
            $used_fonts_array=array(); 
          //  echo "<pre>";print_r($wpcss_current_settings_array);
     
            if (($wpcss_current_settings_array))
					foreach ($wpcss_current_settings_array as $option_slug=>$new_css_row):
                      
                     if (  $new_css_row->property_name =='font-family' && isset($new_css_row->font_source) && $new_css_row->font_source =='google'   &&  strlen( $new_css_row->property_value)>2 )
						 $used_fonts_array[]=$new_css_row->property_value; //take all properties with slug containing font-family like header-font-family
                        
                 
					 endforeach;
			 
		 
            return array_unique($used_fonts_array);
}



function csshero_get_trigger_url()
{
  //return the Main Editor Trigger URL (edito from home)
  
  //echo get_bloginfo('wpurl')."?csshero_action=edit_page".  "&amp;rnd=".rand(0,1024);	
  //echo  add_query_arg( 'csshero_action', 'edit_page' )
  return esc_url   (   add_query_arg(array( 'csshero_action'=>'edit_page', 'rand'=> (rand(0,1024)) ),
								   get_bloginfo('wpurl')
								  )
								  
				  
				 );
  

}


function csshero_get_current_URL() {
	$current_url  = 'http';
	$server_name  = $_SERVER["SERVER_NAME"];
	$server_port  = $_SERVER["SERVER_PORT"];
	$request_uri  = $_SERVER["REQUEST_URI"];
	if (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") $current_url .= "s";
	$current_url .= "://";
	if ($server_port != "80") $current_url .= $server_name . ":" . $server_port . $request_uri;
	else $current_url .= $server_name . $request_uri;
	return $current_url;
}
 
function csshero_add_footer_trigger() {
						global $wp_customize;  
						if (!wpcss_check_license() or !current_user_can('edit_theme_options') or  get_option('wpcss_hidetrigger')==1	) return;
						if (isset($_GET['preview']) OR
							((is_single() OR is_page()) && get_post_status()!='publish') OR
							(isset($wp_customize))
							) return;
						//global $wp;
					    //$current_url = home_url(add_query_arg(array(),$wp->request));
						$current_url=csshero_get_current_URL();	 
				?><div id="csshero-very-first-trigger"><a href="<?php echo esc_url   (   add_query_arg(array( 'csshero_action'=>'edit_page', 'rand'=> (rand(0,1024) ) ),$current_url )    ) ?>"></a></div>
				<style>
						/* NEW STARTUP BUTTON */
						#csshero-very-first-trigger{position:fixed;top:40px;right:40px;z-index: 999999999;background: #448cdd; width: 48px; height: 48px; -webkit-transition: width .5s ease-in-out;-moz-transition: width .5s ease-in-out;-o-transition: width .5s ease-in-out;transition: width .5s ease-in-out;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;overflow: hidden;}
						#csshero-very-first-trigger a{width: 198px; height: 48px; display: block; background: transparent url(<?php echo  plugins_url('/assets/startup.svg', __FILE__) ?>) no-repeat 0 0; cursor: pointer;-webkit-transition: margin-left .3s ease-in-out;-moz-transition: margin-left .3s ease-in-out;-o-transition: margin-left .3s ease-in-out;transition: margin-left .3s ease-in-out; max-width: inherit;}
						#csshero-very-first-trigger a:hover{margin-left: -50px;}
						#csshero-very-first-trigger:hover{width:98px;background: linear-gradient(140deg, #ff6e6e, #5312e0, #00be8d, #0c99e3);background-size: 800% 800%;-webkit-animation: herofader 12s ease infinite;-moz-animation: herofader 12s ease infinite;animation: herofader 12s ease infinite;}
						@-webkit-keyframes herofader{ 0%{background-position:0% 53%} 50%{background-position:100% 48%} 100%{background-position:0% 53%}}
						@-moz-keyframes herofader{ 0%{background-position:0% 53%} 50%{background-position:100% 48%} 100%{background-position:0% 53%}}
						@keyframes herofader{ 0%{background-position:0% 53%} 50%{background-position:100% 48%} 100%{background-position:0% 53%}}
							
				</style>
				
				<?php
}
add_action('wp_footer', 'csshero_add_footer_trigger');





// THIS GIVES US SOME OPTIONS FOR STYLING THE upload ADMIN AREA
function csshero_custom_upload_style() {
	
	
      echo '<style type="text/css">
       							.ml-submit, .theme-layouts-post-layout, tr.post_title , tr.align , tr.image_alt, tr.post_excerpt, tr.post_content ,tr.url{display:none}
						  		
						  		
						  		td.savesend{text-align: right;}
						  		tr.submit .savesend input:hover,
						  		tr.submit .savesend input {background: url(http://www.csshero.org/csshero-nano-service/assets/img/esprit.png) no-repeat 0px -862px; height: 70px !important; z-index:999;border: 0px;padding:0px;width: 208px;border-radius: 0px;-moz-border-radius: 0px;-webkit-border-radius: 0px; text-indent: -9999px;}
						  		#media-upload a.del-link:active,
						  		tr.submit .savesend input:active{position: relative; top: 1px;}
								
								#media-upload a.del-link:hover,
								#media-upload a.del-link{height: 70px; width: 101px; background: url(http://www.csshero.org/csshero-nano-service/assets/img/esprit.png) no-repeat -208px -862px; display: inline-block; float: right; margin: 0px 2px 0px 10px; text-indent: 999px;}
								
								
								tr.submit{border-top: 1px solid #dfdfdf;}
								tr.submit .savesend{padding-top: 15px;}
								
								div#media-upload-header{padding: 0px; border: 0px; background: #222; position: fixed; top: 0px; left: 0px; width: 100%; height: 48px; z-index: 9999;}
								#sidemenu a.current {padding-left: 20px; padding-right: 20px; font-weight: normal; text-decoration: none; background: #3e7cff; color: white;-webkit-border-top-left-radius: 0px;-webkit-border-top-right-radius: 0px;border-top-left-radius: 0px;border-top-right-radius: 0px;border-width: 0px;}
								#sidemenu a{padding: 10px 20px; border: 0px; background: transparent; color: white; font-size: 10px; text-transform: uppercase;}
								body#media-upload{padding-top: 50px; background: #f5f5f5; height: 100%;}
								body#media-upload ul#sidemenu{bottom: 0; margin: 0px; padding: 0px;}
								#sidemenu a:hover{background:#222;}
								h3.media-title{font-family: sans-serif; font-size: 10px; font-weight: bold; text-transform: uppercase;}
								h3.media-title,.upload-flash-bypass,.max-upload-size{display: block;text-align: center;}
								.upload-flash-bypass{margin-top: 20px;}
								.max-upload-size{margin-bottom: 20px;}
								#sidemenu li#tab-type_url,
								#sidemenu li#tab-grabber{display: none;}
         </style>';
}

if (isset($_GET['csshero_upload']) && $_GET['csshero_upload']==1) add_action('admin_head', 'csshero_custom_upload_style');

function wpcss_active_site_plugins() {
	$out="";
  $the_plugs = get_option('active_plugins'); 
	
    if ($the_plugs) foreach($the_plugs as $key => $value) {
        $string = explode('/',$value); // Folder name will be displayed
        $out.=$string[0] .',';
    }
	
	 $the_network_plugs=get_site_option('active_sitewide_plugins');
 
	 if ($the_network_plugs)  foreach($the_network_plugs as $key => $value) {
        $string = explode('/',$key); // Folder name will be displayed
        $out.=$string[0] .',';
    }
    return $out;
}

 
function wpcss_update_option($option_name,$new_value)
{
		  if ( get_option( $option_name ) !== false ) {
		  
			  // The option already exists, so we just update it.
			  update_option( $option_name, $new_value );
		  
		  } else {
		  
			  // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			  $deprecated = null;
			  $autoload = 'no';
			  add_option( $option_name, $new_value, $deprecated, $autoload );
		  }
}


///////ADMIN ACTIONS, OPTIONS, SAVING AND EXPORTING
add_action('admin_init', 'csshero_export_check_url_actions');

function csshero_export_check_url_actions()
 
 {
	 //BOLT VISIBILITY
	 //HIDE / SHOW BLUE TRIGGER
	  if (!isset($_POST['wpcss_submit_form']) && isset($_POST['wpcss_hidetrigger']) && is_numeric($_POST['wpcss_hidetrigger']) && is_user_logged_in()&& current_user_can('install_plugins')) {wpcss_update_option('wpcss_hidetrigger',$_POST['wpcss_hidetrigger']);   }
		 
	  //HIDE / SHOW TEXT TRIGGER
	  if (!isset($_POST['wpcss_submit_form']) && isset($_POST['wpcss_hidetexttrigger']) && is_numeric($_POST['wpcss_hidetexttrigger']) && is_user_logged_in()&& current_user_can('install_plugins')) {wpcss_update_option('wpcss_hidetexttrigger',$_POST['wpcss_hidetexttrigger']);   }
	
	  //HIDE / SHOW DASH NEWS
	  if (!isset($_POST['wpcss_submit_form']) && isset($_POST['wpcss_hidedashnews']) && is_numeric($_POST['wpcss_hidedashnews']) && is_user_logged_in()&& current_user_can('install_plugins')) {wpcss_update_option('wpcss_hidedashnews',$_POST['wpcss_hidedashnews']);   }
		 	  
	 
	 ///CACHE SETTINGS
	 if (current_user_can('install_plugins') && isset($_POST['csshero_set_cache_button']))
		  {
			  wpcss_update_option('csshero_css_caching',$_POST['csshero_css_caching']);  
			  if ($_POST['csshero_css_caching']==1)  {
				global $csshero_global_cache_settings_message;
				$csshero_global_cache_settings_message= "<h1 style='text-align:center'>CSS Caching Enabled.</h1>";
				wpcss_generate_static_css();
			 }
			    
		  }
  
	//ACTION DOWNLOAD SETTINGS TO FILE
	if (current_user_can('install_plugins') && isset($_POST['csshero_export_current_settings_to_file']))
		{  
		  header("Cache-Control: public");
		  header("Content-Description: File Transfer");
		  header("Content-Disposition: attachment; filename= current_csshero_settings.txt");
		  header("Content-Transfer-Encoding: binary");
		  $the_data=(base64_encode( serialize(csshero_get_configuration_array() )));
		  echo 	$the_data;
		  die;
		}
	
	//ACTION SAVE
	if (
            current_user_can('install_plugins') &&
            isset($_POST['csshero_import_current_settings_button']) &&
            isset($_POST['csshero_accept_conditions']) &&
            $_FILES['csshero_current_settings']['type']=='text/plain' &&
            $_FILES['csshero_current_settings']['error']==0
            )
		{
             //echo $_POST['csshero_current_settings'];
			$the_data=unserialize(base64_decode(file_get_contents($_FILES['csshero_current_settings']['tmp_name'])));
		 	//UPDATE CURRENT MAIN THEME SETTINGS !!!
			//wpcss_update_option('wpcss_current_settings_array_'.wpcss_current_theme_slug(),$the_data);
			csshero_storage_save_new_step("File import ".date('h:i:s a m/d/Y', time()), $the_data);
			
			 //	print_r($wpcss_current_settings_array);
			global $csshero_global_saving_import_message;									
			$csshero_global_saving_import_message="<h1>Success!</h1><p>go to your homepage and enjoy :)</p>";
		}
	
	
 }
 
add_action('admin_menu', 'CSSHero_export_plugin_setup_menu');
function CSSHero_export_plugin_setup_menu(){
        add_submenu_page( 'options-general.php','CSSHero  Plugin Settings', 'CSS Hero', 'edit_theme_options', 'csshero_settings', 'CSSHero_settingspage_init' );
}



function CSSHero_settingspage_init(){
		
		global $csshero_global_saving_import_message;
		if ( isset( $csshero_global_saving_import_message)	):
			echo '<div id="message" class="updated fade"><p>'.$csshero_global_saving_import_message.'</p></div>';
			die;
		endif;
		 
		 global $csshero_global_cache_settings_message;
		if ( isset( $csshero_global_cache_settings_message)	):
			echo '<div id="message" class="updated fade"><p>'.$csshero_global_cache_settings_message.'</p></div>';
			 
		endif;
		 
        ?>
		<div class="csshero-settings-wrap wrap">
			<h1>CSS Hero Static CSS</h1>
			<h3>Will serve to unlogged users a static CSS file for best performance. Cache will automatically be updated upon saving.</h3>
		 
			<table class="form-table">
			
				<tr>
					<th scope="row">Enable the cache now</th>
					<td>
						<form method="post">
							<input type="radio" name="csshero_css_caching" value="0" <?php if (get_option('csshero_css_caching')!=1) echo "checked"; ?>>OFF<br>
							<input type="radio" name="csshero_css_caching" value="1" <?php if (get_option('csshero_css_caching')==1) echo "checked"; ?>>ON<br>
							<br /><br />
							<input type="submit" class="button button-primary" name="csshero_set_cache_button" value="Update">
						</form>
					</td>
				</tr>
			</table>
			<hr>
			<br />
			<h1>CSS Hero Export / Import Tool</h1>
			
			<p>This tool allows you to export current site personalizations to a file in order to make easy your work of migrating your work to another domain.</p>
			<h3>Download active settings</h3>
			<p>This keeps your active settings, eg site personalizations, colors, etc. (without your editing history)</p>
			<form method="post">
				<br />
				<input type="submit" class="button" name="csshero_export_current_settings_to_file" value="Download Site Personalizations File">
				<br /><br />
			</form>
			
			<hr>
			<h3>Upload a current_csshero_settings.txt file and replace current state</h3>
			 
			<form method="post" enctype="multipart/form-data">
							<?php 
							if ( isset($_POST['csshero_import_current_settings_button'])  && $_FILES['csshero_current_settings']['type']!='text/plain') echo '<div id="message" class="updated fade"><p>You need to upload only text file</p></div>';
							elseif ( isset($_POST['csshero_import_current_settings_button'])  && $_FILES['csshero_current_settings']['error']!=0) echo '<div id="message" class="updated fade"><p>Upload error</p></div>';
							?>
							<input type="file" name="csshero_current_settings" />
				<h3>Warning - read well before submitting</h3>
				<?php if ( isset($_POST['csshero_import_current_settings_button'])  && !isset($_POST['csshero_accept_conditions'])) echo '<div id="message" class="updated fade"><p>You need to accept the conditions - read the warning</p></div>'; ?>
				<input type="checkbox" name="csshero_accept_conditions"> I understand that this will destroy any current live personalization of current site.
				<p>
				<input type="submit" class="button button-primary" name="csshero_import_current_settings_button" value="Activate">
				</p>
			</form>
			
			
			<hr>
			  <h1>Hide CSS Hero</h1>
			  <p>Normally CSS Hero can be used by all users having the 'edit_theme_options' capability. Following settings apply to all users.</p>
			  <form method="post">
							<h3>Blue Lightning Bolt Icon on Top Right area of site Frontend</h3>
							<input type="radio" name="wpcss_hidetrigger" value="0" <?php if (get_option('wpcss_hidetrigger')!=1) echo "checked"; ?>>SHOW<br>
							<input type="radio" name="wpcss_hidetrigger" value="1" <?php if (get_option('wpcss_hidetrigger')==1) echo "checked"; ?>>HIDE<br>
							<br /> <h3>CSS Hero Top Link on WordPress Admin Bar</h3>
							<input type="radio" name="wpcss_hidetexttrigger" value="0" <?php if (get_option('wpcss_hidetexttrigger')!=1) echo "checked"; ?>>SHOW<br>
							<input type="radio" name="wpcss_hidetexttrigger" value="1" <?php if (get_option('wpcss_hidetexttrigger')==1) echo "checked"; ?>>HIDE<br>
							<br />  <h3>CSS Hero News on WordPress Dashboard</h3>
							<input type="radio" name="wpcss_hidedashnews" value="0" <?php if (get_option('wpcss_hidedashnews')!=1) echo "checked"; ?>>SHOW<br>
							<input type="radio" name="wpcss_hidedashnews" value="1" <?php if (get_option('wpcss_hidedashnews')==1) echo "checked"; ?>>HIDE<br>
							<br /><br />
							
							<input type="submit" class="button button-primary" name="csshero_set_visibility_options" value="Update">
			 </form>
			  <br><br> 
			  <small>
			Bonus tip:  How to  completely remove also this Settings screen? <a href="#" onclick="jQuery('#bonus-tip-remove-screen').toggleClass('hidden')">View</a>
			</small>
			<div id="bonus-tip-remove-screen" class="hidden" style="margin: 20px; padding: 20px; background: #fff;border: 2px dashed #444">
				To <b>completely remove</b>   this Settings screen and the CSS Hero link in the WordPress Settings menu, add this code to your Theme's functions.php file:
				<pre>
				  add_action('admin_menu','csshero_remove_menu_link');
				  function csshero_remove_menu_link () {remove_submenu_page( 'options-general.php', 'csshero_settings' ); }
				</pre>
				
				You will be able to restore it removing the code.
			</div>
			
		    
		</div> <!-- /csshero-settings-wrap wrap -->
		<?php
}
 

///////RSS FEED UPDATES BOX ///////////////////

function csshero_register_widgets() {
	global $wp_meta_boxes;
	if (get_option('wpcss_hidedashnews')!=1)
	    wp_add_dashboard_widget('widget_cssheronews', __('From  the  CSS Hero world', 'csshero'), 'csshero_create_rss_box');
}
add_action('wp_dashboard_setup', 'csshero_register_widgets');

function csshero_make_url_https ($string)
{
  return str_replace('http://','https://',$string);
}
function csshero_create_rss_box() {
	
	// Get RSS Feed(s)
	include_once(ABSPATH . WPINC . '/feed.php');
	
	// My feeds list (add your own RSS feeds urls)
	$my_feeds = array( 
				'https://www.csshero.org/feed/' 
				);
	
	// Loop through Feeds
	foreach ( $my_feeds as $feed) :
	
		// Get a SimplePie feed object from the specified feed source.
		$rss = fetch_feed( $feed );
		if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
		    // Figure out how many total items there are, and choose a limit 
		    $maxitems = $rss->get_item_quantity( 3 ); 
		
		    // Build an array of all the items, starting with element 0 (first element).
		    $rss_items = $rss->get_items( 0, $maxitems ); 
	
		    // Get RSS title
		    $rss_title = '<a href="'.$rss->get_permalink().'" target="_blank">'.strtoupper( $rss->get_title() ).'</a>'; 
		endif;
	
		// Display the container
		?>
		<style>
		#csshero-blog-feed img { margin: 0 auto;display: block}
		#csshero-blog-feed li {border-bottom: 1px solid #ccc}
		#csshero-blog-feed li p:nth-of-type(2) {display: none}
		</style>
		<?php 
		echo '<div class="rss-widget" id="csshero-blog-feed">';
		//echo '<strong>'.$rss_title.'</strong>';
		echo "<img style='float:left; margin:0 5px' src='https://www.csshero.org/wp-content/uploads/2015/05/diamond.jpg' width='64' height='64' /> <strong>Start earning now! Become a CSS Hero affiliate</strong><br />
		Earn 40% on each sale right now.
		Spread the CSS Hero word and share the wealth with us! </p>
		<a target='_blank' href='http://www.csshero.org/affiliate/' style='float:right' class='button button-primary'>Start Earning</a>
		<div style='clear:both'></div>"; 
			 
		echo '<hr style="border: 0; background-color: #DFDFDF; height: 1px;">';
		echo "<strong>Latest News</strong>"; 
		// Starts items listing within <ul> tag
		
		echo '<ul>';
		
		// Check items
		if ( $maxitems == 0 ) {
			echo '<li>'.__( 'No item', 'rc_mdm').'.</li>';
		} else {
			// Loop through each feed item and display each item as a hyperlink.
			foreach ( $rss_items as $item ) :
				// Uncomment line below to display non human date
				//$item_date = $item->get_date( get_option('date_format').' @ '.get_option('time_format') );
				
				// Get human date (comment if you want to use non human date)
				$item_date = human_time_diff( $item->get_date('U'), current_time('timestamp')).' '.__( 'ago', 'rc_mdm' );
				
				// Start displaying item content within a <li> tag
				echo '<li>';
				// create item link
				echo '<a href="'.esc_url( $item->get_permalink() ).'" title="'.$item_date.'">';
				// Get item title
				echo esc_html( $item->get_title() );
				echo '</a>';
				// Display date
				echo ' <span class="rss-date">'.$item_date.'</span><br />';
				// Get item content
				$content =csshero_make_url_https( $item->get_content());
				// Shorten content
				//$content = wp_html_excerpt($content, 240) . ' [...]';
				// Display content
				echo $content;
				// End <li> tag
				echo '</li>';
			endforeach;
		}
		// End <ul> tag
		echo '</ul> </div>';

	endforeach; // End foreach feed
}


///NEXTGEN GALLERY FIX
add_filter('run_ngg_resource_manager',  'wpcss_check_csshero_editpage' );
function wpcss_check_csshero_editpage($valid_request) {    if (!empty($_GET['csshero_action'])) $valid_request = FALSE; return $valid_request; }


//NEW STORAGE ENGINE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function csshero_storage_perform_existance_check()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'csshero';
  
  //check if table is created
  if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	  
	  //TABLE IS NOT CREATED. LET'S CREATE THE TABLE HERE.
	  $charset_collate = $wpdb->get_charset_collate();
  
	  $sql = "CREATE TABLE $table_name (
		  step_id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
		  step_time DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  step_type VARCHAR(30) NOT NULL,
		  step_name VARCHAR(100) NOT NULL,
		  step_data MEDIUMBLOB NOT NULL,
		  step_theme VARCHAR(100) NOT NULL,
		  step_context VARCHAR(30) NOT NULL,
		  step_active_flag VARCHAR(3) NOT NULL,
		  UNIQUE KEY step_id (step_id)
	  ) $charset_collate;";
  
	  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	  dbDelta( $sql );

	  //LEGACY CHECK
	  csshero_import_old_current_settings_from_wpoptions();
	
  } //END IF TABLE NOT EXISTS

} //end function

//////// SAVING FUNCTIONS ////////////////////////////////////////////////////////////////////////
function csshero_storage_save_new_step($name, $current_settings_array, $context='frontend-css-step')
{
  //check if table exists or create it
  //csshero_storage_perform_existance_check(); //no need no more: we do it before on read
  
  global $wpdb;
  $table_name = $wpdb->prefix . 'csshero';
  //insert
  $the_insert=$wpdb->insert( 
		$table_name, 
		array( 
			'step_time' => current_time( 'mysql' ),
			'step_type' =>'history-step',
			'step_name' => $name,
			'step_data' => (gzcompress( serialize($current_settings_array))),
			'step_theme' => wpcss_current_theme_slug(),
			'step_context' => $context,
			'step_active_flag' =>'n-y'
		) 
	);
  
  //if inserted, mark as not active other ones, and bless this one
  if ($the_insert) csshero_storage_bless_row($wpdb->insert_id,$context);
  
  return $the_insert;
}

function csshero_storage_bless_row($step_id, $context)
{
  if (!is_numeric($step_id)) die("<h1>Error in csshero_storage_bless_row, exiting</h1>");
  
  global $wpdb;
  $table_name = $wpdb->prefix . 'csshero';
  
  //unbless others
  $wpdb->query(
	"UPDATE $table_name SET step_active_flag = 'no'
	WHERE step_active_flag = 'yes' AND step_context = '$context' AND step_theme='".wpcss_current_theme_slug()."'
	"
  );
  
  //bless me
  $wpdb->update( 
		  $table_name, 
		  array( 
			  'step_active_flag' => 'yes',	// string
		  ), 
		  array( 'step_id' => $step_id ,'step_context'  => $context, 'step_theme' =>wpcss_current_theme_slug() )
	  );
  
} //end func

function csshero_storage_mark_active_step_as_preset($newname,$context='frontend-css-step')
{
  
  global $wpdb;
  $table_name = $wpdb->prefix . 'csshero';

  $update=$wpdb->update( 
		  $table_name, 
		  array( 
			  'step_name' => $newname,
			  'step_type' =>'preset-step'
		  ), 
		  array( 'step_active_flag' => 'yes', 'step_context' => $context
				)
	  );
  return $update;
}

function csshero_storage_delete_step($step_id)

{
  global $wpdb;
  $table_name = $wpdb->prefix . 'csshero';
  $wpdb->delete( $table_name, array( 'step_id' => $step_id, 'step_active_flag' =>'no' ) );
}


////READ////////////////FUNCTIONS  ////////////////////////////////////////////////////////////////

function csshero_get_configuration_array($step_id="default",$step_context='frontend-css-step',$field_name='step_data')
{
  csshero_storage_perform_existance_check();
  global $wpdb;
  $table_name = $wpdb->prefix . 'csshero';
  
  //GET THE DATA FROM DB
  if ($step_id=="default") {
	  $value = $wpdb->get_var( "SELECT $field_name FROM $table_name WHERE step_theme='".wpcss_current_theme_slug()."' AND step_context='".$step_context."' AND step_active_flag='yes' ORDER BY step_id DESC LIMIT 0,1" ); 
	}
    else {
	  if (!is_numeric($_GET['step_id'])) die ("<h1>Invalid step id, not numeric!");     
      $value = $wpdb->get_var( "SELECT $field_name FROM $table_name WHERE step_theme='".wpcss_current_theme_slug()."' AND step_context='".$step_context."' and step_id=".$_GET['step_id'] );
  }
  //EXTRACT THE COMPRESSED DATA
  if ($value) $wpcss_current_settings_array=unserialize(gzuncompress($value)); else $wpcss_current_settings_array=array();
  
  //legacy
  ////$wpcss_current_settings_array=unserialize(get_option('wpcss_current_settings_array_'.wpcss_current_theme_slug()));
  
  if (is_array($wpcss_current_settings_array) && $wpcss_current_settings_array==array()) return false;
     
  return $wpcss_current_settings_array;  
}


function wpcss_get_property_value_from_slug($slug)
{
    $wpcss_current_settings_array=csshero_get_configuration_array();
    return $wpcss_current_settings_array[$slug]['property_value'];
}



function csshero_get_saved_steps($step_context='frontend-css-step',$snapshot_type='history') {
  global $wpdb;
  $table_name = $wpdb->prefix . 'csshero';
  if ($snapshot_type=='history') $add_where=" 1  ";
  if ($snapshot_type=='preset') $add_where=" step_type='preset-step' ";
  $rows=$wpdb->get_results( "SELECT step_id,step_type,step_name,step_time,step_active_flag FROM $table_name WHERE $add_where AND step_theme='".wpcss_current_theme_slug()."' AND step_context='".$step_context."'  ORDER BY step_id DESC" );
  return $rows; 
}


//end main csshero file, never close php :)