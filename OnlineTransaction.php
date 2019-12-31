<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: customerLogin.php');
}
?>

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function checkAvailability() {
	$("#loaderIcon").show();
	jQuery.ajax({
	url: "check_availability_name.php",
	data:'RecipientAccNo='+$("#RecipientAccNo").val(),
	type: "POST",
	success:function(data){
		$("#user-availability-status").html(data);
		$("#loaderIcon").hide();
	},
	error:function (){}
	});
}
</script>
<?php
$customer_ID = $_SESSION['Customer_ID'];

?>
<form method="post" action ="OnlineTransactionCode.php" enctype="multipart/form-data">

	<label for="sender_account">Choose the account</label><br>

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
		echo'<select name="SenderAccNo" style="width: 400px; height: 40px">';
		
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
    <label for="RecipientAccNo">Enter Receiver Account Number</label>
        <input type="text" id="RecipientAccNo" name="RecipientAccNo" placeholder="" onBlur="checkAvailability()"><span id="user-availability-status"></span>	
        <br>
		<br>
	<label for="amount">Enter the amount</label>
        <input type="text" id="amount" name="amount" placeholder="0">		
		<br>
		<button type="submit">Transfer</button>
</form>