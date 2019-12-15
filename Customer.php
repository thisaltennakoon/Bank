<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
?>
<!DOCTYPE html>
<html>
<body>
<h1>Step 1 : Add Members and Branches</h1><br>
<form method="post" action="Customer1.php">
    Enter NIC:<input type="text" name="NICs" size="50" required><i> eg:123456789V, 987654321V, 123454321V</i>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Bank"; // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $Primary_Branch_ID=$_SESSION['Primary_Branch_ID'];
        echo'<br><br>Select More Branches<br>';
        echo '<select name="Other_branches[]" multiple required>';
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
        echo '<br><p>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</p>';
    ?>
    <br><input type="submit" value="Apply"><br><br>
</form>
<br><a href="LogOut.php">Log Out</a>
</body>
</html>