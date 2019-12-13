<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
if(isset($_GET['Customer_ID'])){
    $Customer_ID=$_GET['Customer_ID'];
    $Employee_ID=$_SESSION['Employee_ID'];
    //echo $Employee_ID;
    //echo '<br>';
    //echo $Customer_ID;
    //echo '<br>';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql ="SELECT Branch_ID FROM Employee WHERE Employee_ID='$Employee_ID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ 
            $Branch_ID= $row["Branch_ID"];
            //echo $Branch_ID;
        }
    }else{
        echo 'error aojfvsagns';
    }

    echo '<h1>Application-Savings Account</h1>';
    echo '<form method="post" action="SavingsAccount2_1.php">';
    echo'<input type="hidden" name="Customer_ID" value="'.$Customer_ID.'" readonly><br><br>';
    echo'<input type="hidden" name="Branch_ID" value="'.$Branch_ID.'" readonly><br><br>';
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
    echo'<option value="Active">Active</option>';
    echo'<option value="Inactive">Inactive</option>';
    echo'<option value="Cancelled">Cancelled</option></select>';
    echo'<br><br><input type="submit" value="Create the Savings Account">';
    echo'</form>';
    $conn->close();
}
echo '<br><a href="LogOut.php">Log Out</a>';
?>