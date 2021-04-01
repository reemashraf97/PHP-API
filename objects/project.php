<?php
class project{
 
    // database connection and table name
    private $conn;
    private $table_name = "project";
 
    // object properties
    public $project_id;
    public $budget;
    public $start_time;
    public $end_time;
    public $modified;
 
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
                start_time DESC";
 
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
                project_id=:project_id, budget=:budget, start_time=:start_time, end_time=:end_time";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->project_id=htmlspecialchars(strip_tags($this->project_id));
    $this->budget=htmlspecialchars(strip_tags($this->budget));
    $this->start_time=htmlspecialchars(strip_tags($this->start_time));
    $this->end_time=htmlspecialchars(strip_tags($this->end_time));
 
    // bind values
    $stmt->bindParam(":project_id", $this->project_id);
    $stmt->bindParam(":budget", $this->budget);
    $stmt->bindParam(":start_time", $this->start_time);
    $stmt->bindParam(":end_time", $this->end_time);
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
                budget = :budget,
                start_time = :start_time,
                end_time = :end_time
            WHERE
                project_id = :project_id";


 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->budget=htmlspecialchars(strip_tags($this->budget));
    $this->start_time=htmlspecialchars(strip_tags($this->start_time));
    $this->end_time=htmlspecialchars(strip_tags($this->end_time));
    $this->project_id=htmlspecialchars(strip_tags($this->project_id));
 
    // bind new values
    $stmt->bindParam(':budget', $this->budget);
    $stmt->bindParam(':start_time', $this->start_time);
    $stmt->bindParam(':end_time', $this->end_time);
    $stmt->bindParam(':project_id', $this->project_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE project_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->project_id=htmlspecialchars(strip_tags($this->project_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->project_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


}
?>
