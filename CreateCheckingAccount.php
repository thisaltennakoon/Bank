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


    $conn = mysqli_connect("localhost", "root", "","Bank");
    if ($Account_Type=='Organizational'){
        $adr1 = $_POST["adr1"];
        $adr2 = $_POST["adr2"];
        $adr3 = $_POST["adr3"];
        $email = $_POST["email"];
        $contactnumber = $_POST["contactnumber"];
        $Registration_Number = $_POST["Registration_Number"];
        $Name = $_POST["Name"];

        $stmt = $conn->prepare("INSERT INTO Customer (Address_Line_1,Address_Line_2,Address_Line_3,Primary_Email,Primary_Contact_No) VALUES (?,?,?,?,?)");   
        $stmt->bind_param("sssss",$adr1,$adr2,$adr3,$email,$contactnumber);
        if ($stmt->execute() === TRUE) {
            $Customer_ID = $conn->insert_id;
            $stmt = $conn->prepare("INSERT INTO Organization (Customer_ID,Name,Bussiness_Registration_Number) VALUES (?,?,?)");   
            $stmt->bind_param("sss",$Customer_ID,$Name,$Registration_Number);
            if ($stmt->execute() === TRUE) {
            }else {
                echo "Error updating record: " . $conn->error;
            }
            foreach($Customer_arr as $Individual_ID){
                $stmt = $conn->prepare("INSERT INTO Organization_Individual (Organization_ID,Individual_ID) VALUES (?,?)");   
                $stmt->bind_param("ss",$Customer_ID,$Individual_ID);
                if ($stmt->execute() === TRUE) {
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }
            $stmt = $conn->prepare("INSERT INTO Account(Balance,Primary_Customer_ID,Primary_Branch_ID,Account_Status) VALUES (0,?,?,?)");   
            $stmt->bind_param("iis",$Customer_ID,$Primary_Branch_ID,$Account_Status);
            if ($stmt->execute() === TRUE) {
                $Account_No = $conn->insert_id;        //echo "New record created successfully. Last inserted ID is: " . $last_id;
                $stmt = $conn->prepare("INSERT INTO Checking_Account(Account_No) VALUES (?)");   
                $stmt->bind_param("i",$Account_No);
                if ($stmt->execute() === TRUE) {
                    echo "<h1>Checking account created successfully</h1>";
                    include 'ViewAccountDetailsFunction.php';
                    ViewAccountDetails($Account_No,$conn);
                }
                foreach ($Branch_arr as $Branch){
                    $stmt = $conn->prepare("INSERT INTO Account_Branch(Account_No,Branch_ID) VALUES (?,?)");   
                    $stmt->bind_param("ii",$Account_No,$Branch);
                    if ($stmt->execute() === TRUE) {
                        
                    }
                } 
                foreach ($Customer_arr as $Customer){
                    $stmt = $conn->prepare("INSERT INTO Customer_Account(Customer_ID,Account_No) VALUES (?,?)");   
                    $stmt->bind_param("ii",$Customer,$Account_No);
                    if ($stmt->execute() === TRUE) {

                    }
                } 
            }else {
                echo "Error updating record: " . $conn->error;
            }            
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    elseif ($Account_Type=='Non-Organizational'){  
        $stmt = $conn->prepare("INSERT INTO Account(Balance,Primary_Customer_ID,Primary_Branch_ID,Account_Status) VALUES (0,?,?,?)");   
        $stmt->bind_param("iis",$Primary_Customer,$Primary_Branch_ID,$Account_Status);
        if ($stmt->execute() === TRUE) {  
            $Account_No = $conn->insert_id;        //echo "New record created successfully. Last inserted ID is: " . $last_id;

            $stmt = $conn->prepare("INSERT INTO Checking_Account(Account_No) VALUES (?)");   
            $stmt->bind_param("i",$Account_No);
            if ($stmt->execute() === TRUE) {
                echo "<h1>Checking account created successfully</h1>";
                include 'ViewAccountDetailsFunction.php';
                ViewAccountDetails($Account_No,$conn);
            }
            foreach ($Branch_arr as $Branch){
                $stmt = $conn->prepare("INSERT INTO Account_Branch(Account_No,Branch_ID) VALUES (?,?)");   
                $stmt->bind_param("ii",$Account_No,$Branch);
                if ($stmt->execute() === TRUE) {

                }
            } 
            foreach ($Customer_arr as $Customer){
                $stmt = $conn->prepare("INSERT INTO Customer_Account(Customer_ID,Account_No) VALUES (?,?)");   
                $stmt->bind_param("ii",$Customer,$Account_No);
                if ($stmt->execute() === TRUE) {
                    
                }
            } 
        }else {
            echo "Error updating record: " . $conn->error;
        }
    }
    $stmt->close();
    mysqli_close($conn);		
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