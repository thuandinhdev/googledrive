<?php
include("connect.php");  
$client = getClient();
$service = new Google_Service_Drive($client);

$folder_id = "1vf9wbZKoVa8Evi1hkYQCYkyYJd0cVa7h";

if(isset($_POST["submit"]) && isset($_POST["folder_id"]) && $_POST["folder_id"]!="" && isset($_POST["folder_name"]) && $_POST["folder_name"]!=""){

    $folder_id      = trim($_POST["folder_id"]);
    $folder_name    = trim($_POST["folder_name"]);

    /*Check Folder Exist or Not*/

    $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and name='$folder_name' and trashed=false and parents='$folder_id'";
    $files = $service->files->listFiles($parameters);
    $op = [];
    foreach( $files as $k => $file ){
        $op[] = $file;
    }
    /*Check Folder Exist or Not*/

    if(count($op)==0){
        $fileMetadata = new Google_Service_Drive_DriveFile(array(
            'name' => $folder_name,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => array($folder_id)
            )
        );
        $result = $service->files->create($fileMetadata, array(
            'fields' => 'id')
        );
        $new_folder_id = $result["id"];
        header("location:details.php?fid=".$new_folder_id);
        die;
    }else{
        header("location:details.php?error=true&msg=FolderExist&fid=".$folder_id);
        die;
    }
}else{
    header("location:index.php");
    die;
}
?>