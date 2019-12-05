<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
?>
<h2>Create a New Account</h2>
<button type="button" onclick="window.location.href='SavingsAccount.php'">Savings Account</button>
<button type="button" onclick="window.location.href='CheckingAccount.php'">Checking Account</button>

