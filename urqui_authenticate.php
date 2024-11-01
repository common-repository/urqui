<?php

/**
 * @package URQUi
 * @version 1.0
 * @urqui_authenticate
 */
add_filter('authenticate', 'urqui_authenticate', 10, 3);

function urqui_authenticate($user, $username, $password) {

    if (empty($username)) {  // if user hasn't entered a username, no point in continuing.
        return null;
    }

    //Get user object
    $user = get_user_by('login', $username);

    if (!$user) { // if user does not exist, don't continue.     
        return null;
    }

    // get our options array from the db
    $options = get_option('urqui_name');
    if (isset($options['force_urqui_cb'])) {  // 2fa is in effect?
        $twofa = TRUE;
    } else {
        $twofa = FALSE;
    }

    $url = $options['valid_url'];  //url for validation server.
    // did user enter rqui on login screen?  
    $user_entered_rqui = trim(( isset($_POST['rqui']) ) ? $_POST['rqui'] : '');

    //Get urqui value
    $user_entered_urqui = trim(( isset($_POST['urqui']) ) ? $_POST['urqui'] : '');

    //Get rqui value from user profile.
    $rqui_value = get_user_meta($user->ID, 'rqui', true);

    // ok now lets do some validation. 
    if ((!empty($rqui_value)) && (!empty($user_entered_rqui))) { // user cannot override user profile rqui.
        return urquiAuthError("Your profile already contains an RQUi. You can change it in your User_Profile.");
    }

    if (empty($rqui_value) && empty($user_entered_rqui)) {  // no rqui anywhere
        if ($twofa) {  //  if two factor is in effect.        
            return urquiAuthError("Your profile does not contain an RQUi, you must enter an RQUi(Show if necessary)/URQUi");
        } else {
            return null;  // return to check password, no urqui validation required. 
        }
    } elseif (empty($user_entered_urqui)) {  // user must enter a urqui number if an rqui is present. 
        return urquiAuthError("URQUi identifier is missing");
    }

    $rqui_to_use = (!empty($rqui_value) ) ? $rqui_value : $user_entered_rqui;  // profile rqui takes precedance. 

    if (strlen($rqui_to_use) != 8) {
        return urquiAuthError("The RQUi must contain 8 alphanumeric characters");
    }

    if (strlen($user_entered_urqui) != 6) {
        return urquiAuthError("The URQUi must contain 6 numbers");
    }

    // call to urqui server here.
    $rtn = urquiCheck($rqui_to_use, $user_entered_urqui, $url);

    if (!$rtn) {
        return urquiAuthError("You're URQUi identifier is invalid.");
    }

    if (substr($rtn, 0, 11) == '***Error***') { // generic error from server 
        return urquiAuthError($rtn);
    }

    //Make sure you return null

    if ($twofa || empty($rqui_value)) {  // 2fa is in effect or empty rqui in profile.
        return null;  // force password check.
    } else {
        return $user;  // good enough let user in, 
    }
}

function urquiAuthError($msg) {
    remove_action('authenticate', 'wp_authenticate_username_password', 20);
    //Create an error to return to user
    $rtn = new WP_Error('invalidcombo', __("<strong>ERROR</strong>: " . $msg));
    //return a wp_error object instead of user object.
    return $rtn;
}

require ('urqui_check.php');  // server validation. 
?>