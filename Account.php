<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}

if(isset($_POST) & !empty($_POST) & isset($_POST['Primary_Customer'])){
    $Branch_Str = $_POST['Branch_Str'];
    $NICs = $_POST['NICs'];
    $Primary_Customer = $_POST['Primary_Customer'];
    $Customer_String = $_POST['Customer_String'];
    $Customer_arr = explode (",", $Customer_String);
    $AccountType = $_POST['AccountType'];
    //$Employee_ID=$_SESSION['Employee_ID'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 
    $sql ="SELECT Customer_ID FROM Individual WHERE NIC='$Primary_Customer'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ 
            $Primary_Customer= $row["Customer_ID"];
        }
    }else{
        echo 'error';
    }
    if ($AccountType="Savings"){   
        echo '<h1>Application-Savings Account</h1>';
        echo '<form method="post" action="SavingsAccount.php">';
        echo'<input type="hidden" name="Branch_Str" value="'.$Branch_Str.'">';
        echo'Primary Customer<input type="text" name="Primary_Customer" value="'.$Primary_Customer.'" readonly><br><br>';
        echo'Other Customers<input type="text" name="Other_Customers" value="'.$Customer_String.'" readonly><br><br>';
        $sql = "SELECT * FROM Savings_Account_Plan"; //reading things from the table
        $result = $conn->query($sql);
        echo'<br>Account Type<select name="Account_Type">';
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){       //while loop
                //echo $row["bankname"];
                echo "<option   value=".$row["Plan_ID"].">".$row["Account_Plan"]."</option>";
            }
            echo "</select>";   
        }else{
            
        }
        echo'<br><br>Account Status<select name="Account_Status">';
        echo'<option value="Active" selected>Active</option>';
        echo'<option value="Inactive">Inactive</option>';
        echo'<option value="Cancelled">Cancelled</option></select>';
        echo'<br><br><input type="submit" value="Create the Savings Account">';
        echo'</form>';
        $conn->close();
        //echo '<a href="Branch.php" target="_blank">Visit W3Schools.com!</a> ';
    }
    elseif($AccountType="Checking"){
        echo'<input type="hidden" name="Branch_Str" value="'.$Branch_Str.'">'; //set inside the form here
    }

}
?>
