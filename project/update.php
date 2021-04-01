<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/project.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$project = new project($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of product to be edited
$project->project_id = $data->project_id;
 
// set product property values
$project->budget = $data->budget;
$project->start_time = $data->start_time;
$project->end_time = $data->end_time;
 
// update the product
if($project->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Updated."));
}
 
// if unable to update the product, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update."));
}
?>