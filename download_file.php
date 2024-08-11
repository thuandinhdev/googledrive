<?php
//https://developers.google.com/resources/api-libraries/documentation/drive/v3/php/latest/class-Google_Service_Drive.html

include("connect.php");  
$file_id = trim($_REQUEST["file_id"]);

$client = getClient();
$service = new Google_Service_Drive($client);

// Retrieve filename.
$file = $service->files->get($file_id);
$fileName = $file->getName();

// Download a file.
//$content = $service->files->get($file_id, array("alt" => "media"));

$content = $service->files->get($file_id, array(
    'alt' => 'media'));

$headers = $content->getHeaders();
foreach ($headers as $name => $values) {
    header($name . ': ' . implode(', ', $values));
}
header('Content-Disposition: attachment; filename="' . $fileName . '"');
echo $content->getBody();
exit;
/*
// Open file handle for output.
$outHandle = fopen("download/".$fileName, "w+");

// Until we have reached the EOF, read 1024 bytes at a time and write to the output file handle.
while (!$content->getBody()->eof()) {
        fwrite($outHandle, $content->getBody()->read(1024));
}

// Close output file handle.
fclose($outHandle);
*/
?>