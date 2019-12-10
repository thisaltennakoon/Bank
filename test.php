<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Bank"; // Create connection
$conn = new mysqli($servername, $username, $password, $dbname); // Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO Branch(Branch_Name,Location)  VALUES ('Head Office','Colombo 1');";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>