<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
if(isset($_GET['NIC'])){
    $NIC=$_GET['NIC'];
echo '<h1>Edit Customer Details</h1><br>';
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
  echo '<form method="post" action="SavingsAccount2_edit_update.php">';
  echo'Customer ID:<input type="text" name="Customer_ID" value="'.$Customer_ID.'" readonly><br><br>';
  echo'First Name:<input type="text" name="firstname" value="'.$First_Name.'" required><br><br>';
  echo'Middle Name:<input type="text" name="middlename" value="'.$Last_Name.'" required><br><br>';
  echo'Last Name:<input type="text" name="lastname" value="'.$Middle_Name.'" required><br><br>';
  echo'Date of Birth:<input type="text" name="DOB" value="'.$DOB.'" required><br><br>';
  echo'Address Line 1:<input type="text" name="adr1" value="'.$Address_Line_1.'" required><br><br>';
  echo'Address Line 2:<input type="text" name="adr2" value="'.$Address_Line_2.'" required><br><br>';
  echo'Address Line_3:<input type="text" name="adr3" value="'.$Address_Line_3.'" required><br><br>';
  echo'Email:<input type="email" name="email" value="'.$Primary_Email.'" required><br><br>';
  echo'Contact Number:<input type="text" name="contactnumber" value="'.$Primary_Contact_No.'" required><br><br>';
  echo'<select name="Gender">';
  echo'<option value="Male">Male</option>';
  echo'<option value="Female">Female</option>';
  echo'<option value="Other">Other</option></select>';
  echo '<br><br><input type="submit" value="Save Changes">';
  echo'</form>';

}else{
    echo 'error';
}

$conn->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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