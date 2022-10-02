<?php

// file name
$filename = $_FILES['file']['name'];

var_dump($_FILES);

// Location
$location = 'fiches_technique/'.$filename;
var_dump($location );


// file extension
$file_extension = pathinfo($location, PATHINFO_EXTENSION);
$file_extension = strtolower($file_extension);

// Valid image extensions
$image_ext = array("pdf","png","jpeg","gif");

$response = 0;
if(in_array($file_extension,$image_ext)){
  // Upload file
}

  //check if
if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    $response = $location;  
}

echo $response;

?>