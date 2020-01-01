<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}?>
<!DOCTYPE html>
<html>
<body>
<?php
if(isset($_POST) & !empty($_POST) ){
    $AccountNumber=$_POST['AccountNumber'];
    $firstname=$_POST['firstname'];
    $middlename=$_POST['middlename'];
    $lastname=$_POST['lastname'];
    $DOB=$_POST['DOB'];
    $Gender=$_POST['Gender'];

    $conn = mysqli_connect("localhost", "root", "","Bank");
    $stmt = $conn->prepare("INSERT INTO Child_Savings_Account(Account_No,First_Name,Middle_Name,Last_Name,DOB,Gender) VALUES (?,?,?,?,?,?)");   
    $stmt->bind_param("isssss",$AccountNumber,$firstname,$middlename,$lastname,$DOB,$Gender);
    if ($stmt->execute() === TRUE) {
        echo "<h1>Child Savings account created successfully</h1>";
        include 'ViewAccountDetailsFunction.php';
        ViewAccountDetails($AccountNumber,$conn);
    }else{
        echo "Error updating record: " . $conn->error;
    }

}
$stmt->close();
mysqli_close($conn);	
unset($_SESSION['NIC_arr']);
unset($_SESSION['Other_branches']);		
unset($_SESSION['Customer_Str']);
unset($_SESSION['Primary_Customer']);	
?>
<br>
<button onclick="myFunction()">Print this page</button>
<br><br>
<button onclick="window.location.href = 'home.php';">Home</button>
<script>
function myFunction() {
  window.print();
}
</script>
</body>
</html>
