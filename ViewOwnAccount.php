<html>
<body>

<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: CustomerLogin.php');
}
?>
<?php
$customer_ID = $_SESSION['Customer_ID'];

?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	<label for="Account_No">Choose the account</label><br>

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

		$sql = "SELECT Account_No from account where Primary_Customer_ID=$customer_ID";
		$results = $conn->query($sql);
		if ($results->num_rows > 0){ 
		echo '<select name="Account_No" style="width: 400px; height: 40px">';
		
		while($rows = $results->fetch_assoc()){       //while loop
			echo '<option value="'.$rows['Account_No'].'">'.$rows['Account_No'].'</option>
			';
			
		}
		echo'</select>';	
		}else{
		echo "No Valid Accounts available";
		}
		?>
		<br>
		<br>
        <button type="submit">View Account</button>
</form>
<?php 

if(isset($_POST) & !empty($_POST)){
    $Account_No = $_POST['Account_No'];

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

$query = "SELECT * FROM transaction_detail WHERE Account_No='$Account_No' ORDER BY Transaction_ID";
 
 
echo '<table border="0" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial">Date and Time</font> </td>  
          <td> <font face="Arial">Amount</font> </td> 
          <td> <font face="Arial">Withdraw</font> </td> 
          <td> <font face="Arial">Balance</font> </td>
          <td> <font face="Arial">Detail</font> </td> 
          <td> <font face="Arial">Teller</font> </td>
      </tr>';
 
if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $field1name = $row["Date_Time"];
        $field2name = $row["Amount"];
        $field3name = $row["Withdraw"];
        $field4name = $row["Balance"];
        $field5name = $row["Detail"];
        $field6name = $row["Teller"]; 
 
        echo '<tr> 
                  <td>'.$field1name.'</td> 
                  <td>'.$field2name.'</td> 
                  <td>'.$field3name.'</td> 
                  <td>'.$field4name.'</td> 
                  <td>'.$field5name.'</td> 
                  <td>'.$field6name.'</td>
              </tr>';
    }
    $result->free();
} 
}
?>
</body>
</html>