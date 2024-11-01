<?php
/**
 * @package URQUi
 * @version 1.0
 * @urqui_user_registration
 */
//1. Add a new form element...
add_action('register_form', 'urqui_register_form');

function urqui_register_form() {
    $rqui = trim(( isset($_POST['rqui']) ) ? $_POST['rqui'] : '');
    ?>
    <p>
        <label for="rqui"><?php _e('RQUi', 'mydomain') ?><br />
            <input type="text" name="rqui" id="rqui" class="input" value="<?php echo esc_attr(stripslashes($rqui)); ?>" size="8" /></label>
    </p>
    <?php
}

//3. Finally, save our extra registration user meta.
add_action('user_register', 'urqui_user_register');

function urqui_user_register($user_id) {

    $val = trim(( isset($_POST['rqui']) ) ? $_POST['rqui'] : '');
    if (!empty($val))
        update_user_meta($user_id, 'rqui', $_POST['rqui']);
}

function urqui_check_fields($errors, $sanitized_user_login, $user_email) {

    $options = get_option('urqui_name'); // get our options array from the db

    if (isset($options['force_urqui_cb'])) {
         $val = trim(( isset($_POST['rqui']) ) ? $_POST['rqui'] : '');
        if (!empty($val)) {
            $errors->add('rquimissing_error', __('<strong>ERROR</strong>: You must enter an RQUi.', 'mydomain'));
        }
    }
    return $errors;
}

add_filter('registration_errors', 'urqui_check_fields', 10, 3);
?>