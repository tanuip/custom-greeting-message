jQuery(document).ready(function($) {
    // Example JavaScript functionality
    console.log("Custom Greeting Message plugin loaded.");
});

jQuery(document).ready(function($) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            fetchWeatherData(latitude, longitude);
        }, function(error) {
            console.error("Error obtaining location: ", error);
        });
    } else {
        console.error("Geolocation is not supported by this browser.");
    }

    function fetchWeatherData(lat, lon) {
        $.ajax({
            url: customGreeting.ajax_url,
            type: 'POST',
            data: {
                action: 'get_weather_data',
                latitude: lat,
                longitude: lon
            },
            success: function(response) {
                $('.custom-greeting').html(response);
            },
            error: function() {
                console.error("Error fetching weather data.");
            }
        });
    }
});
