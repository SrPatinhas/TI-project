<?php

// Should be set to 0 in production
error_reporting(E_ALL);

// Should be set to '0' in production
ini_set('display_errors', '1');

// Timezone
date_default_timezone_set('Europe/Lisbon');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

// Error Handling Middleware settings
$settings['error'] = [

    // Should be set to false in production
    'display_error_details' => true,

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,
];

$settings['view'] = [
    // Path to templates
    'path' => __DIR__ . '/../templates',
];

// Database settings
$settings['db'] = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'greenhouse',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
    ],
];

// Session
$settings['session'] = [
    'name' => 'webapp',
    'cache_expire' => 0,
];

// Logger settings
$settings['logger'] = [
    'name' => 'app',
    'path' => __DIR__ . '/../logs',
    'filename' => 'app.log',
    'level' => \Monolog\Logger::DEBUG,
    'file_permission' => 0775,
];

/*
 * Specific settings for the app
 * This will say the structure of the garden
 * giving the number of lines that exists and
 * the number of positions available, like a
 * grid.
 */
$settings["greenhouse"] = [
    "line" => 4,
    "position" => 4
];


return $settings;
