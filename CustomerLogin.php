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

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <h1>Customer Log In</h1>
 <div class="formcontainer">
      <hr/>
  <div class="container"></div>
  <label for="User"><strong>Username</strong></label>
  <input type="text" name="User" required>
  <br><br>
  <label for="password"><strong>Password</strong></label>
  <input type="password" name="password" required>
  <br><br>
  </div>
  <button type="submit">Login</button>


<?php
session_start();
if(isset($_POST) & !empty($_POST)){
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $user = test_input($_POST['User']);
  $pass =  test_input($_POST['password']);
  $pass=sha1($pass);    //little password encryption
  //echo $pass;
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

    $sql = "SELECT * FROM customer_login WHERE Username='$user' AND Password='$pass'";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $_SESSION['User'] = $row["Username"];
      $_SESSION['Customer_ID'] = $row["Customer_ID"];
      
      $result = $conn->query($sql);
      if ($result->num_rows > 0){
          while($row = $result->fetch_assoc()){ 
              $_SESSION['Primary_Branch_ID']= $row["Branch_ID"];
          }
      }else{
          echo  '<p><font color=ff0000>error</font></p>';
      }
      header("location: OnlineTransaction.php");
        //echo "<br> email: ". $row["email"]. " <br>Name: ". $row["name"]. " <br>password   " . $row["password"] . "<br>";
    }
  }else{
    echo "<p><font color=ff0000>The email address or password that you've entered doesn't match any account.</font></p>";
  }
//}else{
  //echo "The email address or password that you've entered doesn't match any account.";
//}
$conn->close();
}
?>
</form> 
</body>
</html>