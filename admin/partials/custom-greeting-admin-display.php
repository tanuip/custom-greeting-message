<?php
// Check that the user is allowed to update options
if (!current_user_can('manage_options')) {
    return;
}

// Get the current API key from the database
$api_key = get_option('custom_greeting_weather_api_key');
?>

<div class="wrap">
    <h1><?php esc_html_e('Custom Greeting Settings', 'custom-greeting-message'); ?></h1>
    <form method="post" action="options.php">
        <?php
        // Output security fields for the registered setting
        settings_fields('custom_greeting_options_group');

        // Output setting sections and their fields
        do_settings_sections('custom-greeting-message');

        // Output save settings button
        submit_button(__('Save Settings', 'custom-greeting-message'));
        ?>
    </form>
</div>
