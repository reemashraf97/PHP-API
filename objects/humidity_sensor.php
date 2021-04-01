<?php
class humidity_sensor{
 
    // database connection and table name
    private $conn;
    private $table_name = "humidity_sensor";
 
    // object properties
    public $humidity_id;
    public $humidity;
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
                v.vehicle_id as vehicle_id, h.humidity_id, h.humidity, h.vehicle_id, h.data_time_read
            FROM
                " . $this->table_name . " h
                LEFT JOIN
                    vehicle v
                        ON h.vehicle_id = v.vehicle_id
            ORDER BY
                h.data_time_read DESC";
 
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
                humidity=:humidity, vehicle_id=:vehicle_id, data_time_read=:data_time_read";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->humidity=htmlspecialchars(strip_tags($this->humidity));
    $this->data_time_read=htmlspecialchars(strip_tags($this->data_time_read));
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
 
    // bind values
    $stmt->bindParam(":humidity", $this->humidity);
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
                humidity = :humidity,
                vehicle_id = :vehicle_id,
                data_time_read = :data_time_read
            WHERE
                humidity_id = :humidity_id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->humidity=htmlspecialchars(strip_tags($this->humidity));
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
    $this->data_time_read=htmlspecialchars(strip_tags($this->data_time_read));
    $this->humidity_id=htmlspecialchars(strip_tags($this->humidity_id));
  
    // bind new values
    $stmt->bindParam(':humidity', $this->humidity);
    $stmt->bindParam(':vehicle_id', $this->vehicle_id);
    $stmt->bindParam(':data_time_read', $this->data_time_read);
    $stmt->bindParam(':humidity_id', $this->humidity_id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE humidity_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->humidity_id=htmlspecialchars(strip_tags($this->humidity_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->humidity_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


}
?>
