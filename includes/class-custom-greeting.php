<?php

class Custom_Greeting {

    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'custom-greeting-message';
        $this->version = CUSTOM_GREETING_VERSION;
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-custom-greeting-admin.php';
    }

    private function define_admin_hooks() {
        $plugin_admin = new Custom_Greeting_Admin($this->get_plugin_name(), $this->get_version());
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_scripts'));
        add_action('admin_menu', array($plugin_admin, 'add_options_page'));
        add_action('admin_init', array($plugin_admin, 'register_setting'));
    }

    private function define_public_hooks() {
        add_shortcode('custom_greeting', array($this, 'display_greeting'));
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }

    public function run() {
        // Run the loader to execute all of the hooks with WordPress.
    }

    public function display_greeting($atts) {
        $options = get_option('custom_greeting_options');
        $time = current_time('H:i');
        $greeting = '';

        $options = get_option('custom_greeting_options', array(
			'morning_greeting' => 'Good morning',
			'afternoon_greeting' => 'Good afternoon',
			'evening_greeting' => 'Good evening'
		));
 
        if ($time >= '05:00' && $time < '12:00') {
            $greeting = $options['morning_greeting'];
        } elseif ($time >= '12:00' && $time < '18:00') {
            $greeting = $options['afternoon_greeting'];
        } else {
            $greeting = $options['evening_greeting'];
        }

        // Here you would integrate with a weather API to get weather data
        $api_key = get_option('cbb2c94c549e7f9de71b4cae5c223d97');
		$location = 'Brisbane'; // Example location
		$weather_data = wp_remote_get("https://api.weatherapi.com/v1/current.json?key={$api_key}&q={$location}");

		if (is_wp_error($weather_data)) {
			return 'Unable to retrieve weather data.';
		}

		$weather_data = wp_remote_get("https://api.weatherapi.com/v1/current.json?key={$api_key}&q={$location}");

		if (is_wp_error($weather_data)) {
			return 'Unable to retrieve weather data.';
		}

		$body = wp_remote_retrieve_body($weather_data);
		$weather = json_decode($body, true);

		if (!isset($weather['current'])) {
			return 'Weather data is unavailable.';
		}

		$temperature = isset($weather['current']['temp_c']) ? $weather['current']['temp_c'] : 'N/A';
		$condition = isset($weather['current']['condition']['text']) ? $weather['current']['condition']['text'] : 'unknown conditions';


		return "<div class='custom-greeting'>{$greeting}, The current temperature in {$location} is {$temperature}°C with {$condition}.</div>";
    }
}
