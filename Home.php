<!DOCTYPE html>
<html>
<head>
    <title>Simple login form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
	.header {
  	background-color: #ff4500;
	width: 100%;
	
    background-size: 100%;
	background-repeat: no-repeat;
    background-size: cover;
    margin-left: auto;
    margin-right: auto;
  	padding: 20px;
  	text-align: center;
	position: absolute;
  	left: 0px;
  	top: 0px;
	}
      html {
      display: flex;
      justify-content: center;
      font-family: Roboto, Arial, sans-serif;
      font-size: 15px;
      } 
	  body {
      display: flex;
      justify-content: center;
      font-family: Roboto, Arial, sans-serif;
      font-size: 15px;
	  background-color: #FF8C00;
	  
      }
      form {
      border: 6px solid #FF7F50;
	  padding: 25px 50px;
	  position: absolute;
  	  top: 120px;
	  background-color: #FF7F50;
      }
      input[type=text], input[type=password] {
      width: 100%;
      padding: 16px 8px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
      }
      button {
      background-color: #006400;
      color: white;
      padding: 14px 0;
      margin: 10px 0;
      border: none;
      cursor: grabbing;
      width: 100%;
      }
	  button.logout {
      background-color: #8b0000;
      color: white;
      padding: 14px 0;
      margin: 10px 0;
      border: none;
      cursor: grabbing;
      width: 100%;
      }
      h1 {
      text-align:center;
      fone-size:18;
      }
      button:hover {
      background-color: #00FF00;
      }
	  button.logout:hover {
      background-color: #ff0000;
      }
      .formcontainer {
      text-align: left;
      margin: 24px 50px 12px;
	  position: absolute;
  	  top: 120px;
	  
      }
      .container {
      padding: 16px 0;
      text-align:left;
      }
      span.psw {
      float: right;
      padding-bottom: 0;
      padding-right: 15px;
      }
	  span.aaa {
      float: left;
      padding-bottom: 0;
      padding-left: 15px;
      }
      /* Change styles for span on extra small screens */
      @media screen and (max-width: 300px) {
      span.psw {
      display: block;
      float: none;
      }
    </style>
  </head>
  <div class="header">
  <h1>BANK A SEYCHELLES</h1>
</div>
<body>
<h1>Home page</h1>
  
   <div class="formcontainer">
      <hr/>
	  
  <div class="container"></div>
  
  
	
	<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
//echo "<h1>Home page</h1><br>";
echo '<label><strong>Username : </strong></label>'.$_SESSION['User'];
$Employee_ID=$_SESSION['Employee_ID'];
$Branch_ID =$_SESSION['Primary_Branch_ID'];
$EmployeeType=$_SESSION['EmployeeType'];

$conn = new mysqli("localhost", "root", "","Bank");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql ="SELECT Branch_Name FROM Branch WHERE Branch_ID='$Branch_ID'";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){ 
        echo '<br><label><strong>Branch : </strong></label>'.$row["Branch_Name"];
    }
}else{
    echo 'error';
}
$sql ="SELECT * FROM Employee WHERE Employee_ID='$Employee_ID'";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){ 
        echo '<br><label><strong>Employee Name : </strong></label>'.$row["First_Name"].' '. $row["Middle_Name"].' '. $row["Last_Name"];
    }
}else{
    echo 'error';
}

?>
<button onclick="window.location.href = 'BankTransaction.php'">Bank Transaction</button> 
<button onclick="window.location.href = 'CreateOnlineBankingAccount.php'">Create Online Banking Account</button> 
<button onclick="window.location.href = 'MakeaLoanRequest.php'">Make a Loan Request</button> 
<?php
if ($EmployeeType=="Manager"){
echo '<button onclick="window.location.href = \'ApproveRequestedLoan.php\'">Approve Requested Loan</button>'; 
}
?>
<button onclick="window.location.href = 'Customer.php'">Create a Bank Account</button> 
<button onclick="window.location.href = 'ViewAccountDetails.php'">View Account Details</button> 
<button onclick="window.location.href = 'IssueCheckBooks.php'">Issue Check Books</button> 
<?php
if ($EmployeeType=="Manager"){
echo '<button onclick="window.location.href = \'CreateanEmployee.php\'">Create an Employee</button>';
}
?>
<button class='logout' onclick="window.location.href = 'LogOut.php'">Log Out</button>
</div>
</body>
</html>