<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/vehicle.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$vehicle = new vehicle($db);
 
// set ID property of record to read
$vehicle->vehicle_id = isset($_GET['vehicle_id']) ? $_GET['vehicle_id'] : die();
 
// read the details of product to be edited
$vehicle->readOne();
 
if($vehicle->model!=null){
    // create array
    $vehicle_arr = array(
        "vehicle_id" =>  $vehicle->vehicle_id,
        "model" => $vehicle->model,
        "color" => $vehicle->color,
        "percentage" => $vehicle->percentage,
        "state" => $vehicle->state 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($vehicle_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "Vehicle does not exist."));
}
?>