<?php
error_reporting(1);
require 'vendor/autoload.php';

// if (php_sapi_name() != 'cli') {
//     throw new Exception('This application must be run on the command line.');
// }

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('My Project 26545');
    $client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    return $client;
}

$folder_name = "Root"; // Create one folder with any name where all files and folder created within your google drive account. In my case I create 'Root' in my drive 
$folder_id = "1HtgKyOv2vE1T7KnwPIsi6pH5plAeC8wk"; // Ex. 01f9wbWKog928vi1hkYQCYkyYJd0cVa7h
?>