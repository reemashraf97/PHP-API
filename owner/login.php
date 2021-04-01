<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/owner.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$owner = new owner($db);
 
// check email existence here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$owner->email = $data->email;
$email_exists = $owner->emailExists();
 
// files for jwt will be here
// generate json web token
include_once '../config/core2.php';
include_once '../jwt/BeforeValidException.php';
include_once '../jwt/ExpiredException.php';
include_once '../jwt/SignatureInvalidException.php';
include_once '../jwt/JWT.php';
use \Firebase\JWT\JWT;
 
// generate jwt will be here
// check if email exists and if password is correct
if($email_exists && password_verify($data->password, $owner->password)){
 
    $token = array(
       "iat" => $issued_at,
       "exp" => $expiration_time,
       "iss" => $issuer,
       "data" => array(
           "owner_id" => $owner->owner_id,
           "first_name" => $owner->first_name,
           "last_name" => $owner->last_name,
           "email" => $owner->email,
           "national_id" => $owner->national_id
       )
    );
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt
            )
        );
 
}
 
// login failed will be here
// login failed
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}
?>