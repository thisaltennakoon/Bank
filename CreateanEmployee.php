<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
$conn = new mysqli("localhost", "root", "","Bank");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<body>
<h1>Bank A Seychelles</h1>
<h2>Create an Employee</h2>
<form method="post" onSubmit = "return checkPassword(this)" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

First Name:<input type="text" name="firstname" required><br><br>
Middle Name:<input type="text" name="middlename"><br><br>
Last Name:<input type="text" name="lastname"><br><br>
Address:<input type="text" name="address" required><br><br>
NIC:<input type="text" name="NIC" required><br><br>
Date of Birth:<input type="date" name="DOB" required><br><br>
Gender<select name="Gender">
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option></select><br><br>
Contact Number:<input type="text" name="Contact_No" required><br><br>
Select Branch<select name="Branch">        
<?php
$sql = "SELECT * FROM Branch "; //reading things from the table //WHERE NOT Branch_ID='$Primary_Branch_ID'
$result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){       //while loop
            if($row["Branch_ID"]==$Primary_Branch_ID){
                echo '<option value="'.$row["Branch_ID"].'" selected>'.$row["Branch_ID"].'-'.$row["Branch_Name"].'-'.$row["Location"].'</option>';
            }else{
                echo '<option value="'.$row["Branch_ID"].'">'.$row["Branch_ID"].'-'.$row["Branch_Name"].'-'.$row["Location"].'</option>';
            }                
        }
        echo "</select>";   
    }else{
    
    }
    $conn->close();          
?>
<br><br>Username:<input type="text" name="username" required><br><br>
Password:<input type="password" name="password" required><br><br>
Confirm Password:<input type="password" name="cpassword" required>  <p id="demo"></p>  
Recovery Contact Number:<input type="text" name="RecoveryContactNumber" required><br><br>
Recovery Email:<input type="text" name="RecoveryEmail" required><br><br>
<select name="EmployeeType">
<option value="Maneger">Maneger</option>
<option value="Clerk">Clerk</option>
</select>
<br><br>
<input type="submit" value="Create" >
</form> 
<?php
if(isset($_POST) & !empty($_POST)){
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

    $firstname = test_input($_POST['firstname']);
    $middlename = test_input($_POST['middlename']);
    $lastname = test_input($_POST['lastname']);
    $address = test_input($_POST['address']);
    $NIC = test_input($_POST['NIC']);
    $DOB = test_input($_POST['DOB']);
    $Gender = test_input($_POST['Gender']);
    $Contact_No = test_input($_POST['Contact_No']);
    $Branch = test_input($_POST['Branch']);
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $password=sha1($password);
    $RecoveryContactNumber = test_input($_POST['RecoveryContactNumber']);
    $RecoveryEmail = test_input($_POST['RecoveryEmail']);
    $EmployeeType = test_input($_POST['EmployeeType']);

    $conn = mysqli_connect("localhost", "root", "","Bank");
    $stmt = $conn->prepare("INSERT INTO Employee(First_Name,Middle_Name,Last_Name,Address,NIC,DOB,Gender,Primary_Contact_No,Branch_ID) VALUES (?,?,?,?,?,?,?,?,?)");   
    $stmt->bind_param("ssssssssi",$firstname,$middlename,$lastname,$address,$NIC,$DOB,$Gender,$Contact_No,$Branch);
    $stmt->execute();
    $Employee_ID = $conn->insert_id;
    $stmt = $conn->prepare("INSERT INTO Employee_Login(Employee_ID,Username,Password,Recovery_Contact_No,Recovery_Email) VALUES (?,?,?,?,?)");         
    $stmt->bind_param("issss",$Employee_ID,$username,$password,$RecoveryContactNumber,$RecoveryEmail);
    $stmt->execute();
    $stmt->close();
    mysqli_close($conn);
    $conn1 = new mysqli("localhost", "root", "","Bank");
    if ($conn1->connect_error) {
        die("Connection failed: " . $conn1->connect_error);
    }
    if($EmployeeType=='Maneger'){
        $sql = "INSERT INTO Manager(Employee_ID) VALUES ($Employee_ID)";
        if ($conn1->query($sql) === TRUE) {
            echo 'Employee is Sucessfully Created.';
        }else{
            echo "Error updating record: " . $conn1->error;
        }
    }elseif($EmployeeType=='Clerk'){
        $sql = "INSERT INTO Clerk(Employee_ID) VALUES ($Employee_ID)";
        if ($conn1->query($sql) === TRUE){
            echo 'Employee is Sucessfully Created.';
        }else{
            echo "Error updating record: " . $conn1->error;
        }
    }  
    $conn1->close();    
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
