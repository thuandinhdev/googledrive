<?php
include("connect.php");  
$client = getClient();
$service = new Google_Service_Drive($client);

$req_type = "";
if(isset($_REQUEST['req_type']) && $_REQUEST['req_type']!=""){
    $req_type = $_REQUEST['req_type'];
	if($req_type=="create_folder"){
        if(isset($_POST["folder_id"]) && $_POST["folder_id"]!="" && isset($_POST["folder_name"]) && $_POST["folder_name"]!=""){
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

                header('Content-Type: application/json'); 
                echo json_encode(array("succ"=>1,"msg"=>"Folder has been created successfully","folder_id"=>$new_folder_id));
            }else{
                header('Content-Type: application/json'); 
                echo json_encode(array("succ"=>0,"msg"=>"Folder name you have entered is already exist."));
            }
        }else{
            header('Content-Type: application/json'); 
            echo json_encode(array("succ"=>0,"msg"=>"Something went wrong. Please try again."));
        }
    }else if($req_type=="upload_file"){
        if(isset($_FILES['fileToUpload']["name"]) && $_FILES['fileToUpload']["name"]!="" && isset($_POST["folder_id"]) && $_POST["folder_id"]!=""){

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

                header('Content-Type: application/json'); 
                echo json_encode(array("succ"=>1,"msg"=>"File has been uploaded successfully.","folder_id"=>$folder_id));
            } catch(Exception $e){
                header('Content-Type: application/json'); 
                echo json_encode(array("succ"=>0,"msg"=>$e->getMessage()));
            }
        }else{
            header('Content-Type: application/json'); 
            echo json_encode(array("succ"=>0,"msg"=>"Something went wrong. Please try again."));
        }
    }else if($req_type=="get_file_list"){
        if(isset($_POST["folder_id"]) && $_POST["folder_id"]!=""){
            $folder_id = trim($_POST["folder_id"]);
        ?>
        <table class="table table-responsive bordered">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Preview</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $results = $service->files->listFiles(['q' => "'$folder_id' in parents and trashed=false "]);
                //and mimeType = 'application/vnd.google-apps.folder'
                // echo "<pre>";
                // print_r($results);die;
                if (count($results->getFiles()) == 0) {
                ?>
                <tr>
                    <td colspan="2">Directory is empty.</td>
                </tr>
                <?php
                } else {
                    foreach ($results->getFiles() as $file) {
                        //printf("%s (%s)<br>", $file->getName(), $file->getId());
                        ?>
                        <tr>
                            <td><?php echo $file->getName(); ?></td>
                            <td>
                                <?php 
                                if($file["mimeType"] == "image/jpeg" || $file["mimeType"] == "image/png" || $file["mimeType"] == "image/jpg"){
                                ?>
                                    <a href="https://drive.google.com/open?id=<?php echo $file->getId(); ?>" target="_blank">
                                        <img src="https://drive.google.com/uc?export=view&id=<?php echo $file->getId(); ?>" width="100px">
                                    </a>
                                <?php
                                }
                                ?>
                            </td>
                            <td>
                            <?php 
                                if($file["mimeType"]=="application/vnd.google-apps.folder"){
                                ?>
                                    <a href="<?php echo "details.php?folder_id=".$file->getId(); ?>">View</a>
                                <?php
                                }else{
                                ?>
                                    <a href="https://drive.google.com/open?id=<?php echo $file->getId(); ?>" target="_blank">Open File</a> | 
                                    <a href="<?php echo "download_file.php?file_id=".$file->getId(); ?>">Download File</a>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                
            </tbody>
        </table>
        <?php
        }else{
            echo json_encode(array("succ"=>0,"msg"=>"Something went wrong. Please try again."));
        }
    }
}
?>