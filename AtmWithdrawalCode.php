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
$dbname = "bank"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(!empty($_POST["AccNo"])) {
	
  $sql = "SELECT Number_of_Withdrawals,Account_Plan_ID,Balance FROM savings_account NATURAL JOIN account WHERE Account_No='". $_POST["AccNo"] ."'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
	  while($row = $result->fetch_assoc()) {
		  
		  $remainder= $row["Balance"]-$_POST["amount"];
		  if ($row["Account_Plan_ID"]==1 ){
			  echo " This is a Child Account. Cannot withdraw money";
		  }elseif ($row["Number_of_Withdrawals"]>=5){
			  echo " Monthly withrawal limit exceeded. cannot withdraw money";
		  }elseif ( $remainder <1000 and $row["Account_Plan_ID"]==(3 or 4)){			  
		  echo "Account Balance is insufficient";
		  }elseif ( $remainder <500 and $row["Account_Plan_ID"]==2){			  
			  echo "Account Balance is insufficient";
		  }else{
			  $sql = "SET autocommit = OFF;
                START TRANSACTION;
                UPDATE account SET Balance = Balance-'" . $_POST["amount"] . "'WHERE Account_No='".$_POST["AccNo"] ."';
				INSERT INTO transaction_detail(Account_No,Amount,Withdraw) values ('" . $_POST["AccNo"] . "','" . $_POST["amount"] . "',True);
				INSERT INTO atm_withdrawal (Transaction_ID,ATM_ID) values ((SELECT LAST_INSERT_ID()),'".$_POST["ATM_No"]."');
                UPDATE savings_account SET Number_of_Withdrawals = Number_of_Withdrawals+1 WHERE Account_No='".$_POST["AccNo"] ."';
                COMMIT;";
                echo "ATM withdrwal successful";
				$conn->multi_query($sql);

				unset($_POST);
				$_POST=array();
						  
		  }	 
	}
  }
}
$conn->close();	
header( "refresh:3;url=AtmWithdrawal.php" );
?>