<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}

if(isset($_POST) & !empty($_POST) & isset($_POST['Primary_Customer'])){
    $Branch_Str = $_POST['Branch_Str'];
    $NICs = $_POST['NICs'];
    $Primary_Customer = $_POST['Primary_Customer'];
    $Customer_String = $_POST['Customer_String'];
    $Account_Type = $_POST['AccountType'];
    echo '<h1>Application- '.'$Account_Type'.' Checking Account</h1>';
    echo '<form method="post" action="CreateCheckingAccount.php">';
    echo'<input type="hidden" name="Branch_Str" value="'.$Branch_Str.'">';
    echo'<input type="hidden" name="Account_Type" value="'.$Account_Type.'">';
    echo'Primary Customer<input type="text" name="Primary_Customer" value="'.$Primary_Customer.'" readonly><br><br>';
    echo'Other Customers<input type="text" name="Other_Customers" value="'.$Customer_String.'" readonly><br><br>';
    if ($Account_Type=='Organizational'){
        echo 'Enter Bussiness/Organization Registration Number <input type="text" name="Registration_Number" required>';
        echo 'Organization Name <input type="text" name="Name" required>';
    }
    echo'Address Line 1:<input type="text" name="adr1"><br><br>';
    echo'Address Line 2:<input type="text" name="adr2"><br><br>';
    echo'Address Line_3:<input type="text" name="adr3"><br><br>';
    echo'Email:<input type="email" name="email" required><br><br>';
    echo'<br><br>Account Status<select name="Account_Status">';
    echo'<option value="Active" selected>Active</option>';
    echo'<option value="Inactive">Inactive</option>';
    echo'<option value="Cancelled">Cancelled</option></select>';
    echo'<br><br><input type="submit" value="Create Account">';
    echo'</form>';
}
