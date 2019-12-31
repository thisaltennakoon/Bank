<?php 
// connected with AJAX code to display name of the receiver in online transaction. Have to code this
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Bank"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname); 

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if(!empty($_POST["RecipientAccNo"])) {
echo "<br> Account Number - ".$_POST["RecipientAccNo"];
$sql = "SELECT First_Name,Last_Name From individual WHERE Customer_ID = (SELECT Primary_Customer_ID FROM account WHERE Account_No='" . $_POST["RecipientAccNo"] . "')";
$sql2 = "SELECT Organization_Name From Organization WHERE Customer_ID = (SELECT Primary_Customer_ID FROM account WHERE Account_No='" . $_POST["RecipientAccNo"] . "')";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
if ($result->num_rows > 0){
  while($row = $result->fetch_assoc()) {
    echo "<span class='status-not-available'> <br>Name = " .$row["First_Name"]. " ".$row["Last_Name"]." </span>";
 
  }
}elseif($result2->num_rows > 0){
  while($row2 = $result2->fetch_assoc()) {
    echo "<span class='status-not-available'> <br>Name = " .$row2["Organization_Name"]. " </span>";
 
  }
}else{
    echo "<span class='status-available'><br> This Account Number is not available.</span>";
}
}	
?>