<?php

/**
 * @package URQUi
 * @version 1.1
 * @urqui_check
 */
function urquiCheck($rqui, $urqui, $url) {

//  create the cipher object:
    $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
//   verify our IV size:
    $iv_size = mcrypt_enc_get_iv_size($cipher);

    // get company id and encryption key.
    $myOptions = get_option('urqui_id');

    $id = trim($myOptions['id']);  //get id
    $key = myhex2bin($myOptions['key']); //get key.

    $iv = mt_rand(1000, 99999999);
    $pad2 = $iv_size - (strlen($iv) % $iv_size);
    $iv .= str_repeat(chr($pad2), $pad2);

    $value2Encrypt = $id . $rqui . $urqui;
    $block = mcrypt_get_block_size('rijndael_128', 'cbc');
    $pad = $block - (strlen($value2Encrypt) % $block);
    $value2Encrypt .= str_repeat(chr($pad), $pad);


    if (mcrypt_generic_init($cipher, $key, $iv) != -1) {
        // PHP pads with NULL bytes if $cleartext is not a multiple of the block size..
        $cipherText = mcrypt_generic($cipher, $value2Encrypt);
        mcrypt_generic_deinit($cipher);

      $rtn = urquiServer($iv . $id . $cipherText, $url . "/validate/", 56); // send request to urqui for verification

        if (strlen($rtn) == 0) {

            return("***Error*** Nothing returned from server");
        }

        if (substr($rtn, 0, 11) == "***Error***") {  // if error on server
            return($rtn);
        }

        $cipherText2 = myhex2bin($rtn);  // convert returned value to binary.

        /* Reinitialize buffers for decryption */
        mcrypt_generic_init($cipher, $key, $iv);
        $p_t = mdecrypt_generic($cipher, $cipherText2); // decrypt
        // clear cypher
        mcrypt_generic_deinit($cipher);
        mcrypt_module_close($cipher);

        $plaintext = trim($p_t);  // trim whitespace from returned value.
        //compare strings to ensure no funny business during exchange.
        if (substr($plaintext, 0, 22) != $id . $rqui . $urqui) {
            return("***Error*** Value changed during transmission");
        }

        $chr = substr($plaintext, 22); // extract last byte as indicator for success.

        if ($chr == chr(0x01)) {
            return true;
        } else {
            return false;
        }
    }
}

function myhex2bin($hex_string) {
define('HEX2BIN_WS', " \t\n\r");
    $pos = 0;
	$result = '';
	while ($pos < strlen($hex_string)) {
	  if (strpos(HEX2BIN_WS, $hex_string{$pos}) !== FALSE) {
	    $pos++;
	  } else {
	    $code = hexdec(substr($hex_string, $pos, 2));
		$pos = $pos + 2;
	    $result .= chr($code);
	  }
	}
	return $result;
}
?>
