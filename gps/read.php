<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/gps.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$gps = new gps($db);
 
// read products will be here
// query products
$stmt = $gps->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $gps_arr=array();
    $gps_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $gps_i=array(
            "gps_id" => $gps_id,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "vehicle_id" => $vehicle_id,
            "data_time_read" => $data_time_read
        );
 
        array_push($gps_arr["records"], $gps_i);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($gps_arr);
}
 
// no products found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No readings found.")
    );
}