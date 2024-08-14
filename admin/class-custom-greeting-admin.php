<?php

class Custom_Greeting_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

    // add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
    add_action('admin_init', array($this, 'register_settings'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
}
 
public function enqueue_scripts() {
    wp_enqueue_script(
        $this->plugin_name . '-admin',
        plugin_dir_url(__FILE__) . 'js/custom-greeting-admin.js',
        array('jquery'),
        $this->version,
        true
    );
}

public function enqueue_styles() {
    wp_enqueue_style(
        $this->plugin_name . '-admin',
        plugin_dir_url(__FILE__) . 'css/custom-greeting-admin.css',
        array(),
        $this->version,
        'all'
    );
}

    public function add_plugin_admin_menu() {
        add_options_page(
            __('Custom Greeting Settings', 'custom-greeting-message'),
            __('Custom Greeting', 'custom-greeting-message'),
            'manage_options',
            'custom-greeting-message',
            array($this, 'display_plugin_admin_page')
        );
    }

    public function display_plugin_admin_page() {
        include_once 'partials/custom-greeting-admin-display.php';
    }

    public function register_settings() {
        register_setting(
            'custom_greeting_options_group',
            'custom_greeting_weather_api_key'
        );

        add_settings_section(
            'custom_greeting_settings_section',
            __('Weather API Settings', 'custom-greeting-message'),
            null,
            'custom-greeting-message'
        );

        add_settings_field(
            'custom_greeting_weather_api_key',
            __('Weather API Key', 'custom-greeting-message'),
            array($this, 'weather_api_key_callback'),
            'custom-greeting-message',
            'custom_greeting_settings_section'
        );
    }

    public function weather_api_key_callback() {
        $api_key = get_option('custom_greeting_weather_api_key', '');
        echo '<input type="text" id="custom_greeting_weather_api_key" name="custom_greeting_weather_api_key" value="' . esc_attr($api_key) . '" />';
    }


    public function add_options_page() {
        add_options_page(
            'Custom Greeting Settings',
            'Custom Greeting',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_options_page')
        );
    }

    public function display_options_page() {
        include_once 'partials/custom-greeting-admin-display.php';
    }

    public function register_setting() {
        register_setting($this->plugin_name, 'custom_greeting_options', array($this, 'validate'));

        add_settings_section(
            'custom_greeting_general',
            __('General Settings', 'custom-greeting-message'),
            array($this, 'general_options_callback'),
            $this->plugin_name
        );

        add_settings_field(
            'morning_greeting',
            __('Morning Greeting', 'custom-greeting-message'),
            array($this, 'morning_greeting_callback'),
            $this->plugin_name,
            'custom_greeting_general'
        );

        add_settings_field(
            'afternoon_greeting',
            __('Afternoon Greeting', 'custom-greeting-message'),
            array($this, 'afternoon_greeting_callback'),
            $this->plugin_name,
            'custom_greeting_general'
        );

        add_settings_field(
            'evening_greeting',
            __('Evening Greeting', 'custom-greeting-message'),
            array($this, 'evening_greeting_callback'),
            $this->plugin_name,
            'custom_greeting_general'
        );
    }

    public function general_options_callback() {
        echo '<p>' . __('Customize your greeting messages here.', 'custom-greeting-message') . '</p>';
    }

    public function morning_greeting_callback() {
        $options = get_option('custom_greeting_options');
        echo "<input type='text' name='custom_greeting_options[morning_greeting]' value='{$options['morning_greeting']}' />";
    }

    public function afternoon_greeting_callback() {
        $options = get_option('custom_greeting_options');
        echo "<input type='text' name='custom_greeting_options[afternoon_greeting]' value='{$options['afternoon_greeting']}' />";
    }

    public function evening_greeting_callback() {
        $options = get_option('custom_greeting_options');
        echo "<input type='text' name='custom_greeting_options[evening_greeting]' value='{$options['evening_greeting']}' />";
    }

    public function validate($input) {
        $valid = array();
        $valid['morning_greeting'] = sanitize_text_field($input['morning_greeting']);
        $valid['afternoon_greeting'] = sanitize_text_field($input['afternoon_greeting']);
        $valid['evening_greeting'] = sanitize_text_field($input['evening_greeting']);
        return $valid;
    }
}