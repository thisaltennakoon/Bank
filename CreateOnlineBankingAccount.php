<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
?>
<!DOCTYPE html>
<html>
<body>
<h1>Bank A Seychelles</h1>
<h2>Create Online Banking Account</h2>
<form method="post" onSubmit = "return checkPassword(this)" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Customer NIC:<input type="text" name="NIC" required><br><br>
Username:<input type="text" name="username" required><br><br>
Password:<input type="password" name="password" required><br><br>
Confirm Password:<input type="password" name="cpassword" required>  <p id="demo"></p>  
Recovery Contact Number:<input type="text" name="RecoveryContactNumber" required><br><br>
Recovery Email:<input type="text" name="RecoveryEmail" required><br><br>
  
<input type="submit" value="Submit" >
</form> 
<?php
if(isset($_POST) & !empty($_POST)){
    $NIC = $_POST['NIC'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password=sha1($password);
    $RecoveryContactNumber = $_POST['RecoveryContactNumber'];
    $RecoveryEmail = $_POST['RecoveryEmail'];

    $conn = new mysqli("localhost", "root", "","Bank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql ="SELECT * FROM Individual WHERE NIC='$NIC'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $Customer_ID=$row["Customer_ID"];
        $sql = "INSERT INTO Customer_Login(Customer_ID,Username,Password,Recovery_Contact_No,Recovery_Email) VALUES ($Customer_ID,'$username','$password','$RecoveryContactNumber','$RecoveryEmail')";
        if ($conn->query($sql) === TRUE) {
            echo 'Customer Login Created Successful.';
        }else{
            echo "Error updating record: " . $conn->error;
        }
    }else{
        echo 'There isn\'t any customer registered in the system.Please recheck the NIC'; 
    }
    $conn->close();    
}
?>
<br>
<br>
<button onclick="myFunction()">Print this page</button>
<br>
<br>
<button onclick="window.location.href = 'home.php';">Home</button>
<script>
function myFunction() {
  window.print();
}

function checkPassword(form) { 
    password1 = form.password.value; 
    password2 = form.cpassword.value; 
    if (password1 != password2) { 
        document.getElementById("demo").innerHTML = "<font color=\"red\">Password doesn't Match</font>"; 
        return false; 
    }
    else{ 
        return true; 
    } 
} 
</script>
</body>
</html>
