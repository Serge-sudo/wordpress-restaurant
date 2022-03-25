<?php
function wpcss_get_dynamic_css()
{ 
     $output="";
     
     
     if(isset($_GET['step_id'])) {
          
          //preview mode
         $wpcss_current_settings_array=csshero_get_configuration_array($_GET['step_id']);
        
     }
     else
     {    //standard mode
          $wpcss_current_settings_array=csshero_get_configuration_array();
     }
      
      if ( empty($wpcss_current_settings_array)) return ('');
      
     //REORDER
     
     $sortable_array =  (array) $wpcss_current_settings_array;
     ksort($sortable_array);
      $wpcss_current_settings_array=$sortable_array;

      //END REORDER
      
      
      
      
     // print_r($wpcss_current_settings_array);die;
      
     //init refactoring array
     $wpcss_CSS_generator_array=array();
     
          
     if ($wpcss_current_settings_array) foreach ($wpcss_current_settings_array as $option_slug=>$new_css_row):
             //print_r($new_css_row);
             
            //if (!is_array($new_css_row)) continue; //skip meta tags like theme name and version  
              
             $this_selector=$new_css_row->property_target;  
           
             
             $wpcss_CSS_generator_array[$this_selector][]=$new_css_row;
     
     endforeach;
     
      //print_r($wpcss_CSS_generator_array);
     
     ///NUOVO ARRAY DI REFACTORING
     
       foreach($wpcss_CSS_generator_array as $this_selector=>$this_properties):
         if (($this_selector=='')) continue;
        
         // UPDATE ALE 2.03
         if (($this_selector=='csshero-theme-skin')) continue;
         if (strpos($this_selector, 'mq-combo') !== false) continue;
         // FINE UPDATE ALE 2.03
         
         
         $output.= $this_selector. " {";
             foreach ($this_properties as $this_selector_rows): //print_r($this_property_rule);
                              if ($this_selector_rows->property_name=='preset-combos') continue;
                             
                              if (isset($this_selector_rows->media_query) AND $this_selector_rows->media_query!="") continue;
                              //if ($this_selector_rows->property_value=="") continue;  
                              if (isset($this_selector_rows->needs_important) && ($this_selector_rows->needs_important == 1)) $important="!important"; else $important="";
                              $output.= "\n       ".$this_selector_rows->property_name.": ".$this_selector_rows->property_value.$important."; ";
                      
             
             endforeach;
         
         $output.= "\n    } \n\n";
     endforeach;
     
     
     //MEDIA QUERY
     
     if ($wpcss_current_settings_array) foreach ($wpcss_current_settings_array as $option_slug=>$new_css_row):
         
             
               if (!isset( $new_css_row->media_query) OR $new_css_row->media_query=="") continue;
               //if ($this_selector_rows->property_value=="") continue; //da riaggiungere e pure bene
               $this_selector=$new_css_row->property_target;  
               if (isset($new_css_row->needs_important)) $important="!important"; else $important="";
               $output.= "\n".$new_css_row->media_query." { " .$this_selector. " {   ".$new_css_row->property_name.": ".$new_css_row->property_value.$important."; }  }  ";
     
     endforeach;
     
     return $output;
} //end function


 
 
 
function wpcss_generate_static_css()
{
 
     
     //CLEAR OLD CACHE
     $old_uploaded=get_option('wpcss_static_css_data');
     if (is_array($old_uploaded) && isset($old_uploaded['file']) )      unlink($old_uploaded['file']);
   
     //BUILD CACHE
     $uploaded= wp_upload_bits( "csshero-style.css", FALSE, wpcss_get_dynamic_css() );
     
     if ($uploaded['error']==FALSE) {
        
        //echo "<h3>Uploaded ok</h3>";
        //echo "File URL : ".$uploaded['url'];
        wpcss_update_option('wpcss_static_css_data',$uploaded);
        
      } else {
        
        //SOME ERROR GOING ON
        echo " <h1 style='text-align:center'>Error saving CSS file:".$uploaded['error']."  - Cache disabled.</h1>";
        wpcss_update_option('csshero_css_caching',0);
        
      }
           
} //end function
     
     
?>