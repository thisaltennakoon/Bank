<?php
	session_start();
	unset($_SESSION['User']);		
	unset($_SESSION['Employee_ID']);
	header('location: CustomerLogin.php');
?>