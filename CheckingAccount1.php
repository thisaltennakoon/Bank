<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
//session_start();
if(isset($_POST) & !empty($_POST)){
  $BRN = $_POST['BRN'];
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
  $sql = "SELECT * FROM Organization WHERE Bussiness_Registration_Number='$BRN'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $Customer_ID= $row["Customer_ID"];
        $Name= $row["Name"]; 
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
    echo '<h2>Organization Already exist</h2>';
    echo '<br><h3>Check the following details</h3><br>';
    echo'<form>';
    echo'Name:<input type="text" name="Name" value="'.$Name.'" readonly><br><br>';
    echo'Address Line 1:<input type="text" name="adr1" value="'.$Address_Line_1.'" readonly><br><br>';
    echo'Address Line 2:<input type="text" name="adr2" value="'.$Address_Line_2.'" readonly><br><br>';
    echo'Address Line_3:<input type="text" name="adr3" value="'.$Address_Line_3.'" readonly><br><br>';
    echo'Email:<input type="email" name="email" value="'.$Primary_Email.'" readonly><br><br>';
    echo'Contact Number:<input type="text" name="contactnumber" value="'.$Primary_Contact_No.'" readonly><br><br>';
    echo'</form>';
    echo '<button type="button" onclick="window.location.href='.'\'CheckingAccount2.php\''.'">Proceed</button>           ';
    echo '<button type="button" onclick="window.location.href='.'\'CheckingAccount2_edit.php?NIC='.$BRN.'\''.'">Modify the Details</button>';
   

  }else{
    echo '<h1>Application for Register a New Organization</h1><br>';
    echo'<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>';
    echo'Name:<input type="text" name="Name" required><br><br>';
    echo'Address Line 1:<input type="text" name="adr1" required><br><br>';
    echo'Address Line 2:<input type="text" name="adr2" required><br><br>';
    echo'Address Line_3:<input type="text" name="adr3" required><br><br>';
    echo'Email:<input type="email" name="email" required><br><br>';
    echo'Contact Number:<input type="text" name="contactnumber" required><br><br>';
    echo'<input type="submit" value="Next">';
    echo'</form>';
  }
//}else{
  //echo "The email address or password that you've entered doesn't match any account.";
//}
$conn->close();
}
?>