<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
?>

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function checkAvailability() {
	$("#loaderIcon").show();
	jQuery.ajax({
	url: "check_availability.php",
	data:'AccNo='+$("#AccNo").val(),
	type: "POST",
	success:function(data){
		$("#user-availability-status").html(data);
		$("#loaderIcon").hide();
	},
	error:function (){}
	});
}
</script>

<form method="post" action ="AtmWithdrawalCode.php" enctype="multipart/form-data">
<label for="ATM_no">ATM Number</label>
        <input type="text" id="ATM_No" name="ATM_No" placeholder="1">		
		<br>
    <label for="AccNo">Enter Account Number</label>
        <input type="text" id="AccNo" name="AccNo" placeholder="" onBlur="checkAvailability()"><span id="user-availability-status"></span>	
        <br>
		<br>
	<label for="amount">Enter the amount</label>
        <input type="text" id="amount" name="amount" placeholder="0">		
		<br>
		<button type="submit">ATM Withdraw</button>
</form>
</form>