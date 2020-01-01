<html>
<body>

<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
?>


<?php 
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
$query = "SELECT * FROM transaction_detail";
 
 
echo '<table border="0" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial">Transaction ID</font> </td> 
          <td> <font face="Arial">Account Number</font> </td> 
          <td> <font face="Arial">Amount</font> </td> 
          <td> <font face="Arial">Withdraw</font> </td> 
          <td> <font face="Arial">Date and Time</font> </td> 
      </tr>';
 
if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $field1name = $row["Transaction_ID"];
        $field2name = $row["Account_No"];
        $field3name = $row["Amount"];
        $field4name = $row["Withdraw"];
        $field5name = $row["Date_Time"]; 
 
        echo '<tr> 
                  <td>'.$field1name.'</td> 
                  <td>'.$field2name.'</td> 
                  <td>'.$field3name.'</td> 
                  <td>'.$field4name.'</td> 
                  <td>'.$field5name.'</td> 
              </tr>';
    }
    $result->free();
} 
?>
</body>
</html>