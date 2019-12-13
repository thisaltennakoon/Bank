<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Customer_ID= $_POST["Customer_ID"];
    $Branch_ID= $_POST["Branch_ID"];
    $Account_Status= $_POST["Account_Status"];
    $Account_Type= $_POST["Account_Type"];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Account(Balance,Primary_Customer_ID,Primary_Branch_ID,Account_Status) VALUES (0,'$Customer_ID','$Branch_ID','$Account_Status')";
    if ($conn->query($sql) === TRUE) {
        $Account_No = $conn->insert_id;        //echo "New record created successfully. Last inserted ID is: " . $last_id;
        $sql = "INSERT INTO Savings_Account(Account_No,Number_of_Withdrawals,Account_Plan_ID) VALUES ($Account_No,0,$Account_Type)";
        if ($conn->query($sql) === TRUE) {
            echo "Savings account created successfully.Account number is :- ".$Account_No;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}
echo '<br><a href="home.php">Home</a>';
echo '<br><a href="LogOut.php">Log Out</a>';
?>