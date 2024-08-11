<?php
include("connect.php");  

?>
<!DOCTYPE html>
<html>

<head>
    <title>Drive API Demo - Root Folder</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="style.css" >
</head>

<body>
<?php
$client = getClient();
$service = new Google_Service_Drive($client);

// Print the names and IDs for up to 10 files.
$optParams = array(
  'pageSize' => 100,
  'fields' => 'nextPageToken, files(id, name)'
);
$results = $service->files->listFiles($optParams);

?>

<main role="main" class="container">
    <?php include("menu.php"); ?>
    <div class="row">
        <div class="col-md-12">
            <h2>Current Folder: <?php echo $folder_name; ?></h2>
        </div>
    </div>
    <?php include("create_upload_action.php"); ?>
    <div class="row">
        <div class="col-md-12" id="results">
            
        </div>
    </div>
</main>


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