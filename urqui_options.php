<?php

/**
 * @package URQUi
 * @version 1.0
 * @urqui_name
 */


class urquiSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'urqui_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

	}
    /**
     * urqui options page
     */
  public  function urqui_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'URQUi Admin',
            'URQUi',
            'manage_options',
            'urqui-setting-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'urqui_name' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>URQUi Settings</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'urqui_group' );
                do_settings_sections( 'urqui-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'urqui_group', // Option group
            'urqui_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'General', // Title
            array( $this, 'print_section_info' ), // Callback
            'urqui-setting-admin' // Page
        );

		 add_settings_field(
            'valid_url',
            'Validation URL',
            array( $this, 'valid_url_callback' ),
            'urqui-setting-admin',
            'setting_section_id'
        );

        add_settings_field(
            'force_urqui_cb', // force urqui checkbox
            'Use 2FA Authorization', // Title
            array( $this, 'id_number_callback' ), // Callback
            'urqui-setting-admin', // Page
            'setting_section_id' // Section
        );


    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['force_urqui_cb'] ) )
            $new_input['force_urqui_cb'] =  ( $input['force_urqui_cb'] );

        if( isset( $input['valid_url'] ) )
            $new_input['valid_url'] = sanitize_text_field( $input['valid_url'] );
//absint( $input['id_number'] );
        return $new_input;
    }


    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'More information can be found on the website: urqui.com';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {

printf(
    '<input id="%1$s" name="urqui_name[%1$s]" type="checkbox" %2$s /> Both Password and URQUi required.',
    'force_urqui_cb',
    checked( isset( $this->options['force_urqui_cb'] ), true, false )
);

    }

    /**
     * Get the settings option array and print one of its values
     */
    public function valid_url_callback()
    {
        printf(
            '<input type="text" id="valid_url" name="urqui_name[valid_url]" value="%s" />',
            isset( $this->options['valid_url'] ) ? esc_attr( $this->options['valid_url']) : ''
        );
    }
}

if( is_admin() )
    $urqui_settings_page = new urquiSettingsPage();
?>
