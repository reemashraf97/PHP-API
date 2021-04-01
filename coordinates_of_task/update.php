<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/coordinates_of_task.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$coordinates_of_task = new coordinates_of_task($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of product to be edited
$coordinates_of_task->coordinates_id = $data->coordinates_id;
  
// set product property values
$coordinates_of_task->task_id = $data->task_id;
$coordinates_of_task->latitude = $data->latitude;
$coordinates_of_task->longitude = $data->longitude;
  
// update the product
if($coordinates_of_task->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "updated."));
}
  
// if unable to update the product, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update."));
}
?>