<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
?>
<h2>Create a New Account</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Address:
  <input type="text" name="Address" require>
  <br><br>
  Email:
  <input type="email" name="email" require>
  <br><br>
  Contact Number:
  <input type="text" name="contactno" require>
  <br><br>
  <select name="account_type">
  <option value="savings">Savings Account</option>
  <option value="checking">Checking Account</option>
  </select>
  <input type="submit" value="Next">
</form> 

<?php
if(isset($_POST) & !empty($_POST)){
  $address = $_POST['Address'];
  $email =  $_POST['email'];
  $contactno =  $_POST['contactno'];
  $account_type =  $_POST['account_type'];

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
  $sql = "INSERT INTO Customer(Address,Email,Contact_No) VALUES ()";
  CREATE TABLE Customer(
    Customer_ID INT UNSIGNED AUTO_INCREMENT,
    Address VARCHAR(80),
    Email VARCHAR(50),
    Contact_No VARCHAR(10), 
    PRIMARY KEY(Customer_ID)
);


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
