<?php
function ViewAccountDetails($accnumber,$conn){

        $sql1 = "SELECT * FROM Account WHERE Account_No=".$accnumber;
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            while($row1 = $result1->fetch_assoc()) {
                echo '<br><b>Account Details</b>';
                echo '<br>Account Number : '.$accnumber;
                echo '<br>Balance : '.$row1["Balance"];
                echo '<br>Account Status : '.$row1["Account_Status"];  
                echo '<br>Date Created : '.$row1["Date_Created"];     
                echo '<hr>'; 
                $sql3 = "SELECT * FROM Branch WHERE Branch_ID=".$row1["Primary_Branch_ID"];
                $result3 = $conn->query($sql3);
                if ($result3->num_rows > 0) {
                    while($row3 = $result3->fetch_assoc()) {
                        echo '<b>Primary Branch Details</b>';
                        echo '<br>Branch ID : '.$row1["Primary_Branch_ID"];
                        echo '<br>Branch Name : '.$row3["Branch_Name"];
                        echo '<br>Branch Location : '.$row3["Location"];
                        echo '<hr>'; 
                    }
                }
                $sql8 = "SELECT * FROM Account_Branch INNER JOIN Branch ON Account_Branch.Branch_ID=Branch.Branch_ID WHERE Account_No=".$accnumber;
                $result8 = $conn->query($sql8);
                if ($result8->num_rows > 0) {
                    echo '<b>Other Branch Details</b>';
                    while($row8 = $result8->fetch_assoc()) {
                        echo '<br>Branch ID : '.$row8["Branch_ID"];
                        echo '<br>Branch Name : '.$row8["Branch_Name"];
                        echo '<br>Branch Location : '.$row8["Location"].'<br>';                     
                    }
                    echo '<hr>';
                }
                $sql9 = "SELECT * FROM Customer_Account INNER JOIN Customer ON Customer_Account.Customer_ID=Customer.Customer_ID INNER JOIN Individual ON Customer.Customer_ID=Individual.Customer_ID WHERE Account_No=".$accnumber;
                $result9 = $conn->query($sql9);
                if ($result9->num_rows > 0) {
                    echo '<b>Other Customer Details</b>';
                    while($row9 = $result9->fetch_assoc()) {
                        echo '<br>Customer ID : '.$row9["Customer_ID"];
                        echo '<br>Address : '.$row9["Address_Line_1"].' ,'.$row9["Address_Line_2"].' ,'.$row9["Address_Line_3"];
                        echo '<br>Email : '.$row9["Primary_Email"];
                        echo '<br>Contact Number : '.$row9["Primary_Contact_No"];
                        echo '<br>Name : '.$row9["First_Name"].' '.$row9["Middle_Name"].' '.$row9["Last_Name"];
                        echo '<br>NIC : '.$row9["NIC"];
                        echo '<br>Date of Birth : '.$row9["DOB"];
                        echo '<br>Gender : '.$row9["Gender"].'<br>';                     
                    }
                    echo '<hr>';
                }
                $sql4 = "SELECT * FROM Customer WHERE Customer_ID=".$row1["Primary_Customer_ID"];
                $result4 = $conn->query($sql4);
                if ($result4->num_rows > 0) {
                    while($row4 = $result4->fetch_assoc()) {
                        echo '<b>Primary Customer Details</b>';
                        echo '<br>Primary Customer ID : '.$row1["Primary_Customer_ID"];
                        echo '<br>Address : '.$row4["Address_Line_1"].' ,'.$row4["Address_Line_2"].' ,'.$row4["Address_Line_3"];
                        echo '<br>Email : '.$row4["Primary_Email"];
                        echo '<br>Contact Number : '.$row4["Primary_Contact_No"];
                    }
                }
                $sql2 = "SELECT * FROM Checking_Account WHERE Account_No=".$accnumber;
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while($row2 = $result2->fetch_assoc()) {                    
                        $sql5 = "SELECT * FROM Individual WHERE Customer_ID=".$row1["Primary_Customer_ID"];
                        $result5 = $conn->query($sql5);
                        if ($result5->num_rows > 0) {
                            while($row5 = $result5->fetch_assoc()) {                            
                                echo '<br>Name : '.$row5["First_Name"].' '.$row5["Middle_Name"].' '.$row5["Last_Name"];
                                echo '<br>NIC : '.$row5["NIC"];
                                echo '<br>Date of Birth : '.$row5["DOB"];
                                echo '<br>Gender : '.$row5["Gender"];                             
                            }
                            echo '<hr>';
                            echo 'Checking Account Type : Checking Account Non-Organizational';
                            echo '<hr>';
                        }
                        $sql6 = "SELECT * FROM Organization WHERE Customer_ID=".$row1["Primary_Customer_ID"];
                        $result6 = $conn->query($sql6);
                        if ($result6->num_rows > 0) {
                            while($row6 = $result6->fetch_assoc()) {                            
                                echo '<br>Name : '.$row6["Name"];
                                echo '<br>Bussiness Registration Number : '.$row6["Bussiness_Registration_Number"];
                            }
                            echo '<hr>'; 
                            echo 'Checking Account Type : Checking Account Organizational';
                            echo '<hr>';
                        }
                    }
                }
                $sql10 = "SELECT * FROM Savings_Account INNER JOIN Savings_Account_Plan ON Savings_Account.Account_Plan_ID=Savings_Account_Plan.Plan_ID WHERE Account_No=".$accnumber;
                $result10 = $conn->query($sql10);
                if ($result10->num_rows > 0) {
                    while($row10 = $result10->fetch_assoc()) {                    
                        $sql11 = "SELECT * FROM Individual WHERE Customer_ID=".$row1["Primary_Customer_ID"];
                        $result11 = $conn->query($sql11);
                        if ($result11->num_rows > 0) {
                            while($row11 = $result11->fetch_assoc()) {                            
                                echo '<br>Name : '.$row11["First_Name"].' '.$row11["Middle_Name"].' '.$row11["Last_Name"];
                                echo '<br>NIC : '.$row11["NIC"];
                                echo '<br>Date of Birth : '.$row11["DOB"];
                                echo '<br>Gender : '.$row11["Gender"];                             
                            }
                            echo '<hr>';
                            echo 'Savings Account Type : '.$row10["Account_Plan"];
                            echo '<br>Number of Withdrawals : '.$row10["Number_of_Withdrawals"];
                            echo '<hr>';
                            if ($row10["Account_Plan_ID"]==1){
                                echo '<b>Child Details</b>';
                                $sql12 = "SELECT * FROM Child_Savings_Account WHERE Account_No=".$accnumber;
                                $result12 = $conn->query($sql12);
                                if ($result12->num_rows > 0) {
                                    while($row12 = $result12->fetch_assoc()) { 
                                        echo '<br>Name : '.$row12["First_Name"].' '.$row12["Middle_Name"].' '.$row12["Last_Name"];
                                        echo '<br>Date of Birth : '.$row12["DOB"];
                                        echo '<br>Gender : '.$row12["Gender"];  
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }else{
            echo "The Account Number that you've entered doesn't match any account.";
        }
    }
?>