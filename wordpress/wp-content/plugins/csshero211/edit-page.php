<?php
$csshero_version="2.21";
$csshero_version_styles="2.21";
include("assets/dbfix.php");

// $active_plugins=get_option('active_plugins');print_r($active_plugins);die;
$theme_slug=wpcss_current_theme_slug();
$html_theme_slug = $theme_slug;
if (isset($_GET['csshero_rocket_mode']) && $_GET['csshero_rocket_mode']=='on') $rocket_mode_string="&rocket_mode=1"; else $rocket_mode_string="";
if (is_child_theme()) { 
	
	$theme_slug=strtolower(get_template()); //gets the parent if we are using a child
}

//you can force here to override default configuration being applied to your theme
if (isset($_GET['override_theme_config'])) $theme_slug=$_GET['override_theme_config'];
//EXAMPLE: $theme_slug="yourtheme";

setcookie('csshero_is_on', 1, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
global $csshero_public_demo_mode;
if ($csshero_public_demo_mode==TRUE) $ademo="cache_subject=demo&"; else $ademo="";
 $hero_js_root= plugins_url('/assets/js', __FILE__); $hero_js_root=str_replace("http://","//",$hero_js_root);
?>


<html id="cssherohtml" data-child-theme-slug="<?php echo $html_theme_slug; ?>">
    <head>
		  <meta name="robots" content="noindex,nofollow">
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.js?ver=1.10.2'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/prefixfree.min.js'></script>
		  <link rel='stylesheet' id='editorstyle-css'  href='//www.csshero.org/production/css-assets-versioning/<?php echo $csshero_version_styles ?>/style.css' type='text/css' media='all' />
		    <title>CSS Hero Editor</title>
		  
				  
			<?php 
			////// INSPECTOR
			if ( function_exists( 'hero_activate_inspector' ) ) {
				hero_activate_inspector();
			} 
			////// INSPECTOR END	
			
			
			////// ANIMATOR
			if ( function_exists( 'hero_activate_animator' ) ) {
				hero_activate_animator();
			} 
			////// ANIMATOR END
			?>
		
				
    </head>
   
    <body id="csshero-workarea">
								
		  <div id="csshero-bg-branding"></div>
		  <div id="csshero-loading-wheel"></div>
		   
		  <div id="csshero-iframe-main-page-wrap" >
				   <iframe id="csshero-iframe-main-page" name="csshero-iframe-main-page" src="<?php echo  remove_query_arg( 'csshero_action' ); ?>" frameborder="0" scrolling="auto" width="100%" height="100%" marginwidth="0" marginheight="0" ></iframe>
		  </div>
		  
		  <textarea id="wp-css-config-quick-editor-textarea-1" style="display: none" name="wp-css-config-quick-editor-textarea-1"><?php echo get_option('wpcss_quick_config_settings_'.wpcss_current_theme_slug()); ?></textarea>
		  
		  <div id="csshero-save-nonce"> <?php wp_nonce_field('csshero_saving_nonce','csshero_saving_nonce_field'); ?></div>
		  
		  <script>
		  function wpcss_initialize_editor_data()
							  {       
									jQuery( "body" ).data( "wpcss_current_settings_array", '<?php echo addslashes(json_encode(csshero_get_configuration_array()));  ?>' ).data( "wpcss_admin_url", '<?php echo get_admin_url(); ?>' ).data( "wpcss_site_url", '<?php echo get_bloginfo('url'); ?>' );
									
									//jQuery( "body" ).data( "wpcss_current_applied_stylepresets", '<?php  //echo addslashes(json_encode(csshero_get_configuration_array("default","frontend","step_stylepresets"))); ?>' );
								  } 
					  
		  </script>
	<!--	<script type='text/javascript' src='//csshero.org/production/heroes-loader-2018.php?<?php echo $ademo ?>version=<?php echo $csshero_version .$rocket_mode_string ?>&key=<?php echo  wpcss_check_license() ?>&theme=<?php echo $theme_slug ?>&thv=<?php $my_theme = wp_get_theme(); echo   $my_theme->get( 'Version' ); ?>&plugins=<?php echo wpcss_active_site_plugins() ?><?php if (isset($_GET['rocket_mode_version'])) echo "&rocket_mode_version=".$_GET['rocket_mode_version'] ?>'></script>  -->
			<script type='text/javascript' src='<?php echo $hero_js_root ?>/css-hero-2.21-no-plugins-rocketmode-on.js'></script>
		  
		  <script type='text/javascript' src='//csshero.org/production/theme-configurations/_fn.js'></script>
		  <script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/csshero.js'></script>

		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.form.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.ui.core.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.ui.widget.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.ui.mouse.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.ui.draggable.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.ui.resizable.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.ui.slider.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.ui.touch-punch.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.ui.button.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/jquery.ui.dialog.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/iris.min.js'></script>
		  <script type='text/javascript' src='<?php echo $hero_js_root ?>/roundslider.min.js'></script>
    </body>
</html>
