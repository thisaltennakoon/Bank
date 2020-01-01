<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
echo "<h1>Home page</h1><br>";
echo 'Username : '.$_SESSION['User'];
$Employee_ID=$_SESSION['Employee_ID'];
$Branch_ID =$_SESSION['Primary_Branch_ID'];
$EmployeeType=$_SESSION['EmployeeType'];

$conn = new mysqli("localhost", "root", "","Bank");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql ="SELECT Branch_Name FROM Branch WHERE Branch_ID='$Branch_ID'";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){ 
        echo '<br>Branch : '.$row["Branch_Name"];
    }
}else{
    echo 'error';
}
$sql ="SELECT * FROM Employee WHERE Employee_ID='$Employee_ID'";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){ 
        echo '<br>Employee Name : '.$row["First_Name"].' '. $row["Middle_Name"].' '. $row["Last_Name"];
    }
}else{
    echo 'error';
}

?>
<br><br><button onclick="window.location.href = 'BankTransaction.php'">Bank Transaction</button> 
<br><br><button onclick="window.location.href = 'CreateOnlineBankingAccount.php'">Create Online Banking Account</button> 
<br><br><button onclick="window.location.href = 'LoanApplicationBank.php'">Make a Loan Request</button> 
<?php
if ($EmployeeType=="Manager"){
echo '<br><br><button onclick="window.location.href = \'ApproveLoans.php\'">Approve Requested Loan</button>'; 
}
?>
<br><br><button onclick="window.location.href = 'CreateFD.php'">Make a FD</button> 
<br><br><button onclick="window.location.href = 'Customer.php'">Create a Bank Account</button> 
<br><br><button onclick="window.location.href = 'ViewAccountDetails.php'">View Account Details</button> 
<br><br><button onclick="window.location.href = 'IssueCheckBooks.php'">Issue Check Books</button> 
<?php
if ($EmployeeType=="Manager"){
echo '<br><br><button onclick="window.location.href = \'CreateanEmployee.php\'">Create an Employee</button>';
}
?>
<br><br><button onclick="window.location.href = 'LogOut.php'">Log Out</button>