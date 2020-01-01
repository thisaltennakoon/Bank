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

    $Customer_Str=$_SESSION['Customer_Str'];
    $Primary_Customer=$_SESSION['Primary_Customer'];
    $NIC_arr=$_SESSION['NIC_arr'];
    $Other_branches=$_SESSION['Other_branches'];

    


    $Customer_arr = explode (",", $Customer_Str);
    $AccountType = $_POST['AccountType'];
    //$Employee_ID=$_SESSION['Employee_ID'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 
    $sql ="SELECT Customer_ID FROM Individual WHERE NIC='$Primary_Customer'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ 
            $Primary_Customer= $row["Customer_ID"];
        }
    }else{
        echo 'error';
    }
    $_SESSION['Primary_Customer']=$Primary_Customer;
    if ($AccountType=="Savings"){   
       
        echo '<form method="post" action="SavingsAccount.php">';
		echo '<h1>Application-Savings Account</h1>
		<div class="formcontainer">
      <hr/>
  <div class="container"></div>';
        echo'<label for="Primary_Customer"><strong>Primary Customer</strong></label><input type="text" name="Primary_Customer" value="'.$Primary_Customer.'" readonly><br><br>';
        echo'<label for="Other_Customers"><strong>Other Customers</strong></label><input type="text" name="Other_Customers" value="'.$Customer_Str.'" readonly><br><br>';
        $sql = "SELECT * FROM Savings_Account_Plan"; //reading things from the table
        $result = $conn->query($sql);
        echo'<br><strong>Account Type</strong><select name="Account_Type">';
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){       //while loop
                //echo $row["bankname"];
                echo "<option   value=".$row["Plan_ID"].">".$row["Account_Plan"]."</option>";
            }
            echo "</select>";   
        }else{
            
        }
        echo'<br><br><strong>Account Status</strong><select name="Account_Status">';
        echo'<option value="Active" selected>Active</option>';
        echo'<option value="Inactive">Inactive</option>';
        echo'<option value="Cancelled">Cancelled</option></select> </div>';
        echo'<button type="submit"> Create the Savings Account</button>';
        echo'</form>';
        $conn->close();

    }
    elseif($AccountType=="Checking"){
        echo '<form method="post" action="CheckingAccount.php">
		<div class="formcontainer">
      <hr/>
  <div class="container"></div>';
		 echo '<h1>Application-Savings Account</h1>';
        echo '<input type="radio" name="AccountType" value="Organizational" required><strong>Organizational Checking Account</strong><br>';
        echo '<input type="radio" name="AccountType" value="Non-Organizational"><strong>Non-Organizational Checking Account</strong><br></div>';
        echo '<button type="submit">Next</button>';
        echo '</form>';

    }
   
}
?>
</body>

</html>
