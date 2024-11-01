<?php

/**
 * @package URQUi
 * @version 1.0
 * @urqui_activation
 */
function urqui_activate() {

    // Activation code here...
    // get id and key.

	$data = chr(0xd2) . chr(0xf8) . chr(0x17) . chr(0x4f) . chr(0x24);
	$url = "urqui.com/URQUiServer/";

   	$rtn = urquiServer($data,$url,5);

    if (strlen($rtn) != 41) {
        wp_die( $rtn . 'Unable to connect to urqui.com for activation, try again!');
    }

    $id = substr($rtn, 1, 8);   // seperate id
    $key = bin2hex(substr($rtn, 9));   // extract key.

    $idarray = array(
        'id' => $id,
        'key' => $key
    );

    // add the option to table.
    update_option('urqui_id', $idarray);

    $array = array(
        'valid_url' => 'urqui.com'
    );

    update_option('urqui_name', $array);
}

function urqui_deactivate() {

    // remove id and key.

    delete_option('urqui_id');

    // remove urqui option.

    delete_option('urqui_name');

/* Removed 1.1 Sept 2014.
    $users = new WP_User_Query(array('meta_key' => 'rqui'));
*/
/*
    if (!empty($users->results)) {
        foreach ($users->results as $key => $user) {
            delete_user_meta($user->ID, 'rqui');
        }
    }

*/

}

?>
