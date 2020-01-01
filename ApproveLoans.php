<?php
session_start();
if(!isset($_SESSION["User"]) & empty($_SESSION["User"])){
    header('location:login.php');
}
?>

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
      h1 {
      text-align:center;
      fone-size:18;
      }
      button:hover {

        background-color: #00FF00;

      }
      .formcontainer {
      text-align: left;
      margin: 24px 50px 12px;
	  
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
<form>

<?php

    echo "<h1>Approve qualified loans</h1>";
	

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql= "SELECT * FROM requested_loan WHERE Request_Status='Pending'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $AccNo=$row['Account_No'];
          $Branch=$row['Branch_ID'];
          $Amount=$row['Amount'];
          $Time=$row['Time_Period'];
          $Installment=$row['Installment'];
          $RequestedBy=$row['Requested_By'];
          $RequestID=$row['Request_ID'];

          echo 'Account No : '.$AccNo;
          echo '<br>Branch : '.$Branch;
          echo '<br>Amount : '.$Amount;
          echo '<br>Time Period : '.$Time;
          echo '<br>Installment : '.$Installment;
          echo '<br><button onclick=approve("'.$AccNo.'","'.$Branch.'","'.$Amount.'","'.$Time.'","'.$Installment.'","'.$RequestedBy.'","'.$RequestID.'")>Approve</button><hr>';

          
        
        }
    }else{
        
    }

?>

<script>
    function approve(AccNo,Branch,Amount,Time,Installment,RequestBy,RequestID){
        window.location.href="ApproveLoans1.php?AccNo="+AccNo+"& Branch="+Branch+"& Amount="+Amount+"& Time="+Time+"& Installment="+Installment+"& RequestBy="+RequestBy+"& RequestID="+RequestID;
        //window.location.href = 'home.php';

    }

</script>
</div>
</form>

</body>

</html>