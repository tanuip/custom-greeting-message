// custom-greeting-admin.js

(function($) {
    $(document).ready(function() {
        // Example: Alert when the save button is clicked
        $('#submit').on('click', function() {
            alert('Settings have been saved!');
        });

        // Example: Validate API key field
        $('#custom_greeting_weather_api_key').on('input', function() {
            var apiKey = $(this).val();
            if (apiKey.length < 10) { // Example validation rule
                $(this).css('border-color', 'red');
            } else {
                $(this).css('border-color', '');
            }
        });
    });
})(jQuery);
