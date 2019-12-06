<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Customer_ID= $_POST["Customer_ID"];
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
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE Customer SET Address_Line_1='$adr1',Address_Line_2='$adr2',Address_Line_3='$adr3',Primary_Email='$email',Primary_Contact_No='$contactnumber' WHERE Customer_ID='$Customer_ID'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $sql = "UPDATE Individual SET First_Name='$firstname',Middle_Name='$middlename',Last_Name='$lastname',DOB='$DOB',Gender='$Gender' WHERE Customer_ID='$Customer_ID'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }


}
?>