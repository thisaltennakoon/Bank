<?php
session_start();
if (!isset($_SESSION['User'])& empty($_SESSION['User'])) {
    header('location: Login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple login form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
	.header {
  	background-color: #ff4500;

	width: 100%;
	
    background-size: 100%;
	background-repeat: no-repeat;
    background-size: cover;
    margin-left: auto;
    margin-right: auto;
  	padding: 20px;
  	text-align: center;
	position: absolute;
  	left: 0px;
  	top: 0px;
	}
      html {

      display: flex;
      justify-content: center;
      font-family: Roboto, Arial, sans-serif;
      font-size: 15px;

      } 
	  body {
      display: flex;
      justify-content: center;
      font-family: Roboto, Arial, sans-serif;
      font-size: 15px;
	  background-color: #FF8C00;
	  
      }
      form {
      border: 6px solid #FF7F50;
	  padding: 25px 50px;
	  position: absolute;
  	  top: 120px;
	  background-color: #FF7F50;

      }
      input[type=text], input[type=password],input[type=number] {
      width: 100%;
      padding: 16px 8px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
      }
      button {
      background-color: #006400;

      color: white;
      padding: 14px 0;
      margin: 10px 0;
      border: none;
      cursor: grabbing;
      width: 100%;
      }
      h1 {
      text-align:center;
      fone-size:18;
      }
      button:hover {

        background-color: #00FF00;

      }
      .formcontainer {
      text-align: left;
      margin: 24px 50px 12px;
	  
      }
      .container {
      padding: 16px 0;
      text-align:left;
      }
      span.psw {
      float: right;
      padding-bottom: 0;
      padding-right: 15px;
      }
	  span.aaa {
      float: left;
      padding-bottom: 0;
      padding-left: 15px;
      }
      /* Change styles for span on extra small screens */
      @media screen and (max-width: 300px) {
      span.psw {
      display: block;
      float: none;
      }
    </style>
  </head>

  <div class="header">
  <h1>BANK A SEYCHELLES</h1>
</div>
<body>
<
<form method="post" action="Customer1.php">
<h1>Add Members and Branches</h1>
<div class="formcontainer">
      <hr/>
  <div class="container"></div>
    <label for="NICs"><strong>Enter NIC</strong></label>
	<input type="text" name="NICs" size="50" required><i> eg:123456789V, 987654321V, 123454321V</i>
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
        echo'<br><br><strong>Select More Branches</strong><br>';
        echo '<select name="Other_branches[]" multiple size = 20 required>';
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
        echo '<br><p><strong>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.<strong></p>';
    ?>
    </div>
	<button type="submit">Apply</button>

<button onclick="window.location.href = 'home.php'">Home</button>
</form>
</body>
</html>