<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/vehicle.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$vehicle = new vehicle($db);
  
// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
  
// query products
$stmt = $vehicle->search($keywords);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $vehicle_arr=array();
    $vehicle_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $vehicle_i=array(
            "vehicle_id" => $vehicle_id,
            "model" => $model,
            "color" => $color,
            "percentage" => $percentage,
            "state" => $state
        );
  
        array_push($vehicle_arr["records"], $vehicle_i);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data
    echo json_encode($vehicle_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No vehicles found.")
    );
}
?>