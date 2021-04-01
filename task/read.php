<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/task.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$task = new task($db);
 
// read products will be here
// query products
$stmt = $task->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $task_arr=array();
    $task_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $task_i=array(
            "task_id" => $task_id,
            "vehicle_id" => $vehicle_id,
            "area" => $area
        );
 
        array_push($task_arr["records"], $task_i);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($task_arr);
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