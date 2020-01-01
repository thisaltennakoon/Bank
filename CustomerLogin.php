<!DOCTYPE html>
<html>
<body>
<h1>Bank A Seychelles</h1>
<h2>Customer Log In</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Username:
  <input type="text" name="User" required>
  <br><br>
  Password:
  <input type="password" name="password" required>
  <br><br>
  <input type="submit" value="Log In">
</form> 

<?php
session_start();
if(isset($_POST) & !empty($_POST)){
  $user = $_POST['User'];
  $pass =  $_POST['password'];
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
          echo 'error';
      }
      header("location: OnlineTransaction.php");
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