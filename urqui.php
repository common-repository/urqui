<?php

/**
 * @package URQUi
 * @version 1.1
 */
/*
  Plugin Name: URQUi
  Plugin URI: http://www.urqui.com
  Description: URQUi Plugin.
  Version: 1.1
  Author: URQUi
  Author URI: http://www.urqui.com
  License: GPL2
 */


register_activation_hook(__FILE__, 'urqui_activate');
register_deactivation_hook(__FILE__, 'urqui_deactivate');


// activation,deactivation scripts.
require ('urqui_activation.php');

// add enqueue scripts.
require ('urqui_enqueue.php');

// run on activation/deactivation
require ('urqui_pwd_reset.php');

// add specific options for urqui
require ('urqui_options.php');

// modify user registration screen.
require ('urqui_user_registration.php');

// modify user profile screen.
require ('urqui_user_profile.php');

// modify login authentication.
require ('urqui_authenticate.php');

// Interface to URQUi Server.
  require ('urqui_server.php');

// wp member interface.
  require ('urqui_wpmem_hook.php');



?>