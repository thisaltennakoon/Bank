<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
echo "This is home page<br>";
echo 'Username : '.$_SESSION['User'];
echo '<br>Employee_ID : '.$_SESSION['Employee_ID'];

echo '<br><a href="CreateaAccount.php">Create a Account</a>';
echo '<br><a href="LogOut.php">Log Out</a>';
?>