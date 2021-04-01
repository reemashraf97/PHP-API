<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/land.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$land = new land($db);
 
// read products will be here
// query products
$stmt = $land->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $land_arr=array();
    $land_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $land_i=array(
            "land_id" => $land_id,
            "area" => $area
        );
 
        array_push($land_arr["records"], $land_i);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($land_arr);
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