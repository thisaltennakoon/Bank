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


    $Primary_Branch_ID=$_SESSION['Primary_Branch_ID'];
    $RequestedClerk=$_SESSION['Employee_ID'];
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

    $sql= "SELECT * FROM loan_type WHERE Type_Id='1'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $Interest=$row['Interest_Rate'];
          
        }
    }else{
        
    }

    $Total=$Amount*(100+$Interest)/100;
    $Installment=round($Total/$TimePeriod,2);

    $LoanStatus="Pending";

    $sql = "INSERT INTO Requested_Loan(Account_No,Amount,Branch_ID,Time_Period,Installment,Requested_By,Request_Status) VALUES ($AccNo,$Amount,$Primary_Branch_ID,$TimePeriod,$Installment,$RequestedClerk,'$LoanStatus')";
    if ($conn->query($sql) === TRUE) {
        $Loan_ID = $conn->insert_id; 
            
                echo "<h1>Loan application created successfully</h1>";
                
                echo '<br><b>Loan Details</b>';
                echo '<br>Loan ID : '.$Loan_ID;
                echo '<br>Account No : '.$AccNo;
                echo '<br>Amount: '.$Amount;  
                echo '<br>Branch ID : '.$Primary_Branch_ID; 
                echo '<br>Time Period : '.$TimePeriod;
                echo '<br>Installment : '.$Installment;
                echo '<br>Clerk: '.$RequestedClerk;  
                echo '<br>Date Created : '.date("Y-m-d"); 

                unset($_SESSION['AccNo']);
                echo '<br>';
                echo '<button onclick="myFunction()">Print this page</button>';
                echo '<br><br>';
                echo '<button onclick="window.location.href = \'home.php\';">Home</button>';	
            
        
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();

}
?>

<script>
function myFunction() {
  window.print();
}
</script>
</body>
</html>