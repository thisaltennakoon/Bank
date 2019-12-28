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

<form method="post" action ="BankWithdrawCode.php" enctype="multipart/form-data">

    <label for="AccNo">Enter Account Number</label>
        <input type="text" id="AccNo" name="AccNo" placeholder="" onBlur="checkAvailability()"><span id="user-availability-status"></span>	
        <br>
		<br>
	<label for="amount">Enter the amount</label>
        <input type="text" id="amount" name="amount" placeholder="0">		
		<br>
		<button type="submit" formaction="BankWithdrawCode.php">Withdraw</button>
		<button type="submit" formaction="BankDepositCode.php">Deposit</button>
</form>