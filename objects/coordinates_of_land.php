<?php
class coordinates_of_land{
 
    // database connection and table name
    private $conn;
    private $table_name = "coordinates_of_land";
 
    // object properties
    public $coordinates_id;
    public $land_id;
    public $latitude;
    public $longitude;
    public $modified;
 

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
 

                // select all query
    $query = "SELECT
                l.land_id as land_id, c.coordinates_id, c.latitude, c.longitude
            FROM
                " . $this->table_name . " c
                LEFT JOIN
                    land l
                        ON c.land_id = l.land_id
            ORDER BY
                c.modified DESC";
 
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
                land_id=:land_id, latitude=:latitude, longitude=:longitude";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->land_id=htmlspecialchars(strip_tags($this->land_id));
    $this->latitude=htmlspecialchars(strip_tags($this->latitude));
    $this->longitude=htmlspecialchars(strip_tags($this->longitude));

    // bind values
    $stmt->bindParam(":land_id", $this->land_id);
    $stmt->bindParam(":latitude", $this->latitude);
    $stmt->bindParam(":longitude", $this->longitude);

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
                land_id = :land_id,
                latitude = :latitude,
                longitude = :longitude
            WHERE
                coordinates_id = :coordinates_id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->land_id=htmlspecialchars(strip_tags($this->land_id));
    $this->latitude=htmlspecialchars(strip_tags($this->latitude));
    $this->longitude=htmlspecialchars(strip_tags($this->longitude));
    $this->coordinates_id=htmlspecialchars(strip_tags($this->coordinates_id));
  
    // bind new values
    $stmt->bindParam(':land_id', $this->land_id);
    $stmt->bindParam(':latitude', $this->latitude);
    $stmt->bindParam(':longitude', $this->longitude);
    $stmt->bindParam(':coordinates_id', $this->coordinates_id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE coordinates_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->coordinates_id=htmlspecialchars(strip_tags($this->coordinates_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->coordinates_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

}
?>
