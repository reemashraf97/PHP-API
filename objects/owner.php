<?php
class owner{
 
    // database connection and table name
    private $conn;
    private $table_name = "owner";
 
    // object properties
    public $owner_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $national_id;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
// create product
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                first_name=:first_name, last_name=:last_name, email=:email, password=:password, national_id=:national_id";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->first_name=htmlspecialchars(strip_tags($this->first_name));
    $this->last_name=htmlspecialchars(strip_tags($this->last_name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->national_id=htmlspecialchars(strip_tags($this->national_id));
    // bind values
    $stmt->bindParam(":first_name", $this->first_name);
    $stmt->bindParam(":last_name", $this->last_name);
    $stmt->bindParam(":email", $this->email);
    // hash the password before saving to database
    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(":national_id", $this->national_id);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}
// check if given email exist in the database
// check if given email exist in the database
function emailExists(){
 
    // query to check if email exists
    $query = "SELECT owner_id, first_name, last_name, password, national_id
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
 
    // bind given email value
    $stmt->bindParam(1, $this->email);
 
    // execute the query
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    // if email exists, assign values to object properties for easy access and use for php sessions
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // assign values to object properties
        $this->owner_id = $row['owner_id'];
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->password = $row['password'];
        $this->national_id = $row['national_id'];
 
        // return true because email exists in the database
        return true;
    }
 
    // return false if email does not exist in the database
    return false;
}
 
// update() method will be here
// update a user record
public function update(){
 
    // if password needs to be updated
    $password_set=!empty($this->password) ? ", password = :password" : "";
 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table_name . "
            SET
                first_name = :first_name,
                last_name = :last_name,
                email = :email,
                national_id = :national_id
                {$password_set}
            WHERE owner_id = :owner_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->first_name=htmlspecialchars(strip_tags($this->first_name));
    $this->last_name=htmlspecialchars(strip_tags($this->last_name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->national_id=htmlspecialchars(strip_tags($this->national_id));

 
    // bind the values from the form
    $stmt->bindParam(':first_name', $this->first_name);
    $stmt->bindParam(':last_name', $this->last_name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':national_id', $this->national_id);
 
    // hash the password before saving to database
    if(!empty($this->password)){
        $this->password=htmlspecialchars(strip_tags($this->password));
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
    }
 
    // unique ID of record to be edited
    $stmt->bindParam(':owner_id', $this->owner_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

}
?>
