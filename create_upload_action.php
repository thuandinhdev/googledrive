<?php
if(isset($_REQUEST["error"]) && $_REQUEST["error"]=="true"){
    if(isset($_REQUEST["msg"]) && $_REQUEST["msg"]=="FolderExist"){
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
            Folder name you have entered is already exists.
            </div>
        </div>
    </div>
    <?php
    }
}
?>
<div class="row">
    <div class="col-md-6">
        <form id="form_create_folder" action="create_folder.php" method="post">
            <input type="hidden" name="folder_id" value="<?php echo $folder_id; ?>">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Create Folder in '<?php echo $folder_name; ?>':</label>
                        <input type="text" class="form-control" name="folder_name" id="folder_name" placeholder="Enter Folder Name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="submit" class="btn btn-sm btn-primary" style="margin-top: 35px;" value="Create Folder" name="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <form id="form_upload_file" action="upload_file.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Select folder:</label>
                        <select class="form-control" name="folder_id" id="folder_id">
                            <option value="<?php echo $folder_id; ?>"><?php echo $folder_name; ?></option>
                            <?php
                            $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and trashed=false and parents='$folder_id'";
                            $files = $service->files->listFiles($parameters);
                            
                            foreach( $files as $k => $file ){
                            ?>
                            <option value="<?php echo $file["id"]; ?>"><?php echo $file["name"]; ?></option>
                            <?php    
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Select file to upload:</label>
                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="submit" class="btn btn-sm btn-primary" style="margin-top: 35px;" value="Upload File" name="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<hr class="my-5">