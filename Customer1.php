<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}

if(isset($_POST) & !empty($_POST) ){
    $NICs = $_POST['NICs'];
    $Other_branches = $_POST['Other_branches'];
    $Branch_string="";
    $NIC_arr = explode (",", $NICs); 
    $NIC_arr_new=array();
    foreach($NIC_arr as $i){
        $i=trim($i);
        array_push($NIC_arr_new,$i);
    }
    $NIC_arr=$NIC_arr_new;
    $_SESSION['NIC_arr'] = $NIC_arr;
    $Other_branches_new=array();
    foreach($Other_branches as $i){
        $i=trim($i);
        array_push($Other_branches_new,$i);
    }
    $Other_branches=$Other_branches_new;
    $_SESSION['Other_branches'] = $Other_branches;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Bank"; // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    echo'<form method="post" action="Customer2.php">';
    foreach($NIC_arr as $NIC){
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
                $str1="";
                $str2="";
                $str3="";
                if ($Gender=="Male"){
                    $str1="selected";
                }
                elseif ($Gender=="Female"){
                    $str2="selected";
                }
                elseif ($Gender=="Other"){
                    $str3="selected";
                }   
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
            echo'<input type="hidden" name="'.$NIC.'-InsertOrUpdate" value="Update">';
            echo'<input type="hidden" name="'.$NIC.'-Customer_ID" value="'.$Customer_ID.'">';
            echo'NIC:<input type="text" name="'.$NIC.'-NIC" value="'.$NIC.'" readonly><br>';  
            echo'<input type="radio" name="Primary_Customer" value="'.$NIC.'" required>Select As Primary Customer<br>';
            echo'First Name:<input type="text" name="'.$NIC.'-firstname" value="'.$First_Name.'" required><br><br>';
            echo'Middle Name:<input type="text" name="'.$NIC.'-middlename" value="'.$Last_Name.'" required><br><br>';
            echo'Last Name:<input type="text" name="'.$NIC.'-lastname" value="'.$Middle_Name.'" required><br><br>';
            echo'Date of Birth:<input type="date" name="'.$NIC.'-DOB" value="'.$DOB.'" required><br><br>';
            echo'Address Line 1:<input type="text" name="'.$NIC.'-adr1" value="'.$Address_Line_1.'" onchange="myFunction()" required><br><br>';
            echo'Address Line 2:<input type="text" name="'.$NIC.'-adr2" value="'.$Address_Line_2.'" onchange="myFunction()" required><br><br>';
            echo'Address Line_3:<input type="text" name="'.$NIC.'-adr3" value="'.$Address_Line_3.'" onchange="myFunction()" required><br><br>';
            echo'Email:<input type="email" name="'.$NIC.'-email" value="'.$Primary_Email.'" required><br><br>';
            echo'Contact Number:<input type="text" name="'.$NIC.'-contactnumber" value="'.$Primary_Contact_No.'" required><br><br>';
            echo'<select name="'.$NIC.'-Gender">';
            echo'<option value="Male" '.$str1.'>Male</option>';
            echo'<option value="Female" '.$str2.'>Female</option>';
            echo'<option value="Other" '.$str3.'>Other</option></select>';
        }else{
            echo'<input type="hidden" name="'.$NIC.'-InsertOrUpdate" value="Insert">';
            echo'<input type="hidden" name="'.$NIC.'-Customer_ID" value="notset">';
            echo'NIC:<input type="text" name="'.$NIC.'-NIC" value="'.$NIC.'" readonly><br>';
            echo'<input type="radio" name="Primary_Customer" value="'.$NIC.'" required>Select As Primary Customer<br>';
            echo'First Name:<input type="text" name="'.$NIC.'-firstname" required><br><br>';
            echo'Middle Name:<input type="text" name="'.$NIC.'-middlename"><br><br>';
            echo'Last Name:<input type="text" name="'.$NIC.'-lastname"><br><br>';
            echo'Date of Birth:<input type="date" name="'.$NIC.'-DOB" required><br><br>';
            echo'Address Line 1:<input type="text" name="'.$NIC.'-adr1"><br><br>';
            echo'Address Line 2:<input type="text" name="'.$NIC.'-adr2"><br><br>';
            echo'Address Line_3:<input type="text" name="'.$NIC.'-adr3"><br><br>';
            echo'Email:<input type="email" name="'.$NIC.'-email" required><br><br>';
            echo'Contact Number:<input type="text" name="'.$NIC.'-contactnumber" required><br><br>';
            echo'<select name="'.$NIC.'-Gender">';
            echo'<option value="Male">Male</option>';
            echo'<option value="Female">Female</option>';
            echo'<option value="Other">Other</option></select>';
        }
        echo "<br><hr><br>";
    }

    echo'<input type="submit" value="Next">';
    echo'</form>';
    $conn->close();
}
    echo '<br><a href="LogOut.php">Log Out</a>';
?>