<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}

if(isset($_POST) & !empty($_POST) & isset($_POST['Account_Type'])){
    $Primary_Customer = $_POST['Primary_Customer'];
    $Customer_String=$_POST['Other_Customers'];
    $Customer_arr = explode (",", $Customer_String);
    $Primary_Branch_ID=$_SESSION['Primary_Branch_ID'];
    $Branch_Str=$_POST['Branch_Str'];
    $Branch_Str = explode (",", $Branch_Str);
    $Account_Status = $_POST['Account_Status'];
    $Account_Type=$_POST['Account_Type'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Account(Balance,Primary_Customer_ID,Primary_Branch_ID,Account_Status) VALUES (0,$Primary_Customer,$Primary_Branch_ID,'$Account_Status')";
    if ($conn->query($sql) === TRUE) {
        $Account_No = $conn->insert_id;        //echo "New record created successfully. Last inserted ID is: " . $last_id;
        $sql = "INSERT INTO Savings_Account(Account_No,Number_of_Withdrawals,Account_Plan_ID) VALUES ($Account_No,0,$Account_Type)";
        if ($conn->query($sql) === TRUE) {
            foreach ($Branch_Str as $Branch){
                $sql = "INSERT INTO Account_Branch(Account_No,Branch_ID) VALUES ($Account_No,$Branch)";
                if ($conn->query($sql) === TRUE) {}
            }  
            foreach ($Customer_arr as $Customer){
                $sql = "INSERT INTO Customer_Account(Customer_ID,Account_No) VALUES ($Customer,$Account_No)";
                if ($conn->query($sql) === TRUE) {}
            }
            echo "Savings account created successfully.Account number is :- ".$Account_No;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();

}