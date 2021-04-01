<?php
class gps{
 
    // database connection and table name
    private $conn;
    private $table_name = "gps";
 
    // object properties
    public $gps_id;
    public $latitude;
    public $longitude;
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
                v.vehicle_id as vehicle_id, g.gps_id, g.latitude, g.longitude, g.data_time_read
            FROM
                " . $this->table_name . " g
                LEFT JOIN
                    vehicle v
                        ON g.vehicle_id = v.vehicle_id
            ORDER BY
                g.data_time_read DESC";
 
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
                latitude=:latitude, longitude=:longitude, vehicle_id=:vehicle_id, data_time_read=:data_time_read";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->latitude=htmlspecialchars(strip_tags($this->latitude));
    $this->longitude=htmlspecialchars(strip_tags($this->longitude));
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
    $this->data_time_read=htmlspecialchars(strip_tags($this->data_time_read));
  
    // bind values
    $stmt->bindParam(":latitude", $this->latitude);
    $stmt->bindParam(":longitude", $this->longitude);
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
                latitude=:latitude, longitude=:longitude, vehicle_id=:vehicle_id, data_time_read=:data_time_read         
            WHERE
                gps_id = :gps_id";


 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->latitude=htmlspecialchars(strip_tags($this->latitude));
    $this->longitude=htmlspecialchars(strip_tags($this->longitude));
    $this->vehicle_id=htmlspecialchars(strip_tags($this->vehicle_id));
    $this->data_time_read=htmlspecialchars(strip_tags($this->data_time_read));
    $this->gps_id=htmlspecialchars(strip_tags($this->gps_id));
 
    // bind new values
    $stmt->bindParam(':latitude', $this->latitude);
    $stmt->bindParam(':longitude', $this->longitude);
    $stmt->bindParam(':vehicle_id', $this->vehicle_id);
    $stmt->bindParam(':data_time_read', $this->data_time_read);
    $stmt->bindParam(':gps_id', $this->gps_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE gps_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->gps_id=htmlspecialchars(strip_tags($this->gps_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->gps_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


}
?>
