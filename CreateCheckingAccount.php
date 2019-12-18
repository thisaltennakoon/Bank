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
    $Account_Type = $_POST['AccountType'];
    $adr1 = $_POST["adr1"];
    $adr2 = $_POST["adr2"];
    $adr3 = $_POST["adr3"];
    $email = $_POST["email"];
    $Account_Status = $_POST["Account_Status"];
    $contactnumber = $_POST[$NIC."-contactnumber"];
    if ($Account_Type=='Organizational'){
        $Registration_Number = $_POST["Registration_Number"];
        $Name = $_POST["Name"];
        $sql = "INSERT INTO Customer (Address_Line_1,Address_Line_2,Address_Line_3,Primary_Email,Primary_Contact_No) VALUES ('$adr1','$adr2','$adr3','$email','$contactnumber')";
        if ($conn->query($sql) === TRUE) {
            $Customer_ID = $conn->insert_id;
            $sql = "INSERT INTO Organization (Customer_ID,Name,Bussiness_Registration_Number) VALUES ('$Customer_ID','$Name','$Registration_Number')";
            if ($conn->query($sql) === TRUE) {
                $sql = "INSERT INTO Organization_Individual (Organization_ID,Individual_ID) VALUES ('$Customer_ID','$Name','$Registration_Number')";
                if ($conn->query($sql) === TRUE) {
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }

    }
}
CREATE TABLE Organization(
    Customer_ID INT,
    Name VARCHAR(50) NOT NULL,
    Bussiness_Registration_Number VARCHAR(20),
    PRIMARY KEY(Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) /*ON DELETE SET NULL*/
);
CREATE TABLE Organization_Individual(
    Organization_ID INT,
    Individual_ID INT,
    FOREIGN KEY (Organization_ID) REFERENCES Organization(Customer_ID),
    FOREIGN KEY (Individual_ID) REFERENCES Individual(Customer_ID)
);