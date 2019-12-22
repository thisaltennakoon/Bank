<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}

if(isset($_POST) & !empty($_POST) ){

    $Primary_Customer=$_POST['Primary_Customer'];

    $Customer_String="";
    $NIC_arr=$_SESSION['NIC_arr'];
    $Other_branches=$_SESSION['Other_branches'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 
    foreach($NIC_arr as $NIC){
        $Customer_ID = $_POST[$NIC."-Customer_ID"];
        $InsertOrUpdate = $_POST[$NIC."-InsertOrUpdate"];
        $firstname = $_POST[$NIC."-firstname"];
        $middlename = $_POST[$NIC."-middlename"];
        $lastname = $_POST[$NIC."-lastname"];
        $DOB = $_POST[$NIC."-DOB"];
        $adr1 = $_POST[$NIC."-adr1"];
        $adr2 = $_POST[$NIC."-adr2"];
        $adr3 = $_POST[$NIC."-adr3"];
        $email = $_POST[$NIC."-email"];
        $contactnumber = $_POST[$NIC."-contactnumber"];
        $Gender = $_POST[$NIC."-Gender"];
        $NIC = $_POST[$NIC."-NIC"];        
        if ($InsertOrUpdate=="Insert"){
            $sql = "INSERT INTO Customer (Address_Line_1,Address_Line_2,Address_Line_3,Primary_Email,Primary_Contact_No) VALUES ('$adr1','$adr2','$adr3','$email','$contactnumber')";
            if ($conn->query($sql) === TRUE) {
                $Customer_ID = $conn->insert_id;
                $sql = "INSERT INTO Individual (Customer_ID,First_Name,Middle_Name,Last_Name,NIC,DOB,Gender) VALUES ('$Customer_ID','$firstname','$middlename','$lastname','$NIC','$DOB','$Gender')";
                if ($conn->query($sql) === TRUE) {
                    $Customer_String=$Customer_String.$Customer_ID.',';
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        elseif($InsertOrUpdate=="Update"){
            $sql = "UPDATE Customer SET Address_Line_1='$adr1',Address_Line_2='$adr2',Address_Line_3='$adr3',Primary_Email='$email',Primary_Contact_No='$contactnumber' WHERE Customer_ID='$Customer_ID'";
            if ($conn->query($sql) === TRUE) {
                $sql = "UPDATE Individual SET First_Name='$firstname',Middle_Name='$middlename',Last_Name='$lastname',DOB='$DOB',Gender='$Gender' WHERE Customer_ID='$Customer_ID'";
                if ($conn->query($sql) === TRUE) {
                    $Customer_String=$Customer_String.$Customer_ID.',';
                } else {
                    echo "Error updating record: to Individual " . $conn->error;
                }
            } else {
                echo "Error updating record: to Customer " . $conn->error;
            }
        }

    }
    $Customer_Str=substr($Customer_String,0, -1);
    $_SESSION['Customer_Str']=$Customer_Str;
    $_SESSION['Primary_Customer']=$Primary_Customer;
    echo '<form method="post" action="Account.php">';
    echo '<input type="radio" name="AccountType" value="Savings" required> Savings Account<br>';
    echo '<input type="radio" name="AccountType" value="Checking"> Checking Account<br>';
    echo '<br><input type="submit" value="Next"><br><br>';
    echo '</form>';
}

