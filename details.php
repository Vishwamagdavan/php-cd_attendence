<?php
require 'config.php';
session_start();
if(!$_SESSION['user']){
	header('location:index.php');
}
if(!($_POST['device']||$_POST['date'])){
		header('location:home.php');
}
if(isset($_POST['logout'])){
	session_destroy();
}

$device=$_POST['device'];
$date=$_POST['date'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Attendance</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>

<nav class="navbar navbar-light bg-dark">
  <span class="navbar-brand mb-0 h1" style="color: white">Home</span>
  <form>
  
  					<div class="container-login100-form-btn" style="padding-bottom: 15px">
						<input type="submit" name="logout" value="Logout" class="login100-form-btn">
					</div>
</form>
</nav>

<body>
	<div class="container" style="padding-top:20px ">	
		<span class="login100-form-title">
			Details
		</span>
	<form method="post" action="details.php">
		<div class="row">	
					<div class="wrap-input100 validate-input col-md-6" data-validate = "Device is required">
						<label>Device name:</label><br>
						<select class="input100" name="device">

<?php

$query="SELECT * FROM devices";
$query_run=mysqli_query($con,$query);
foreach ($query_run as $key) {
?>

						<option><?php 	echo $key['DeviceId']; ?></option>

<?php 	} ?>
							
						</select>
						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 validate-input col-md-6" data-validate = "Date is required">
						<label>Date:</label><br>
						<input class="input100" type="date" name="date" placeholder="Date">
						<span class="focus-input100"></span>
					</div>				
		</div>
 					<div class="container-login100-form-btn" style="padding-bottom: 15px">
						<input type="submit" name="logout" value="Get Details" class="login100-form-btn">
					</div>			
	</form>

<div style="padding-top: 20px;padding-bottom: 10px">
		<span class="login100-form-title">
			Today's Logs
		</span>
</div>


<table style="width: 100%" border="1">
	<tr>
		<th>ID</th>
		<th>Logdate</th>
		<th>Direction</th>
	</tr>

<?php 	
$query1="SELECT * FROM devicelogs_10_2018 WHERE cast(LogDate as date)='$date' AND DeviceId='$device'";
$query_run1=mysqli_query($con,$query1);
if (mysqli_num_rows($query_run1)>0) {
foreach ($query_run1 as $value) {?>
	<tr>
		<td><?php 	echo $value['UserId']; ?></td>
		<td><?php 	echo $value['LogDate']; ?></td>
		<td><?php 	echo $value['Direction']; ?></td>
	</tr>


<?php 	}}
else{
echo "Nothing to display";
}

 ?>

</table>

	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>