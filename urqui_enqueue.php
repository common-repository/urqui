<?php

/**
 * @package URQUi
 * @version 1.0
 * @urqui_enqueue
 */
add_action('login_enqueue_scripts', 'urqui_login_enqueue');

/**
 * Load the scripts resources on the login page used for the tooltip
 */
function urqui_login_enqueue() {
   
        wp_enqueue_script('jquery');
        
        // jquery powertip script. 
        wp_enqueue_script('urqui-powertip', plugin_dir_url(__FILE__) . 'powertip/jquery.powertip.min.js', array(), null, true);
         // load powertip css. 
        wp_enqueue_style('urqui-powertip', plugin_dir_url(__FILE__) . 'powertip/jquery.powertip.min.css', array(), null, 'all');  
        
        // custom tooltip
        wp_enqueue_script('urquitip', plugin_dir_url(__FILE__) . 'js/urquiTip.js', array(), null, true);
           
}

?>
