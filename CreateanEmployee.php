<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Bank";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
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
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $NIC = $_POST['NIC'];
    $DOB = $_POST['DOB'];
    $Gender = $_POST['Gender'];
    $Contact_No = $_POST['Contact_No'];
    $Branch = $_POST['Branch'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password=sha1($password);
    $RecoveryContactNumber = $_POST['RecoveryContactNumber'];
    $RecoveryEmail = $_POST['RecoveryEmail'];
    $EmployeeType = $_POST['EmployeeType'];

    // Create connection
    $conn = new mysqli("localhost", "root", "","Bank");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO Employee(First_Name,Middle_Name,Last_Name,Address,NIC,DOB,Gender,Primary_Contact_No,Branch_ID) VALUES ('$firstname','$middlename','$lastname','$address','$NIC','$DOB','$Gender','$Contact_No',$Branch)";
    if ($conn->query($sql) === TRUE) {
        $Employee_ID = $conn->insert_id;
        $sql = "INSERT INTO Employee_Login(Employee_ID,Username,Password,Recovery_Contact_No,Recovery_Email) VALUES ($Employee_ID,'$username','$password','$RecoveryContactNumber','$RecoveryEmail')";
        if ($conn->query($sql) === TRUE) {
            if($EmployeeType=='Maneger'){
                $sql = "INSERT INTO Manager(Employee_ID) VALUES ($Employee_ID)";
                if ($conn->query($sql) === TRUE) {
                    echo 'Employee is Sucessfully Created.';
                }else{
                    echo "Error updating record: " . $conn->error;
                }
            }elseif($EmployeeType=='Clerk'){
                $sql = "INSERT INTO Clerk(Employee_ID) VALUES ($Employee_ID)";
                if ($conn->query($sql) === TRUE) {
                    echo 'Employee is Sucessfully Created.';
                }else{
                    echo "Error updating record: " . $conn->error;
                }
            }
    
        }else{
            echo "Error updating record: " . $conn->error;
        }
    }else{
        echo "Error updating record: " . $conn->error;
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
