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
	<h1>Online Transfer</h1>
	<div class="formcontainer">
      <hr/>
  <div class="container"></div>
	<label for="sender_account"><strong>Choose the account</strong></label><br>

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
		
    <br><br><label for="RecipientAccNo"><strong>Enter Receiver Account Number</strong></label>
        <input type="number" id="RecipientAccNo" name="RecipientAccNo" placeholder="" onBlur="checkAvailability()"><span id="user-availability-status"></span>	
        
	<label for="amount"><strong>Enter the amount</strong></label>
        <input type="number" step="0.01" id="amount" name="amount" placeholder="0">		
		</div>
		<button type="submit">Transfer</button>
</form>
</body>
</html>