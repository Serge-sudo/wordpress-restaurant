<?php

function csshero_import_old_history_and_presets_from_wpoptions()
{
     
     //hello
     echo "<h1>CSS Hero > Starting Legacy History Import  </h1>";
     //check if table exists or create it
     csshero_storage_perform_existance_check();
     global $wpdb;
     $table_name = $wpdb->prefix . 'csshero';
     
 
     
     //HISTORY AND PRESETS IMPORT
     $wpcss_history_steps_array=get_option('wpcss_snapshots_index_array_'.wpcss_current_theme_slug());
     //print_r(     $wpcss_history_steps_array);
     if ($wpcss_history_steps_array):
         
        //$wpcss_history_steps_array=array_reverse($wpcss_history_steps_array);
        foreach($wpcss_history_steps_array as $history_element):
               if (get_option('wpcss_snapshots_active_step_id_'.wpcss_current_theme_slug())==$history_element['step_id'] ) continue;  
               //if ($history_element['snapshot_type']!=$_GET['snapshot_type'])  continue;
               
               //print_r(get_option('wpcss_theme_settings_snapshot_array_'.wpcss_current_theme_slug().'-'.$step_id));
               
               echo "<hr><h3> Importing Step ".$history_element['step_id']. " for Theme: ".wpcss_current_theme_slug()."</h3>";
               
               $wpcss_current_settings_array=unserialize(get_option('wpcss_theme_settings_snapshot_array_'.wpcss_current_theme_slug().'-'.$history_element['step_id']));
               
               
               //determine type
               if ($history_element['snapshot_type']=='history') $step_type="history-step";
               if ($history_element['snapshot_type']=='preset') $step_type="preset-step";
               //SAVE TO STORAGE AS  A NEW STEP & BLESS
                
                //insert into new storage table
               $the_insert=$wpdb->insert( 
                     $table_name, 
                     array( 
                         'step_time' => current_time( 'mysql' ), 
                         'step_name' => $history_element['snapshot_name'],
                         'step_data' => (gzcompress( serialize($wpcss_current_settings_array))),
                         'step_type' => $step_type,
                         'step_theme' => wpcss_current_theme_slug(),
                         'step_context' => 'frontend-css-step',
                         'step_active_flag' =>'no'
                     ) 
                 );
  
      
        endforeach;
		
		csshero_print_editing_retrigger_button();
		
		
		
		//INSERT AGAIN CURRENT SETTINGS TO HELP USER UNDERSTAND THE LIST
		$wpcss_current_settings_array=csshero_get_configuration_array();
		
		//insert into new storage table
        $the_insert=$wpdb->insert( 
                     $table_name, 
                     array( 
                         'step_time' => current_time( 'mysql' ), 
                         'step_name' => date('h:i:s a m/d/Y', time()),
                         'step_data' => (gzcompress( serialize($wpcss_current_settings_array))),
                         'step_type' => 'history-step',
                         'step_theme' => wpcss_current_theme_slug(),
                         'step_context' => 'frontend-css-step',
                         'step_active_flag' =>'no'
                     ) 
                 );
		//if inserted, mark as not active other ones, and bless this one
		if ($the_insert) csshero_storage_bless_row($wpdb->insert_id,$context);
  	   
		
		//DONT BOTHER ANYMORE
		delete_option('wpcss_sugg_hist_import_'.wpcss_current_theme_slug());
		
		
			   
     endif;
      
     die;
 
  
} //end func




function csshero_dontimport_history()
{
	delete_option('wpcss_sugg_hist_import_'.wpcss_current_theme_slug());
	echo "<h1>Ok, we won't bug you anymore.</h1>";
	csshero_print_editing_retrigger_button(); exit;
}

function csshero_print_editing_retrigger_button() {
	?>
	<br><br><br>
	<a id="csshero-retrig-editing" href="?csshero_action=edit_page">Go back to Editing &raquo;</a>
		<style>
			#csshero-retrig-editing {background: #fff; color:#000;padding: 5px 15px;border:1px solid #333;margin-top:30px;font-size:24px;text-decoration: none}
			body {font-family:Arial; max-width:700px;}
		</style>
	<?php
}


function csshero_import_old_current_settings_from_wpoptions() {
	
	if (get_option('wpcss_current_settings_array_'.wpcss_current_theme_slug())):  // IF WE HAVE SOME GOOD THING TO IMPORT
	 
		///ACTIVE SETTINGS IMPORT
		
		$wpcss_current_settings_array=unserialize(get_option('wpcss_current_settings_array_'.wpcss_current_theme_slug()));
		
		//SAVE TO STORAGE AS  A NEW STEP & BLESS
		$insert_current=csshero_storage_save_new_step('Import '.date('h:i:s a m/d/Y', time()),   $wpcss_current_settings_array  );
		
		//SUGGEST TO IMPORT HISTORY LATER...
		wpcss_update_option('wpcss_sugg_hist_import_'.wpcss_current_theme_slug(),1);

	endif;
  
	
} //end func

     

/////////ON THEME SWITCH,RERUN IMPORTER	 
add_action('after_switch_theme', 'csshero_trigger_import_after_switch_theme');

function csshero_trigger_import_after_switch_theme () {
	if (csshero_get_configuration_array()==false) csshero_import_old_current_settings_from_wpoptions();
}

 
 