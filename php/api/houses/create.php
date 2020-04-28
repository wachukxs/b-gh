<?php
// Headers
/**
 * This is not recommended in production, 
 * you should only allow code hosted in your domain 
 * or a specific domain to send requests to your server
 */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Methods: PUT, GET, POST");

// Resources
include_once '../../config/Database.php';
include_once '../../model/Houses.php';



if($_FILES['media'])
{
    // code will be added here.

    $avatar_name = $_FILES["media"]["name"];
    $avatar_tmp_name = $_FILES["media"]["tmp_name"];
    $error = $_FILES["media"]["error"];

    $upload_dir = '../../../assets/images/properties/';
    if ($error > 0) {
        $response = array(
            "status" => "no error",
            "error" => false,
            "message" => "File was received!"
        );
    } else {
        $random_name = rand(1000,1000000)."-".$avatar_name;
        $upload_name = $upload_dir.strtolower($random_name);
        $upload_name = preg_replace('/\s+/', '-', $upload_name);

        if (move_uploaded_file($avatar_tmp_name , $upload_name)) {
            $response = array(
                "status" => "success",
                "error" => false,
                "message" => "File uploaded successfully",
                "name" => $upload_name
              );
        } else {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the file!"
            );
        }
    }
    
} else {
    $response = array(
        "status" => "error",
        "error" => true,
        "message" => "No file was received!"
    );
}

echo json_encode($response);
?>