<?php
/**
 * @package URQUi
 * @version 1.0
 * @urqui_wpmem_hook
 */

function urqui_sidebar($str ) {

$urqui = ( isset($_POST['urqui']) ) ? $_POST['urqui'] : '';

$pos = strpos($str,'<input type="hidden"');  // find value in string to insert new value.
$newstr = substr($str,0,$pos) . '<label for="urqui">' . __( 'URQUi', 'wp-members' ) . '</label>
						<div class="div_texbox"><input type="text" name="urqui" class="input" id="urqui" /></div>'
						 . substr($str,$pos);

    return $newstr;   // return new string with urqui fields inserted.
}

add_filter( 'wpmem_sidebar_form', 'urqui_sidebar',10,1 );

function urqui_sidebar_error($str ) {

 global $urqui_error;

 if ($urqui_error != '') {

	$newstr = '<p class="err">' . $urqui_error . '</p>';
}

    return $newstr;   // return new string with urqui fields inserted.
}

$str = add_filter( 'wpmem_login_failed_sb',urqui_sidebar_error,10,1 );
?>