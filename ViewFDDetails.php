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
    $Time=$_POST['Time'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql= "SELECT * FROM fixed_deposit_plan WHERE Time_Period='$Time'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $Plan=$row['Plan_ID'];
          
        }
    }else{
        
    }

    

    $sql = "INSERT INTO fixed_deposit(Account_No,Amount,Plan_ID) VALUES ($AccNo,$Amount,$Plan)";
    if ($conn->query($sql) === TRUE) {
        $FD_ID = $conn->insert_id; 
            
                echo "<h1>Fixed deposit created successfully</h1>";
                
                echo '<br><b>Fixed Deposit Details</b>';
                echo '<br>FD ID : '.$FD_ID;
                echo '<br>Account No : '.$AccNo;
                echo '<br>Amount: '.$Amount; 
                echo '<br>Time Period : '.$Time;  
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