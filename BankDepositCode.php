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
  $sql = "UPDATE account SET Balance = Balance+'" . $_POST["amount"] . "'WHERE Account_No='".$_POST["AccNo"] ."';
  INSERT INTO transaction_detail(Account_No,Amount,Withdraw) values ('" . $_POST["AccNo"] . "','" . $_POST["amount"] . "',False);
  INSERT INTO bank_transaction (Transaction_ID) values ((SELECT LAST_INSERT_ID())); ";
  $conn->multi_query($sql);
 
  $sql = "SELECT Balance FROM account WHERE Account_No='" . $_POST["AccNo"] . "'";
  $result = $conn->query($sql);
  unset($_POST);
  $_POST=array();
  if ($result->num_rows > 0){
	  while($row = $result->fetch_assoc()) {
		echo "<br>Balance = " .$row["Balance"]. "";
	  }
  }
}
$conn->close();	
header( "refresh:3;url=BankTransaction.php" );
?>
