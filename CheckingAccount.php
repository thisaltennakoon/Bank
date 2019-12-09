<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
echo "<h1>Application for Creating Checking Account</h1><br>";
?>
<!DOCTYPE html>
<html>
<body>
<form method="post" action="CheckingAccount1.php">
    Enter Bussiness Registration Number:<input type="text" name="BRN" required>
    <input type="submit" value="Apply"><br><br>
</form>

</body>
</html>