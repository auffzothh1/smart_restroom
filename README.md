# Smart Restroom

PHP and MySQL restroom dashboard. GitHub stores the source code; deployment needs PHP hosting with MySQL, not GitHub Pages.

## Install
1. Upload the application to a PHP host with mysqli enabled.
2. Create a NEW EMPTY MySQL database and import schema.sql through phpMyAdmin. This fresh schema has no existing users or sensor readings; thresholds start at 20% soap and 80% waste.
3. Copy config.local.example.php to config.local.php and enter the hosting database credentials. Set a long random sensor API key. Never commit config.local.php.
4. Enable HTTPS. Open register.php to create an account, then login.php.
5. Sensor requests to api/update_sensor.php require the X-API-Key HTTP header matching the configured sensor API key. Send soap and waste percentage parameters.

The original database export uses a different schema and must not be imported together with schema.sql. The original default-password admin creation script is intentionally excluded. Registration is open: anyone who registers can access the dashboard and settings. Review account access before using with real facility data. Free InfinityFree hosting blocks direct API requests from devices such as ESP32.

This package has not yet been tested on a live hosting account.
