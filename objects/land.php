<?php
class land{
 
    // database connection and table name
    private $conn;
    private $table_name = "land";
 
    // object properties
    public $land_id;
    public $area;
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
                modified DESC";
 
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
                land_id=:land_id, area=:area";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->land_id=htmlspecialchars(strip_tags($this->land_id));
    $this->area=htmlspecialchars(strip_tags($this->area));

    // bind values
    $stmt->bindParam(":land_id", $this->land_id);
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
                area = :area
            WHERE
                land_id = :land_id";


 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->area=htmlspecialchars(strip_tags($this->area));
    $this->land_id=htmlspecialchars(strip_tags($this->land_id));
 
    // bind new values
    $stmt->bindParam(':area', $this->area);
    $stmt->bindParam(':land_id', $this->land_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE land_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->land_id=htmlspecialchars(strip_tags($this->land_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->land_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


}
?>
