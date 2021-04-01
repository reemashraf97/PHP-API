<?php
class task{
 
    // database connection and table name
    private $conn;
    private $table_name = "task";
 
    // object properties
    public $task_id;
    public $vehicle_id;
    public $area;
    public $modified;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
 

                // select all query
    $query = "SELECT
                v.vehicle_id as vehicle_id, t.task_id, t.area
            FROM
                " . $this->table_name . " t
                LEFT JOIN
                    vehicle v
                        ON t.vehicle_id = v.vehicle_id
            ORDER BY
                t.modified DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                vehicle_id=:vehicle_id, area=:area";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
    $this->area=htmlspecialchars(strip_tags($this->area));

    // bind values
    $stmt->bindParam(":vehicle_id", $this->vehicle_id);
    $stmt->bindParam(":area", $this->area);

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
                vehicle_id = :vehicle_id,
                area = :area
            WHERE
                task_id = :task_id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
    $this->area=htmlspecialchars(strip_tags($this->area));
    $this->task_id=htmlspecialchars(strip_tags($this->task_id));
  
    // bind new values
    $stmt->bindParam(':vehicle_id', $this->vehicle_id);
    $stmt->bindParam(':area', $this->area);
    $stmt->bindParam(':task_id', $this->task_id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE task_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->task_id=htmlspecialchars(strip_tags($this->task_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->task_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

}
?>
