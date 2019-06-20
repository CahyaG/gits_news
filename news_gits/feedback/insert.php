<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../object/feedback.php';
 
$database = new Database();
$db = $database->getConnection();
 
$feedback = new Feedback($db);
 
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->nama) &&
    !empty($data->rating) &&
    !empty($data->deskripsi)
){
 
    $feedback->nama = $data->nama;
    $feedback->rating = $data->rating;
    $feedback->deskripsi = $data->deskripsi;
 
    if($feedback->create()){
 
        http_response_code(201);
 
        echo json_encode(array("message" => "Feedback was inserted."));
    }
 
    else{
 
        http_response_code(503);
 
        echo json_encode(array("message" => "Unable to insert Feedback."));
    }
}
 
else{
 
    http_response_code(400);
 
    echo json_encode(array("message" => "Unable to insert feedback. Data is incomplete."));
}
?>