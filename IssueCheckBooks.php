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
<h2>Issue a Checkbook</h2>
<form method="post" onSubmit = "return checkPassword(this)" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Account Number:<input type="number" name="Account_No" required><br><br>
Starting Check Number:<input type="number" name="Starting_Check_Number" required><br><br>
Number of Pages<select name="Number_of_Pages">
<option value="25">25 Leaves</option>
<option value="50">50 Leaves</option>
<option value="100">100 Leaves</option></select><br><br>    
<input type="submit" value="Submit" >
</form> 
<?php
if(isset($_POST) & !empty($_POST)){
    $Account_No = $_POST['Account_No'];
    $Starting_Check_Number = $_POST['Starting_Check_Number'];
    $Number_of_Pages = $_POST['Number_of_Pages'];

    $conn = new mysqli("localhost", "root", "","Bank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql ="SELECT Account_No FROM Account WHERE Account_No='$Account_No'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ 
            $sql ="SELECT Account_No FROM Checking_Account WHERE Account_No='$Account_No'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ 
                    $sql = "INSERT INTO Checkbook(Account_No,Number_of_Pages,Starting_Check_Number) VALUES ($Account_No,$Number_of_Pages,$Starting_Check_Number)";
                    if ($conn->query($sql) === TRUE) {
                        $Checkbook_Number = $conn->insert_id;
                        echo '<h3> Checkbook Number : '.$Checkbook_Number.'</h3>';
                        include 'ViewAccountDetailsFunction.php';
                        ViewAccountDetails($Account_No,$conn);
                    }else{
                        echo "Error updating record: " . $conn->error;
                    }
                }
            }else{
                echo 'Account Number is belongs to a savings account.Checkbooks cannot be issued fro savings account.';
            }
        }
    }else{
        echo 'Account Number is not valid';
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
