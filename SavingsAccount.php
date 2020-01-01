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
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

    $Customer_Str=$_SESSION['Customer_Str'];
    $Primary_Customer=$_SESSION['Primary_Customer'];
    $NIC_arr=$_SESSION['NIC_arr'];
    $Other_branches=$_SESSION['Other_branches'];

    $Customer_arr = explode (",", $Customer_Str);
    $Primary_Branch_ID=$_SESSION['Primary_Branch_ID'];
    $Branch_Str = $_SESSION['Other_branches'];
    $Account_Status = test_input($_POST['Account_Status']);
    $Account_Type=test_input($_POST['Account_Type']);

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
            if ($Account_Type!="1"){
                echo "<h1>Savings account created successfully</h1>";
                include 'ViewAccountDetailsFunction.php';
                ViewAccountDetails($Account_No,$conn);	
                unset($_SESSION['NIC_arr']);
                unset($_SESSION['Other_branches']);		
                unset($_SESSION['Customer_Str']);
                unset($_SESSION['Primary_Customer']);
                echo '<br>';
                echo '<button onclick="myFunction()">Print this page</button>';
                echo '<br><br>';
                echo '<button onclick="window.location.href = \'home.php\';">Home</button>';	
            }
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
    if ($Account_Type=="1"){
        echo '<form method="post" action="ChildSavingsAccount.php">';
        echo'<input type="hidden" name="AccountNumber" value="'.$Account_No.'">';
        echo'First Name:<input type="text" name="firstname" required><br><br>';
        echo'Middle Name:<input type="text" name="middlename"><br><br>';
        echo'Last Name:<input type="text" name="lastname"><br><br>';
        echo'Date of Birth:<input type="date" name="DOB" required><br><br>';
        echo'<select name="Gender">';
        echo'<option value="Male">Male</option>';
        echo'<option value="Female">Female</option>';
        echo'<option value="Other">Other</option></select>';
        echo '<br><br><input type="submit" value="Next"><br><br>';
        echo '</form>';
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