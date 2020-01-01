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

    echo "<h1>Approve qualified loans</h1>";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql= "SELECT * FROM requested_loan WHERE Request_Status='Pending'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $AccNo=$row['Account_No'];
          $Branch=$row['Branch_ID'];
          $Amount=$row['Amount'];
          $Time=$row['Time_Period'];
          $Installment=$row['Installment'];
          $RequestedBy=$row['Requested_By'];
          $RequestID=$row['Request_ID'];

          echo 'Account No : '.$AccNo;
          echo '<br>Branch : '.$Branch;
          echo '<br>Amount : '.$Amount;
          echo '<br>Time Period : '.$Time;
          echo '<br>Installment : '.$Installment;
          echo '<br><button onclick=approve("'.$AccNo.'","'.$Branch.'","'.$Amount.'","'.$Time.'","'.$Installment.'","'.$RequestedBy.'","'.$RequestID.'")>Approve</button><hr>';

          
        
        }
    }else{
        
    }

?>

<script>
    function approve(AccNo,Branch,Amount,Time,Installment,RequestBy,RequestID){
        window.location.href="ApproveLoans1.php?AccNo="+AccNo+"& Branch="+Branch+"& Amount="+Amount+"& Time="+Time+"& Installment="+Installment+"& RequestBy="+RequestBy+"& RequestID="+RequestID;
        //window.location.href = 'home.php';

    }

</script>

</body>

</html>