<?php
include("connect.php"); 

$client = getClient();
$service = new Google_Service_Drive($client);

if(isset($_POST["submit"]) && !empty($_FILES["fileToUpload"]["name"]) && isset($_POST["folder_id"]) && $_POST["folder_id"]!=""){

    $folder_id      = trim($_POST["folder_id"]);
    $target_file    = $_FILES["fileToUpload"]["name"];

    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    $content = file_get_contents($target_file);
    $mimeType= mime_content_type($target_file);

    $fileMetadata = new Google_Service_Drive_DriveFile(array(
        //Set the Random Filename
        'name' => $target_file,
        //Set the Parent Folder
        'parents' => array($folder_id) // this is the folder id
    ));

    try{
        $newFile = $service->files->create(
            $fileMetadata,
            array(
                'data' => $content,
                'mimeType' => $mimeType,
                'fields' => 'id'
            )
        );
        unlink($target_file);
        header("location:details.php?fid=".$folder_id);
        die;
    } catch(Exception $e){
        header("location:details.php?error=true&msg=".$e->getMessage());
        die;
    }
}else{
    header("location:index.php");
    die;
}
?>