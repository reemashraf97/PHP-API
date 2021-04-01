<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here  
// get database connection
include_once '../config/database.php';
  
// instantiate product object
include_once '../objects/owner.php';
  
$database = new Database();
$db = $database->getConnection();
  
$owner = new owner($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
    $owner->first_name = $data->first_name;
    $owner->last_name = $data->last_name;
    $owner->email = $data->email;
    $owner->password = $data->password;
    $owner->national_id = $data->national_id;

 
// use the create() method here
    // create the user
if(

    !empty($data->first_name) &&
    !empty($data->last_name) &&
    !empty($data->email) &&
    !empty($data->password) &&
    !empty($data->national_id) &&
    $owner->create()


){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}
?>











