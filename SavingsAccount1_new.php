<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
if(isset($_POST) & !empty($_POST) & isset($_POST['firstname'])){
    //$Customer_ID= $_POST["Customer_ID"];
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $DOB = $_POST["DOB"];
    $adr1 = $_POST["adr1"];
    $adr2 = $_POST["adr2"];
    $adr3 = $_POST["adr3"];
    $email = $_POST["email"];
    $contactnumber = $_POST["contactnumber"];
    $Gender = $_POST["Gender"];
    $NIC = $_POST['NIC'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
  
    $sql = "INSERT INTO Customer (Address_Line_1,Address_Line_2,Address_Line_3,Primary_Email,Primary_Contact_No) VALUES ('$adr1','$adr2','$adr3','$email','$contactnumber')";
    if ($conn->query($sql) === TRUE) {
        $Customer_ID = $conn->insert_id;
        $sql = "INSERT INTO Individual (Customer_ID,First_Name,Middle_Name,Last_Name,NIC,DOB,Gender) VALUES ('$Customer_ID','$firstname','$middlename','$lastname','$NIC','$DOB','$Gender')";
        if ($conn->query($sql) === TRUE) {
            //echo '<button type="button" onclick="window.location.href='.'\'SavingsAccount2.php?Customer_ID='.$Customer_ID.'\''.'">Proceed</button>';
            header('location: SavingsAccount2.php?Customer_ID='.$Customer_ID.'');
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
  
  }
  ?>