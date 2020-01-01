<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
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
      input[type=text], input[type=password], input[type=number]{
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

<form method="post" onSubmit = "return checkPassword(this)" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<h1>Issue a Checkbook</h1>
<div class="formcontainer">
      <hr/>
  <div class="container"></div>
<label for="Account_No"><strong>Account Number:</strong></label><input type="number" name="Account_No" required><br><br>
<label for="Starting_Check_Number"><strong>Starting Check Number:</strong></label><input type="number" name="Starting_Check_Number" required><br><br>
<label for="Number_of_Pages"><strong>Number of Pages</strong></label><select name="Number_of_Pages">
<option value="25">25 Leaves</option>
<option value="50">50 Leaves</option>
<option value="100">100 Leaves</option></select><br><br> 
</div>   
<button type="submit">Submit</button> 

<?php
if(isset($_POST) & !empty($_POST)){
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    $Account_No = test_input($_POST['Account_No']);
    $Starting_Check_Number = test_input($_POST['Starting_Check_Number']);
    $Number_of_Pages = test_input($_POST['Number_of_Pages']);

    $conn = new mysqli("localhost", "root", "","Bank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql ="SELECT Account_No FROM Account WHERE Account_No='$Account_No'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ 
            $sql ="SELECT Account_No FROM Checking_Account WHERE Account_No='$Account_No'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ 
                    $sql = "INSERT INTO Checkbook(Account_No,Number_of_Pages,Starting_Check_Number) VALUES ($Account_No,$Number_of_Pages,$Starting_Check_Number)";
                    if ($conn->query($sql) === TRUE) {
                        $Checkbook_Number = $conn->insert_id;
                        echo '<h3> Checkbook Number : '.$Checkbook_Number.'</h3>';
                        include 'ViewAccountDetailsFunction.php';
                        ViewAccountDetails($Account_No,$conn);
                    }else{
                        echo "Error updating record: " . $conn->error;
                    }
                }
            }else{
                echo '<font color=#ff0000><strong>Account Number is belongs to a savings account.Checkbooks cannot be issued for savings account.</strong></font>';
            }
        }
    }else{
        echo '<font color=#ff0000><strong>Account Number is not valid</strong></font>';
    }

    $conn->close();    
}
?>
<button onclick="myFunction()">Print this page</button>
<button onclick="window.location.href = 'home.php';">Home</button>
<script>
function myFunction() {
  window.print();
}

function checkPassword(form) { 
    password1 = form.password.value; 
    password2 = form.cpassword.value; 
    if (password1 != password2) { 
        document.getElementById("demo").innerHTML = "<font color=\"red\">Password doesn't Match</font>"; 
        return false; 
    }
    else{ 
        return true; 
    } 
} 
</script>
</form> 
</body>
</html>
