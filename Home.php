<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
echo "<h1>Home page</h1><br>";
echo 'Username : '.$_SESSION['User'];
echo '<br>Employee_ID : '.$_SESSION['Employee_ID'];
echo '<br>Branch_ID : '.$_SESSION['Primary_Branch_ID'].'<br>';
?>
<br><br><button onclick="window.location.href = 'Customer.php'">Create a Account</button>
<br><br><button onclick="window.location.href = 'ViewAccountDetails.php'">View Account Details</button>
<br><br><button onclick="window.location.href = 'IssueCheckBooks.php'">Issue Check Books</button>
<br><br><button onclick="window.location.href = 'CreateanEmployee.php'">Create an Employee</button>
<br><br><button onclick="window.location.href = 'LogOut.php'">Log Out</button>