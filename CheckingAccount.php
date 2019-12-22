<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}

if(isset($_POST) & !empty($_POST)){
    $Customer_Str=$_SESSION['Customer_Str'];
    $Primary_Customer=$_SESSION['Primary_Customer'];
    $NIC_arr=$_SESSION['NIC_arr'];
    $Other_branches=$_SESSION['Other_branches'];

    $AccountType = $_POST['AccountType'];
    echo '<h1>Application- '.$AccountType.' Checking Account</h1>';
    echo '<form method="post" action="CreateCheckingAccount.php">';
    //echo'<input type="hidden" name="NICs" value="'.$NICs.'">';
    echo '<input type="hidden" name="AccountType" value="'.$AccountType.'">';
    echo'Primary Customer<input type="text" name="Primary_Customer" value="'.$Primary_Customer.'" readonly><br><br>';
    echo'Other Customers<input type="text" name="Other_Customers" value="'.$Customer_Str.'" readonly><br><br>';
    if ($AccountType=='Organizational'){
        echo 'Enter Bussiness/Organization Registration Number <input type="text" name="Registration_Number" required><br><br>';
        echo 'Organization Name <input type="text" name="Name" required><br><br>';
        echo'Address Line 1:<input type="text" name="adr1"><br><br>';
        echo'Address Line 2:<input type="text" name="adr2"><br><br>';
        echo'Address Line_3:<input type="text" name="adr3"><br><br>';
        echo'Email:<input type="email" name="email" required><br><br>';
        echo'Contact Number:<input type="text" name="contactnumber"><br><br>';
    }

    echo'<br><br>Account Status<select name="Account_Status">';
    echo'<option value="Active" selected>Active</option>';
    echo'<option value="Inactive">Inactive</option>';
    echo'<option value="Cancelled">Cancelled</option></select>';
    echo'<br><br><input type="submit" value="Create Account">';
    echo'</form>';
}
