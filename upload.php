<?php
session_start();
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
$client = new Google_Client();
$client->setClientId('801946626294-8l938fam1ur02ughf5lb05uqrq0eh4o7.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}



$dir->close();
if (!empty($_POST)) {
    $client->setAccessToken($_SESSION['accessToken']);
    $service = new Google_DriveService($client);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file = new Google_DriveFile();
    foreach ($files as $file_name) {
        $file_path = 'files/'.$file_name;
        $mime_type = finfo_file($finfo, $file_path);
        $file->setTitle($file_name);
        $file->setDescription('This is a '.$mime_type.' document');
        $file->setMimeType($mime_type);
        $service->files->insert(
            $file,
            array(
                'data' => file_get_contents($file_path),
                'mimeType' => $mime_type
            )
        );
    }
    finfo_close($finfo);
    header('location:'.$url);exit;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Static Navigation - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/dropzone.min.css">
    </head>
    <body>
    <?php 
             include('navbar.php');
             ?>
        <div id="layoutSidenav">
        <?php 
             include('sidebar.php');
             ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">UPLOAD FILES</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Static Navigation</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                            <form action="upload.php" class="dropzone" method="POST" id="my-awesome-dropzone">
       
    </form>
                </div>
            
                            </div>
                        </div>
                        
                        
                    </div>
                </main>
             <?php 
             include('footer.php');
             ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/dropzone.min.js"></script>
    <script>

        // "myAwesomeDropzone" is the camelized version of the HTML element's ID
Dropzone.options.myAwesomeDropzone = {
  paramName: "photos[]", // The name that will be used to transfer the file
  maxFilesize: 10, // MB
  maxFiles: 10,

  //parallelUploads: 3, // 2 file uploads
  acceptedFiles: "application/pdf,.psd,.png,.jpg",
  dictDefaultMessage: '<h5><b>Drop Other Perspectives Of Product Here To Upload</b></h5>',
  addRemoveLinks: true,
  dictRemoveFile: "remove",
  


}
 

    </script>
    </body>
</html>
