<?php
/**
 * @package URQUi
 * @version 1.0
 * @urqui_user_profile
 */
add_action('show_user_profile', 'urqui_add_profile_fields');
add_action('edit_user_profile', 'urqui_add_profile_fields');
add_action('profile_update', 'urqui_update_profile_fields');

function urqui_update_profile_fields($user_id) {

    if (!current_user_can('edit_user', $user_id))
        return false;

    $val =  trim(( isset($_POST['rqui']) ) ? $_POST['rqui'] : '');

    if (empty($val)) {
        delete_user_meta($user_id, 'rqui');
    } else {
        update_user_meta($user_id, 'rqui', $_POST['rqui']);
    }
}

function urqui_add_profile_fields($user) {
    ?>

    <h3>URQUi Information </h3>
    <table class="form-table">

        <tr>
            <th><label for="rqui">RQUi</label></th>

            <td>
                <input type="text" name="rqui" id="rqui" value="<?php echo esc_attr(get_the_author_meta('rqui', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description">Please enter your RQUi that can be found in the Options menu on your mobile device.</span>
            </td>
        </tr>

    </table>
    <?php
}

add_action('wp_login', 'urqui_post_login', 10, 2);

// custom login for plugin
function urqui_post_login($user_login, $user) {

    // update user meta with rqui if applicable. 
    // did user enter rqui on login screen?  
    $user_entered_rqui = trim(( isset($_POST['rqui']) ) ? $_POST['rqui'] : '');

    if (!empty($user_entered_rqui)) {
        update_user_meta($user->id, 'rqui', $user_entered_rqui);
    }
}

add_action('login_form', 'login_urqui');

function login_urqui() {

    //Get and set any values already sent
    $urqui = ( isset($_POST['urqui']) ) ? $_POST['urqui'] : '';
    $rqui = ( isset($_POST['rqui']) ) ? $_POST['rqui'] : '';
    ?>

    <p>
        <label for="rqui"><?php _e('RQUi', 'mydomain') ?>     <a id="rqui_show" href="javascript:toggle('rqui')" title="<?php _e('Display this box, to register a new RQUi.<br> You must input all 4 login fields <br> when you register a new RQUi.<br> <br>If you need to change your RQUi,<br> you must do it from the User Profile screen after you login.', 'urqui'); ?>" class="urquiTip" tabindex="-1">[show]</a>
            &nbsp;<a style="DISPLAY: none" id="rqui_hide" href="javascript:toggle('rqui')"title="<?php _e('You can hide this box, if you are not required to enter an RQUi', 'urqui'); ?>" class="urquiTip" tabindex="-1">[hide]</a> <br />  

            <input type="text" name="rqui"   class="input" value=" <?php echo esc_attr(stripslashes($rqui)); ?> " size="8" style="DISPLAY: none" id="rqui"/></label>

        <label for="urqui"><?php _e('URQUi', 'mydomain') ?><small><a href="#" title="<?php _e('This number can be found in the URQUi app on your mobile device.<br> You must enter this number if you have already registered an RQUi or<br> are currently registering an RQUi in the above field', 'urqui'); ?>" class="urquiTip" tabindex="-1">[?]</a></small><br />

            <input type="text" name="urqui" id="urqui" class="input" value="<?php echo esc_attr(stripslashes($urqui)); ?>" size="6" /></label>

    </p> 
    
    <script>
        function toggle(id) {
            var e1 = document.getElementById(id);
            if (e1.style.display != 'none') {
                e1.style.display = 'none';
            }
            else {
                e1.style.display = 'block';
            }


            //more info href link
            e2 = document.getElementById(id + "_show");
            if (e2.style.display != 'none') {
                e2.style.display = 'none';
            }
            else {
                e2.style.display = 'inline';
            }

            e3 = document.getElementById(id + "_hide");
            if (e3.style.display != 'none') {
                e3.style.display = 'none';
            }
            else {
                e3.style.display = 'inline';
            }

        }


    </script>

    <?php
}
?>