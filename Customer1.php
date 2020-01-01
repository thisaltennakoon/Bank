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
      input[type=text], input[type=password],input[type=number], input[type=email] {
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

    $NICs = $_POST['NICs'];
    $Other_branches = $_POST['Other_branches'];
    $Branch_string="";
    $NIC_arr = explode (",", $NICs); 
    $NIC_arr_new=array();
    foreach($NIC_arr as $i){
        $i=trim($i);
        array_push($NIC_arr_new,$i);
    }
    $NIC_arr=$NIC_arr_new;
    array_unique($NIC_arr);
    $_SESSION['NIC_arr'] = $NIC_arr;
    $Other_branches_new=array();
    foreach($Other_branches as $i){
        $i=trim($i);
        array_push($Other_branches_new,$i);
    }
    $Other_branches=$Other_branches_new;
    $_SESSION['Other_branches'] = $Other_branches;
    echo'<form method="post" action="Customer2.php">';
	echo'<form method="post" action="ViewFDDetails.php">
	<h1>Enter Customer details</h1>
	<div class="formcontainer">
      <hr/>
  	<div class="container"></div>';
    $conn = mysqli_connect("localhost", "root", "","Bank");
    foreach($NIC_arr as $NIC){
        $stmt = $conn->prepare("SELECT Customer_ID,First_Name,Last_Name,Middle_Name,DOB,Gender FROM Individual WHERE NIC=?");
        $stmt->bind_param("s",$NIC);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($Customer_ID,$First_Name,$Last_Name,$Middle_Name,$DOB,$Gender);
        if ($stmt->num_rows >0) {
            while ($row = $stmt->fetch()) {
                $str1="";
                $str2="";
                $str3="";
                if ($Gender=="Male"){
                    $str1="selected";
                }
                elseif ($Gender=="Female"){
                    $str2="selected";
                }
                elseif ($Gender=="Other"){
                    $str3="selected";
                }   
            }

 


            $stmt = $conn->prepare("SELECT Address_Line_1,Address_Line_2,Address_Line_3,Primary_Email,Primary_Contact_No FROM Customer WHERE Customer_ID=?");
            $stmt->bind_param("i",$Customer_ID);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($Address_Line_1,$Address_Line_2,$Address_Line_3,$Primary_Email,$Primary_Contact_No);
            if ($stmt->num_rows >0) {
                while ($row = $stmt->fetch()) {

                }
            }else{
                echo 'error';
            }

            echo'<input type="hidden" name="'.$NIC.'-InsertOrUpdate" value="Update">';
            echo'<input type="hidden" name="'.$NIC.'-Customer_ID" value="'.$Customer_ID.'">';
            echo'<label for="'.$NIC.'-NIC"><strong>NIC:</strong></label><input type="text" name="'.$NIC.'-NIC" value="'.$NIC.'" readonly>';  
            echo'<input type="radio" name="Primary_Customer" value="'.$NIC.'" required>Select As Primary Customer<br><br>';
            echo'<label for="'.$NIC.'-firstname"><strong>First Name:</strong></label><input type="text" name="'.$NIC.'-firstname" value="'.$First_Name.'" required>';
            echo'<label for="'.$NIC.'-middlename"><strong>Middle Name:</strong></label><input type="text" name="'.$NIC.'-middlename" value="'.$Last_Name.'" required>';
            echo'<label for="'.$NIC.'-lastname"><strong>Last Name:</strong></label><input type="text" name="'.$NIC.'-lastname" value="'.$Middle_Name.'" required>';
            echo'<label for="'.$NIC.'-DOB"><strong>Date of Birth:</strong></label><input type="date" name="'.$NIC.'-DOB" value="'.$DOB.'" required><br><br>';
            echo'<label for="'.$NIC.'-adr1"><strong>Address Line 1:</strong></label><input type="text" name="'.$NIC.'-adr1" value="'.$Address_Line_1.'" onchange="myFunction()" required>';
            echo'<label for="'.$NIC.'-adr2"><strong>Address Line 2:</strong></label><input type="text" name="'.$NIC.'-adr2" value="'.$Address_Line_2.'" onchange="myFunction()" required>';
            echo'<label for="'.$NIC.'-adr3"><strong>Address Line_3:</strong></label><input type="text" name="'.$NIC.'-adr3" value="'.$Address_Line_3.'" onchange="myFunction()" required>';
            echo'<label for="'.$NIC.'-email"><strong>Email:</strong></label><input type="email" name="'.$NIC.'-email" value="'.$Primary_Email.'" required><br><br>';
            echo'<label for="'.$NIC.'-contactnumber"><strong>Contact Number:</strong></label><input type="text" name="'.$NIC.'-contactnumber" value="'.$Primary_Contact_No.'" required>';
            echo'<select name="'.$NIC.'-Gender">';
            echo'<option value="Male" '.$str1.'>Male</option>';
            echo'<option value="Female" '.$str2.'>Female</option>';
            echo'<option value="Other" '.$str3.'>Other</option></select>';
        }else{
            echo'<input type="hidden" name="'.$NIC.'-InsertOrUpdate" value="Insert">';
            echo'<input type="hidden" name="'.$NIC.'-Customer_ID" value="notset">';
            echo'<label for="'.$NIC.'-NIC"><strong>NIC:</strong></label><input type="text" name="'.$NIC.'-NIC" value="'.$NIC.'" readonly>';
            echo'<input type="radio" name="Primary_Customer" value="'.$NIC.'" required><strong>Select As Primary Customer</strong><br><br>';
            echo'<label for="'.$NIC.'-firstname"><strong>First Name:</strong></label><input type="text" name="'.$NIC.'-firstname" required>';
            echo'<label for="'.$NIC.'-middlename"><strong>Middle Name:</strong></label><input type="text" name="'.$NIC.'-middlename">';
            echo'<label for="'.$NIC.'-lastname"><strong>Last Name:</strong></label><input type="text" name="'.$NIC.'-lastname">';
            echo'<label for="'.$NIC.'-DOB"><strong>Date of Birth:</strong></label><input type="date" name="'.$NIC.'-DOB" required><br><br>';
            echo'<label for="'.$NIC.'-adr1"><strong>Address Line 1:</strong></label><input type="text" name="'.$NIC.'-adr1">';
            echo'<label for="'.$NIC.'-adr2"><strong>Address Line 2:</strong></label><input type="text" name="'.$NIC.'-adr2">';
            echo'<label for="'.$NIC.'-adr3"><strong>Address Line_3:</strong></label><input type="text" name="'.$NIC.'-adr3">';
            echo'<label for="'.$NIC.'-email"><strong>Email:</strong></label><input type="email" name="'.$NIC.'-email" required>';
            echo'<label for="'.$NIC.'-contactnumber"><strong>Contact Number:</strong></label><input type="text" name="'.$NIC.'-contactnumber" required>';
            echo'<select name="'.$NIC.'-Gender">';
            echo'<option value="Male">Male</option>';
            echo'<option value="Female">Female</option>';
            echo'<option value="Other">Other</option></select>';
        }

        echo "<br><hr><br> </div>";
    }
    $stmt->close();
    mysqli_close($conn);

    echo'<button type="submit">Next</button>';
	echo '<br><a href="LogOut.php">Log Out</a>';
    echo'</form>';

}
    echo '<br><a href="LogOut.php">Log Out</a>';
?>
</body>

</html>