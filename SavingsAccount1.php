<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
//session_start();
if(isset($_POST) & !empty($_POST) & isset($_POST['NIC'])){
  $NIC = $_POST['NIC'];
  /*$firstname= $_POST['firstname'];
  $middlename= $_POST['middlename'];
  $lastname= $_POST['lastname'];
  $DOB= $_POST['DOB'];
  $adr1= $_POST['adr1'];
  $adr2= $_POST['adr2'];
  $adr3= $_POST['adr3'];
  $email= $_POST['email'];
  $contactnumber= $_POST['contactnumber'];
  $Gender= $_POST['Gender'];*/

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "Bank"; // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT * FROM Individual WHERE NIC='$NIC'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $Customer_ID= $row["Customer_ID"];
        $First_Name= $row["First_Name"];
        $Last_Name= $row["Last_Name"];
        $Middle_Name= $row["Middle_Name"]; 
        $DOB= $row["DOB"]; 
        $Gender= $row["Gender"];   
    }
    $sql = "SELECT * FROM Customer WHERE Customer_ID='$Customer_ID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $Address_Line_1 = $row["Address_Line_1"];
        $Address_Line_2 = $row["Address_Line_2"];
        $Address_Line_3 = $row["Address_Line_3"];
        $Primary_Email = $row["Primary_Email"];
        $Primary_Contact_No  = $row["Primary_Contact_No"];
      }
    }else{
        echo 'error';
    }
    echo '<h2>Customer Already exist</h2>';
    echo '<br><h3>Check the following details</h3><br>';
    echo'<form>';
    echo'First Name:<input type="text" name="firstname" value="'.$First_Name.'" readonly><br><br>';
    echo'Middle Name:<input type="text" name="middlename" value="'.$Last_Name.'" readonly><br><br>';
    echo'Last Name:<input type="text" name="lastname" value="'.$Middle_Name.'" readonly><br><br>';
    echo'Date of Birth:<input type="text" name="DOB" value="'.$DOB.'" readonly><br><br>';
    echo'Address Line 1:<input type="text" name="adr1" value="'.$Address_Line_1.'" readonly><br><br>';
    echo'Address Line 2:<input type="text" name="adr2" value="'.$Address_Line_2.'" readonly><br><br>';
    echo'Address Line_3:<input type="text" name="adr3" value="'.$Address_Line_3.'" readonly><br><br>';
    echo'Email:<input type="email" name="email" value="'.$Primary_Email.'" readonly><br><br>';
    echo'Contact Number:<input type="text" name="contactnumber" value="'.$Primary_Contact_No.'" readonly><br><br>';
    echo'Gender:<input type="text" name="Gender" value="'.$Gender.'" readonly><br><br>';
    echo'</form>';
    echo '<button type="button" onclick="window.location.href='.'\'SavingsAccount2.php?Customer_ID='.$Customer_ID.'\''.'">Proceed</button>           ';
    echo '<button type="button" onclick="window.location.href='.'\'SavingsAccount2_edit.php?NIC='.$NIC.'\''.'">Modify the Details</button>';
   

  }else{
    echo '<h1>Application for Register a New Customer</h1><br>';
    echo'<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>';
    echo'First Name:<input type="text" name="firstname" required><br><br>';
    echo'Middle Name:<input type="text" name="middlename"><br><br>';
    echo'Last Name:<input type="text" name="lastname"><br><br>';
    echo'Date of Birth:<input type="text" name="DOB" required><br><br>';
    echo'Address Line 1:<input type="text" name="adr1"><br><br>';
    echo'Address Line 2:<input type="text" name="adr2"><br><br>';
    echo'Address Line_3:<input type="text" name="adr3"><br><br>';
    echo'Email:<input type="email" name="email" required><br><br>';
    echo'Contact Number:<input type="text" name="contactnumber" required><br><br>';
    echo'<select name="Gender">';
    echo'<option value="Male">Male</option>';
    echo'<option value="Female">Female</option>';
    echo'<option value="Other">Other</option></select>';
    echo'<input type="submit" value="Next">';
    echo'</form>';
  }
//}else{
  //echo "The email address or password that you've entered doesn't match any account.";
//}
$conn->close();
}
if(isset($_POST) & !empty($_POST) & isset($_POST['firstname'])){
  $Customer_ID= $_POST["Customer_ID"];
  $firstname = $_POST["firstname"];
  $middlename = $_POST["middlename"];
  $lastname = $_POST["lastname"];
  $DOB = $_POST["DOB"];
  $adr1 = $_POST["adr1"];
  $adr2 = $_POST["adr2"];
  $adr3 = $_POST["adr3"];
  $email = $_POST["email"];
  $contactnumber = $_POST["contactnumber"];
  $Gender = $_POST["Gender"];
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "Bank"; // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "UPDATE Customer SET Address_Line_1='$adr1',Address_Line_2='$adr2',Address_Line_3='$adr3',Primary_Email='$email',Primary_Contact_No='$contactnumber' WHERE Customer_ID='$Customer_ID'";
  if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
  } else {
      echo "Error updating record: " . $conn->error;
  }

  $sql = "UPDATE Individual SET First_Name='$firstname',Middle_Name='$middlename',Last_Name='$lastname',DOB='$DOB',Gender='$Gender' WHERE Customer_ID='$Customer_ID'";
  if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
  } else {
      echo "Error updating record: " . $conn->error;
  }


}
?>