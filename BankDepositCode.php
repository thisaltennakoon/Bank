<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
?>


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
  $sql = "SET autocommit = OFF;
  START TRANSACTION;
  UPDATE account SET Balance = Balance+'" . $_POST["amount"] . "'WHERE Account_No='".$_POST["AccNo"] ."';
  INSERT INTO transaction_detail(Account_No,Amount,Withdraw,Balance,Detail,Teller) values ('" . $_POST["AccNo"] . "','" . $_POST["amount"] . "',False,(SELECT balance from account WHERE Account_No='".$_POST["AccNo"] ."'),'BNK','".$_SESSION['User']."');
  INSERT INTO bank_transaction (Transaction_ID) values ((SELECT LAST_INSERT_ID())); 
  COMMIT;";
  echo "Deposit Successful";
  $conn->multi_query($sql);
 

}
$conn->close();	
header( "refresh:2;url=BankTransaction.php" );
?>
