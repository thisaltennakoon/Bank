<?php
session_start();
if(!isset($_SESSION["User"]) & empty($_SESSION["User"])){
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html>
<body>

<?php

    $AccNo=$_GET['AccNo'];
    $Branch=$_GET['Branch'];
    $Amount=$_GET['Amount'];
    $Time_Period=$_GET['Time'];
    $Installment=$_GET['Installment'];
    $RequestID=$_GET['RequestID'];
    $RequestBy=$_GET['RequestBy'];
    $User=$_SESSION['Employee_ID'];
    


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {

        $conn->autocommit(FALSE); // i.e., start transaction
    
        // assume that the TABLE groups has an auto_increment id field
        $query = "INSERT INTO loan(Account_No,Loan_Type,Amount,Branch_ID,Time_Period,Installment) VALUES($AccNo,1,$Amount,$Branch,$Time_Period,$Installment)";
        $result = $conn->query($query);
        if ( !$result ) {
            $result->free();
            throw new Exception($conn->error);
        }
    
        $group_id = $conn->insert_id; // last auto_inc id from *this* connection
    
        $query = "INSERT INTO bank_visit_loan(Loan_ID,Approved_By,Requested_By) VALUES($group_id,$User,$RequestBy)";
        $result = $conn->query($query);
        if ( !$result ) {
            $result->free();
            throw new Exception($conn->error);
        }

        $query = "UPDATE requested_loan SET Request_Status='Approved' WHERE Request_ID=$RequestID";
        $result = $conn->query($query);
        if ( !$result ) {
            $result->free();
            throw new Exception($conn->error);
        }
    
        // our SQL queries have been successful. commit them
        // and go back to non-transaction mode.
    
        $conn->commit();
        $conn->autocommit(TRUE); // i.e., end transaction

        echo '<h3>Loan Approved</h3>';
        echo '<br><br>';
        echo '<button onclick="window.location.href = \'home.php\';">Home</button>';
    }
    catch ( Exception $e ) {
    
        // before rolling back the transaction, you'd want
        // to make sure that the exception was db-related
        $conn->rollback(); 
        $conn->autocommit(TRUE); // i.e., end transaction   
    }

    

?>

</body>

</html>