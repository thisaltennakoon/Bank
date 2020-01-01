<?php
session_start();
if(!isset($_SESSION["User"]) & empty($_SESSION["User"])){
    header('location:login.php');

    $AccNo=$_GET["AccNo"];
    echo $AccNo;
}
?>


<!DOCTYPE html>
<html>
<body>

<h1>Step 2 : Enter Details</h1><br>

<form method="post" action="ViewLoanDetails.php">
    Enter Loan Amount:<input type="text" name="Amount" size="50" required>
    <br><br>
    Enter Time Period:<input type="text" name="Time" size="50" required>

    
    
    <br><input type="submit" value="Next"><br><br>
</form>

<br><br><a href="LogOut.php">Log Out</a>
</body>

</html>