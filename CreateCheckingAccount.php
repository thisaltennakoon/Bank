<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}?>
<!DOCTYPE html>
<html>
<body>
<?php
if(isset($_POST) & !empty($_POST) & isset($_POST['Primary_Customer'])){
    $Customer_Str=$_SESSION['Customer_Str'];
    $Primary_Customer=$_SESSION['Primary_Customer'];
    $NIC_arr=$_SESSION['NIC_arr'];
    $Branch_arr = $_SESSION['Other_branches'];
    $Customer_arr = explode (",", $Customer_Str);
    $Account_Type = $_POST['AccountType'];
    $Account_Status = $_POST["Account_Status"];
    $Primary_Branch_ID=$_SESSION['Primary_Branch_ID'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($Account_Type=='Organizational'){
        $adr1 = $_POST["adr1"];
        $adr2 = $_POST["adr2"];
        $adr3 = $_POST["adr3"];
        $email = $_POST["email"];
        $contactnumber = $_POST["contactnumber"];
        $Registration_Number = $_POST["Registration_Number"];
        $Name = $_POST["Name"];
        $sql = "INSERT INTO Customer (Address_Line_1,Address_Line_2,Address_Line_3,Primary_Email,Primary_Contact_No) VALUES ('$adr1','$adr2','$adr3','$email','$contactnumber')";
        if ($conn->query($sql) === TRUE) {
            $Customer_ID = $conn->insert_id;
            $sql = "INSERT INTO Organization (Customer_ID,Name,Bussiness_Registration_Number) VALUES ('$Customer_ID','$Name','$Registration_Number')";
            if ($conn->query($sql) === TRUE) {
            }else {
                echo "Error updating record: " . $conn->error;
            }
            foreach($Customer_arr as $Individual_ID){
                $sql = "INSERT INTO Organization_Individual (Organization_ID,Individual_ID) VALUES ('$Customer_ID','$Individual_ID')";
                if ($conn->query($sql) === TRUE) {
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }
            $sql = "INSERT INTO Account(Balance,Primary_Customer_ID,Primary_Branch_ID,Account_Status) VALUES (0,$Customer_ID,$Primary_Branch_ID,'$Account_Status')";
            if ($conn->query($sql) === TRUE) {
                $Account_No = $conn->insert_id;        //echo "New record created successfully. Last inserted ID is: " . $last_id;
                $sql = "INSERT INTO Checking_Account(Account_No) VALUES ($Account_No)";
                if ($conn->query($sql) === TRUE) {
                    echo "<h1>Checking account created successfully</h1>";
                    include 'ViewAccountDetailsFunction.php';
                    ViewAccountDetails($Account_No,$conn);
                }
                foreach ($Branch_arr as $Branch){
                    $sql = "INSERT INTO Account_Branch(Account_No,Branch_ID) VALUES ($Account_No,$Branch)";
                    if ($conn->query($sql) === TRUE) {}
                } 
                foreach ($Customer_arr as $Customer){
                    $sql = "INSERT INTO Customer_Account(Customer_ID,Account_No) VALUES ($Customer,$Account_No)";
                    if ($conn->query($sql) === TRUE) {}
                } 
            }else {
                echo "Error updating record: " . $conn->error;
            }            
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    elseif ($Account_Type=='Non-Organizational'){    
        $sql = "INSERT INTO Account(Balance,Primary_Customer_ID,Primary_Branch_ID,Account_Status) VALUES (0,$Primary_Customer,$Primary_Branch_ID,'$Account_Status')";
        if ($conn->query($sql) === TRUE) {
            $Account_No = $conn->insert_id;        //echo "New record created successfully. Last inserted ID is: " . $last_id;
            $sql = "INSERT INTO Checking_Account(Account_No) VALUES ($Account_No)";
            if ($conn->query($sql) === TRUE) {
                echo "<h1>Checking account created successfully</h1>";
                include 'ViewAccountDetailsFunction.php';
                ViewAccountDetails($Account_No,$conn);
            }
            foreach ($Branch_arr as $Branch){
                $sql = "INSERT INTO Account_Branch(Account_No,Branch_ID) VALUES ($Account_No,$Branch)";
                if ($conn->query($sql) === TRUE) {}
            } 
            foreach ($Customer_arr as $Customer){
                $sql = "INSERT INTO Customer_Account(Customer_ID,Account_No) VALUES ($Customer,$Account_No)";
                if ($conn->query($sql) === TRUE) {}
            } 
        }else {
            echo "Error updating record: " . $conn->error;
        }
    }
    $conn->close();		
    unset($_SESSION['NIC_arr']);
    unset($_SESSION['Other_branches']);		
    unset($_SESSION['Customer_Str']);
    unset($_SESSION['Primary_Customer']);	
}
?>
<br>
<button onclick="myFunction()">Print this page</button>
<br>
<button onclick="window.location.href = 'home.php';">Home</button>
<script>
function myFunction() {
  window.print();
}
</script>
</body>
</html>