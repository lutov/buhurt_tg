<?php
/**
 * README
 * This configuration file is intended to be used as the main script for the PHP Telegram Bot Manager.
 * Uncommented parameters must be filled
 *
 * For the full list of options, go to:
 * https://github.com/php-telegram-bot/telegram-bot-manager#set-extra-bot-parameters
 */

// Load composer
require_once __DIR__ . '/vendor/autoload.php';

// Load helpers
require_once __DIR__ . '/config.php';

// Load helpers
require_once __DIR__ . '/Helpers/DebugHelper.php';
require_once __DIR__ . '/Helpers/RequestHelper.php';
require_once __DIR__ . '/Helpers/TelegramHelper.php';

// Load API's
require_once __DIR__ . '/API/BuhurtAPI.php';

// Add you bot's username (also to be used for log file names)
$bot_username = BOT_NAME; // Without "@"
$api_key = API_KEY;
$secret = SECRET;
$url = URL;
$admins = ADMINS;
$mysql = MYSQL;
$ips = IPS;

try {
    $bot = new TelegramBot\TelegramBotManager\BotManager([
        // Add you bot's API key and name
        'api_key'      => $api_key,
        'bot_username' => $bot_username,

        // Secret key required to access the webhook
        'secret'       => $secret,

        'webhook'      => [
            // When using webhook, this needs to be uncommented and defined
            'url' => $url,
            // Use self-signed certificate
            //'certificate' => __DIR__ . '/server.crt',
            // Limit maximum number of connections
            'max_connections' => 5,
        ],

        'commands' => [
            // Define all paths for your custom commands
            'paths'   => [
				__DIR__ . '/Commands/SystemCommands',
				__DIR__ . '/Commands/AdminCommands',
				__DIR__ . '/Commands/UserCommands',
            ],
            // Here you can set some command specific parameters
            'configs' => [
                // e.g. Google geocode/timezone api key for /date command
                //'date' => ['google_api_key' => 'your_google_api_key_here'],
            ],
        ],

        // Define all IDs of admin users
        'admins'       => $admins,

        // Enter your MySQL database credentials
        'mysql'        => $mysql,

        // Logging (Error, Debug and Raw Updates)
        'logging'  => [
            //'debug'  => __DIR__ . "/log/{$bot_username}_debug.log",
            'error'  => __DIR__ . "/log/{$bot_username}_error.log",
            //'update' => __DIR__ . "/log/{$bot_username}_update.log",
        ],

        // Set custom Upload and Download paths
        //'paths'    => [
        //    'download' => __DIR__ . '/Download',
        //    'upload'   => __DIR__ . '/Upload',
        //],

        // Botan.io integration
        //'botan' => [
        //    'token' => 'your_botan_token',
        //],

        // Requests Limiter (tries to prevent reaching Telegram API limits)
        'limiter'      => ['enabled' => true],

		// (bool) Only allow webhook access from valid Telegram API IPs.
		'validate_request' => true,

		// (array) When using `validate_request`, also allow these IPs.
		'valid_ips' => $ips,

    ]);

    // Run the bot!
    $bot->run();

} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    echo $e;
    // Log telegram errors
    Longman\TelegramBot\TelegramLog::error($e);
} catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
    // Silence is golden!
    // Uncomment this to catch log initialisation errors
    //echo $e;
}
