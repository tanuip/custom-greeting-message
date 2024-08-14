<?php
/**
 * Plugin Name: Custom Greeting Message
 * Plugin URI: https://github.com/tanuip/custom-greeting-message
 * Description: Displays personalized greeting messages based on time and weather.
 * Version: 1.0.0
 * Author: Paul Tanui
 * Author URI: https://github.com/tanuip/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: custom-greeting-message
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('CUSTOM_GREETING_VERSION', '1.0.0');

/**
 * The core plugin class.
 */
require plugin_dir_path(__FILE__) . 'includes/class-custom-greeting.php';

/**
 * Begins execution of the plugin.
 */
function run_custom_greeting() {
    $plugin = new Custom_Greeting();
    $plugin->run();
}
run_custom_greeting();
