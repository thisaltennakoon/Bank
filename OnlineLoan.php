<?php
session_start();
if(!isset($_SESSION["User"]) & empty($_SESSION["User"])){
    header('location:CustomerLogin.php');
}
?>

<!DOCTYPE html>
<html>
<body>

<h1>Step 1 : Select Account</h1><br>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Enter Account No:<input type="text" name="AccNo" size="50" required>
    
    <br><input type="submit" value="Next"><br><br>
</form>


<?php
if(isset($_POST) & !empty($_POST)){
  $AccNo = $_POST['AccNo'];
  
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

    $sql = "SELECT * FROM Account WHERE Account_No='$AccNo'";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $AccNo=$row['Account_No'];
      $_SESSION['AccNo']=$AccNo;
      header("location: OnlineLoan1.php");
        //echo "<br> email: ". $row["email"]. " <br>Name: ". $row["name"]. " <br>password   " . $row["password"] . "<br>";
    }
  }else{
    echo "There is no account with this account no. Please check your account no";
  }
//}else{
  //echo "The email address or password that you've entered doesn't match any account.";
//}
$conn->close();
}
?>


<br><a href="LogOut.php">Log Out</a>
</body>

</html>