<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
echo "<h1>Application for Creating Savings Account</h1><br>";
?>
<!DOCTYPE html>
<html>
<body>
<form method="post" action="SavingsAccount1.php">
    Enter NIC:<input type="text" name="NIC" required>
    <input type="submit" value="Apply"><br><br>
</form>

</body>
</html>