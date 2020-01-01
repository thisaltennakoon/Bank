<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}?>
<!DOCTYPE html>
<html>
<body>
<h1>Bank A Seychelles</h1>
<h2>View Account Details</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Account Number:<input type="number" name="accnumber" required>
<br><br>
<input type="submit" value="Check">
</form> 
<?php
if(isset($_POST) & !empty($_POST)){
    $accnumber = $_POST['accnumber'];
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
    include 'ViewAccountDetailsFunction.php';
    ViewAccountDetails($accnumber,$conn);
    $conn->close();    
}
?>
<br>
<br>
<button onclick="myFunction()">Print this page</button>
<br>
<br>
<button onclick="window.location.href = 'home.php';">Home</button>
<script>
function myFunction() {
  window.print();
}
</script>
</body>
</html>
