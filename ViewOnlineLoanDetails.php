<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
?>


<!DOCTYPE html>
<html>
<body>
<?php
if(isset($_POST) & !empty($_POST) ){


    
    $AccNo = $_SESSION['AccNo'];
    $Amount=$_POST['Amount'];
    $TimePeriod=$_POST['Time'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql= "SELECT * FROM loan_type WHERE Type_Id='2'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $Interest=$row['Interest_Rate'];
          
        }
    }else{
        
    }

    $sql= "SELECT * FROM account WHERE Account_No='$AccNo'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $Branch_ID=$row['Primary_Branch_ID'];
          
        }
    }else{
        
    }

    $Total=$Amount*(100+$Interest)/100;
    $Installment=round($Total/$TimePeriod,2);

    

    

    try {

        $conn->autocommit(FALSE); // i.e., start transaction
    
        // assume that the TABLE groups has an auto_increment id field
        $sql = "INSERT INTO Loan(Account_No,Loan_Type,Amount,Branch_ID,Time_Period,Installment) VALUES ($AccNo,2,$Amount,$Branch_ID,$TimePeriod,$Installment)";
        $result = $conn->query($sql);
        if ( !$result ) {
            $result->free();
            throw new Exception($conn->error);
        }
        else {
            $Loan_ID = $conn->insert_id; 
            
                echo "<h1>Loan granted successfully</h1>";
                
                echo '<br><b>Loan Details</b>';
                echo '<br>Loan ID : '.$Loan_ID;
                echo '<br>Account No : '.$AccNo;
                echo '<br>Amount: '.$Amount;  
                echo '<br>Branch ID : '.$Branch_ID; 
                echo '<br>Time Period : '.$TimePeriod;
                echo '<br>Installment : '.$Installment;       
                echo '<br>Date Created : '.date("Y-m-d"); 

                unset($_SESSION['AccNo']);
                echo '<br>';
                echo '<button onclick="myFunction()">Print this page</button>';
                echo '<br><br>';
                echo '<button onclick="window.location.href = \'home.php\';">Home</button>';	
            
        
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

}
?>

<script>
function myFunction() {
  window.print();
}
</script>
</body>
</html>