<?php

/**
 * @package URQUi
 * @version 1.1
 * @urqui_Server
 */


function urquiServer($txInput, $url, $len) {

   if( !class_exists( 'WP_Http' ) )
          include_once( ABSPATH . WPINC. '/class-http.php' );

   $post_data = $txInput;

   $headers = array( 'content-type' => 'application/text', 'content-length' => $len);

   $response = wp_remote_post( "http://".$url, array('method' => 'POST',  'headers' => $headers, 'body' =>  $post_data ) );

   if ( is_wp_error( $response ) ) {
      $error_message = $response->get_error_message();
      return ("***Error*** " . $error_message);
   }

	$rtn =  $response['body'];

	return ($rtn);

}

?>
