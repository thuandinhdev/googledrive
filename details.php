<?php
include("connect.php");  
$folder_id = trim($_REQUEST["folder_id"]);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Drive API Demo - Detail View</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="style.css" >
</head>

<body>
<?php
$client = getClient();
$service = new Google_Service_Drive($client);
$folder_results = $service->files->get($folder_id);
$folder_name = $folder_results->getName();
/*Get Parent Folder*/
$optParams = array(
    'fields' => "name, parents",
);
$file_parent = $service->files->get($folder_id, $optParams);
$parent_folder_id   = "";
$parent_folder_name = "";
$parent_folder_id   = $file_parent["parents"][0];
/*Get Parent Folder*/
?>
<div class="container">
    <?php include("menu.php"); ?>
    <div class="row">
        <div class="col-md-12">
            <h2>Folder: 
                <?php 
                if($parent_folder_id!=""){ 
                    $parent_folder_name = $service->files->get($parent_folder_id)->getName();
                ?>
                    <a href="<?php echo "details.php?fid=".$parent_folder_id; ?>"><?php echo $parent_folder_name; ?></a> > <?php echo $folder_name; ?>
                <?php 
                }else{
                    echo $folder_name;
                } 
                ?>
            </h2>
        </div>
    </div>
    <?php include("create_upload_action.php"); ?>
    <div class="row">
        <div class="col-md-12" id="results">
            
        </div>
    </div>
</div>

<script type="text/javascript" src="jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="custom.js"></script>
<script>
$(document).ready(function(){
    setTimeout(function(){
        get_file_list('<?php echo $folder_id; ?>');
    },1000);
});
</script>
</body>
</html>