<?php
class temperature_sensor{
 
    // database connection and table name
    private $conn;
    private $table_name = "temperature_sensor";
 
    // object properties
    public $temperature_id;
    public $temperature;
    public $vehicle_id;
    public $data_time_read;

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
 
    // select all query
    $query = "SELECT
                v.vehicle_id as vehicle_id, t.temperature_id, t.temperature, t.vehicle_id, t.data_time_read
            FROM
                " . $this->table_name . " t
                LEFT JOIN
                    vehicle v
                        ON t.vehicle_id = v.vehicle_id
            ORDER BY
                t.data_time_read DESC";
 
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
                temperature=:temperature, vehicle_id=:vehicle_id, data_time_read=:data_time_read";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->temperature=htmlspecialchars(strip_tags($this->temperature));
    $this->data_time_read=htmlspecialchars(strip_tags($this->data_time_read));
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
 
    // bind values
    $stmt->bindParam(":temperature", $this->temperature);
    $stmt->bindParam(":vehicle_id", $this->vehicle_id);
    $stmt->bindParam(":data_time_read", $this->data_time_read);
 
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
                temperature=:temperature, vehicle_id=:vehicle_id, data_time_read=:data_time_read         
            WHERE
                temperature_id = :temperature_id";


 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->temperature=htmlspecialchars(strip_tags($this->temperature));
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
    $this->data_time_read=htmlspecialchars(strip_tags($this->data_time_read));
    $this->temperature_id=htmlspecialchars(strip_tags($this->temperature_id));
 
    // bind new values
    $stmt->bindParam(':temperature', $this->temperature);
    $stmt->bindParam(':vehicle_id', $this->vehicle_id);
    $stmt->bindParam(':data_time_read', $this->data_time_read);
    $stmt->bindParam(':temperature_id', $this->temperature_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE temperature_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->temperature_id=htmlspecialchars(strip_tags($this->temperature_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->temperature_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


}
?>
