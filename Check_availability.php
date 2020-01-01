<?php   
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
if(!empty($_POST["AccNo"])) {
	echo "<br> Account Number - ".$_POST["AccNo"];
  $sql = "SELECT Balance FROM account WHERE Account_No='" . $_POST["AccNo"] . "'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
	  while($row = $result->fetch_assoc()) {
		echo "<span class='status-not-available'> <br>Balance = " .$row["Balance"]. "</span>";
	  }
  }else{
      echo "<span class='status-available'><br> This Account Number is not available.</span>";
  }
}	
?>