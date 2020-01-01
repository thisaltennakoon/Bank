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
      input[type=text], input[type=password], input[type=number] {
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
<h1>Create Online Banking Account</h1>
<div class="formcontainer">
      <hr/>
<div class="container"></div>
<label for="Customer_ID"><strong>Customer ID</strong></label><input type="number" name="Customer_ID" required><br><br>

<label for="username"><strong>Username</strong></label><input type="text" name="username" required><br><br>

<label for="password"><strong>Password</strong></label><input type="password" name="password" required><br><br>

<label for="cpassword"><strong>Confirm Password</strong></label><input type="password" name="cpassword" required>  <p id="demo"></p>  

<label for="RecoveryContactNumber"><strong>Recovery Contact Number</strong></label><input type="text" name="RecoveryContactNumber" required><br><br>

<label for="RecoveryEmail"><strong>Recovery Email</strong></label><input type="text" name="RecoveryEmail" required><br><br>
 </div> 
<button type="submit"> Submit </button>

<?php
if(isset($_POST) & !empty($_POST)){
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

    $Customer_ID = test_input($_POST['Customer_ID']);
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $password=sha1($password);
    $RecoveryContactNumber = test_input($_POST['RecoveryContactNumber']);
    $RecoveryEmail = test_input($_POST['RecoveryEmail']);

    $conn = mysqli_connect("localhost", "root", "","Bank");
    $stmt = $conn->prepare("INSERT INTO Customer_Login(Customer_ID,Username,Password,Recovery_Contact_No,Recovery_Email) VALUES (?,?,?,?,?)");   
    $stmt->bind_param("issss",$Customer_ID,$username,$password,$RecoveryContactNumber,$RecoveryEmail);

    if ($stmt->execute() === TRUE) {
        echo '<p><font color=#006400>Customer Login Created Successful.</font></p>';
    }else{
        echo "<p><font color=#ff0000>Error updating record. </font></p>" . $conn->error;
    }

    $stmt->close();
    mysqli_close($conn);    
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
