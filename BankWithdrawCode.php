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
	echo "<br> Account Number - ".$_POST["AccNo"];
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
			  $sql = "UPDATE account SET Balance = Balance-'" . $_POST["amount"] . "'WHERE Account_No='".$_POST["AccNo"] ."';
				INSERT INTO transaction_detail(Account_No,Amount,Withdraw) values ('" . $_POST["AccNo"] . "','" . $_POST["amount"] . "',True);
				INSERT INTO bank_transaction (Transaction_ID) values ((SELECT LAST_INSERT_ID()));
				UPDATE savings_account SET Number_of_Withdrawals = Number_of_Withdrawals+1 WHERE Account_No='".$_POST["AccNo"] ."'";
				$conn->multi_query($sql);
 
				$sql = "SELECT Balance FROM account WHERE Account_No='" . $_POST["AccNo"] . "'";
				$results = $conn->query($sql);
				unset($_POST);
				$_POST=array();
				if ($results->num_rows > 0){
					while($rows = $results->fetch_assoc()) {
						echo "<br>Balance = " .$rows["Balance"]. "";
					}
				}						  
		  }	 
	}
  }
}
$conn->close();	
header( "refresh:6;url=BankTransaction.php" );
?>
