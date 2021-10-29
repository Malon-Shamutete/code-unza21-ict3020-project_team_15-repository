<?php
session_start();

$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
$client = new Google_Client();
$client->setClientId('1021966582824-bcaofnuk09fqfahfa3i5nav1h25trm79.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}





// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["photos"])){

        $files = $_FILES['photos']['tmp_name'];


        foreach($files as $key => $value){
           // echo "lib";
        $allowed = array("jpg" => "image/jpg","pdf" => "application/pdf", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photos"]["name"][$key]; //Original file name
        $filetype = $_FILES["photos"]["type"][$key]; // file type 
        $filesize = $_FILES["photos"]["size"][$key]; // file size
        $current_directory = $_FILES["photos"]["tmp_name"][$key]; //Current file directory on Computer

       //echo "li";
        // Verify file extension
       // $ext = pathinfo($filename, PATHINFO_EXTENSION);
       // $ext_lower = strtolower($ext);
       // if(!array_key_exists($ext_lower, $allowed)) die("<script>alert('Error: Please select a valid file format.')</script>");
    
        // Verify file size - 5MB maximum
       // $maxsize = 5 * 1024 * 1024;

        //if($filesize > $maxsize) die("<script>alert('Error: File size is larger than the allowed limit.')</script>");
    
        //echo "ki";
       
           // echo "ol";
            $client->setAccessToken($_SESSION['accessToken']);
            $service = new Google_DriveService($client);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file = new Google_DriveFile();
            foreach ($files as $file_name) {

                $file_path = $current_directory;
                $mime_type = finfo_file($finfo, $file_path);
                $file->setTitle($file_name);

                $file->setDescription('This is a '.$mime_type.' document');
                $file->setMimeType($mime_type);
               // echo "lig";
                $service->files->insert(
                    $file,
                    array(
                        'data' => file_get_contents($file_path),
                        'mimeType' => $mime_type
                    )
                );
            }
            finfo_close($finfo);
            //header('location:'.$url);
            exit();
        


        } 

        }

    } 








// class="dropzone"
//id="my-awesome-dropzone"

/*

 enctype="multipart/form-data"
*/






?>