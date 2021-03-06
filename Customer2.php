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
      input[type=text], input[type=password],input[type=number] {
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
<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}

if(isset($_POST) & !empty($_POST) ){
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }


    $Primary_Customer=test_input($_POST['Primary_Customer']);

    $Customer_String="";
    $NIC_arr=$_SESSION['NIC_arr'];
    $Other_branches=$_SESSION['Other_branches'];

    $conn = mysqli_connect("localhost", "root", "","Bank");
    foreach($NIC_arr as $NIC){
        $Customer_ID = test_input($_POST[$NIC."-Customer_ID"]);
        $InsertOrUpdate = test_input($_POST[$NIC."-InsertOrUpdate"]);
        $firstname = test_input($_POST[$NIC."-firstname"]);
        $middlename = test_input($_POST[$NIC."-middlename"]);
        $lastname = test_input($_POST[$NIC."-lastname"]);
        $DOB = test_input($_POST[$NIC."-DOB"]);
        $adr1 = test_input($_POST[$NIC."-adr1"]);
        $adr2 = test_input($_POST[$NIC."-adr2"]);
        $adr3 = test_input($_POST[$NIC."-adr3"]);
        $email = test_input($_POST[$NIC."-email"]);
        $contactnumber = test_input($_POST[$NIC."-contactnumber"]);
        $Gender = test_input($_POST[$NIC."-Gender"]);
        $NIC = test_input($_POST[$NIC."-NIC"]);        
        if ($InsertOrUpdate=="Insert"){
            $stmt = $conn->prepare("INSERT INTO Customer (Address_Line_1,Address_Line_2,Address_Line_3,Primary_Email,Primary_Contact_No) VALUES (?,?,?,?,?)");   
            $stmt->bind_param("sssss",$adr1,$adr2,$adr3,$email,$contactnumber);
            if ($stmt->execute() === TRUE) {
                $Customer_ID = $conn->insert_id;
                $stmt = $conn->prepare("INSERT INTO Individual (Customer_ID,First_Name,Middle_Name,Last_Name,NIC,DOB,Gender) VALUES (?,?,?,?,?,?,?)");   
                $stmt->bind_param("sssssss",$Customer_ID,$firstname,$middlename,$lastname,$NIC,$DOB,$Gender);
                if ($stmt->execute() === TRUE) {
                    $Customer_String=$Customer_String.$Customer_ID.',';
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        elseif($InsertOrUpdate=="Update"){
            $stmt = $conn->prepare("UPDATE Customer SET Address_Line_1=?,Address_Line_2=?,Address_Line_3=?,Primary_Email=?,Primary_Contact_No=? WHERE Customer_ID=?");   
            $stmt->bind_param("ssssss",$adr1,$adr2,$adr3,$email,$contactnumber,$Customer_ID);
            if ($stmt->execute() === TRUE) {
                $stmt = $conn->prepare("UPDATE Individual SET First_Name=?,Middle_Name=?,Last_Name=?,DOB=?,Gender=? WHERE Customer_ID=?");   
                $stmt->bind_param("ssssss",$firstname,$middlename,$lastname,$DOB,$Gender,$Customer_ID);
                if ($stmt->execute() === TRUE) {
                    $Customer_String=$Customer_String.$Customer_ID.',';
                } else {
                    echo "Error updating record: to Individual " . $conn->error;
                }
            } else {
                echo "Error updating record: to Customer " . $conn->error;
            }
        }


    }
    $stmt->close();
    mysqli_close($conn);
    $Customer_Str=substr($Customer_String,0, -1);
    $_SESSION['Customer_Str']=$Customer_Str;
    $_SESSION['Primary_Customer']=$Primary_Customer;
    echo '<form method="post" action="Account.php">
	<h1>Select Account Type</h1><br>
	<div class="formcontainer">
      <hr/>
  	<div class="container"></div>';
    echo '<input type="radio" name="AccountType" value="Savings" required> <strong>Savings Account</strong><br>';
    echo '<input type="radio" name="AccountType" value="Checking"> <strong>Checking Account</strong><br> </div>';
    echo '<button type="submit">Next</button>';
    echo '</form>';
}
?>
</body>

</html>
