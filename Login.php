<!DOCTYPE html>
<html>
<body>
<h2>Multi Banking System</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Username:
  <input type="text" name="User" require>
  <br><br>
  Password:
  <input type="password" name="password" require>
  <br><br>
  <input type="submit" value="Log In">
</form> 
<p>Don't you have an account?  <a href="SignUp.php">Sign Up</a></p> 
<?php
session_start();
if(isset($_POST) & !empty($_POST)){
  $user = $_POST['User'];
  $pass =  $_POST['password'];
  //$pass=sha1($pass);    //little password encryption
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
  $sql = "SELECT * FROM Employee_Login WHERE Username='$user' AND Password='$pass'";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $_SESSION['User'] = $row["Username"];
      $_SESSION['Employee_ID'] = $row["Employee_ID"];
      echo $user;
      echo $pass;
      header("location: home.php");
        //echo "<br> email: ". $row["email"]. " <br>Name: ". $row["name"]. " <br>password   " . $row["password"] . "<br>";
    }
  }else{
    echo "The email address or password that you've entered doesn't match any account.";
  }
//}else{
  //echo "The email address or password that you've entered doesn't match any account.";
//}
$conn->close();
}
?>
</body>
</html>