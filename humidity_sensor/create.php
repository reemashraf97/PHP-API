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
include_once '../objects/humidity_sensor.php';
 
$database = new Database();
$db = $database->getConnection();
 
$humidity_sensor = new humidity_sensor($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->humidity) &&
    !empty($data->data_time_read) &&
    !empty($data->vehicle_id)
){
 
    // set product property values
    $humidity_sensor->humidity = $data->humidity;
    $humidity_sensor->data_time_read = $data->data_time_read;
    $humidity_sensor->vehicle_id = $data->vehicle_id;
 
    // create the product
    if($humidity_sensor->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create. Data is incomplete."));
}
?>