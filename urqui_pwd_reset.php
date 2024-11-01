<?php

/**
 * @package URQUi
 * @version 1.0
 * @urqui_pwd_reset
 */

add_action( 'password_reset', 'urqui_password_reset' );
 function urqui_password_reset( $user_id, $new_pass) {
 	delete_user_meta($user_id, 'rqui');
 }

?>
