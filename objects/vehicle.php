<?php
class vehicle{
 
    // database connection and table name
    private $conn;
    private $table_name = "vehicle";
 
    // object properties
    public $vehicle_id;
    public $model;
    public $color;
    public $percentage;
    public $state;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
 
    // select all query
    $query = "SELECT *
            FROM
                " . $this->table_name . " 
            ORDER BY
                created DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
// used when filling up the update product form
function readOne(){
 
    // query to read single record
    $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                vehicle_id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->vehicle_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->vehicle_id = $row['vehicle_id'];
    $this->model = $row['model'];
    $this->color = $row['color'];
    $this->percentage = $row['percentage'];
    $this->state = $row['state'];
}
// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                vehicle_id=:vehicle_id, model=:model, color=:color, percentage=:percentage, state=:state";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
    $this->model=htmlspecialchars(strip_tags($this->model));
    $this->color=htmlspecialchars(strip_tags($this->color));
    $this->percentage=htmlspecialchars(strip_tags($this->percentage));
    $this->state=htmlspecialchars(strip_tags($this->state));
 
    // bind values
    $stmt->bindParam(":vehicle_id", $this->vehicle_id);
    $stmt->bindParam(":model", $this->model);
    $stmt->bindParam(":color", $this->color);
    $stmt->bindParam(":percentage", $this->percentage);
    $stmt->bindParam(":state", $this->state);
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                model = :model,
                color = :color,
                percentage = :percentage,
                state = :state
            WHERE
                vehicle_id = :vehicle_id";


 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->model=htmlspecialchars(strip_tags($this->model));
    $this->color=htmlspecialchars(strip_tags($this->color));
    $this->percentage=htmlspecialchars(strip_tags($this->percentage));
    $this->state=htmlspecialchars(strip_tags($this->state));
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
 
    // bind new values
    $stmt->bindParam(':model', $this->model);
    $stmt->bindParam(':color', $this->color);
    $stmt->bindParam(':percentage', $this->percentage);
    $stmt->bindParam(':state', $this->state);
    $stmt->bindParam(':vehicle_id', $this->vehicle_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// search products
function search($keywords){
  
    // select all query
    $query = "SELECT
                *
            FROM
                " . $this->table_name . " 
            WHERE
                model LIKE ? OR color LIKE ? 
            ORDER BY
                created DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
// read products with pagination
public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                *
            FROM
                " . $this->table_name . " 
            ORDER BY created DESC
            LIMIT ?, ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}
// used for paging products
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}


// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE vehicle_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->vehicle_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


}
?>
