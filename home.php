<?php
include('config.php');
include('session.php');
error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['logout'])){
	session_destroy();
	header("location: index.php");
}

if(isset($_GET['date'])){
	$temp_date = date_create($_GET['datepicker']);
	$date = date_format($temp_date, 'Y-m-d');
}
else {

	$datetime = new DateTime();
	$date = date_format($datetime, 'Y-m-d');
}
// $date = '2018-09-27';


// $get_logs = "SELECT employees.EmployeeName as employee_name, employees.EmployeeId as emp_id, devicelogs_processed.LogDate as log_date, devices.DeviceFName as device_name, devices.DeviceLocation as device_location  FROM employees LEFT JOIN devicelogs_processed ON employees.EmployeeId=devicelogs_processed.UserId INNER JOIN devices on devicelogs_processed.DeviceId=devices.DeviceId WHERE date(devicelogs_processed.LogDate)=".$date;

$get_logs = "SELECT employees.EmployeeName as employee_name, employees.EmployeeCode as emp_id FROM employees WHERE EmployeeName NOT LIKE 'Admin%' OR EmployeeName NOT REGEXP '^[0-9]'";

$result = mysqli_query($con,$get_logs);
echo $resultl

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Hoshitec India Dashboard</title>
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
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<!--===============================================================================================-->
	<!-- <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"> -->

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
	

</head>

<nav class="navbar navbar-light bg-dark">
	<span class="navbar-brand mb-0 h1" style="color: white">Hoshitec India Attendance Manager</span>
	<form>

		<div class="container-login100-form-btn" style="padding-bottom: 15px">

			<input type="submit" name="logout" value="Logout" class="login100-form-btn">
		</div>
	</form>
</nav>

<body>
	<div class="container" style="padding-top:20px ">
		<span class="login100-form-title">
			Dashboard
		</span>



		
		<form action="home.php" method="get"> 
			<div class="wrap-input100 validate-input col-md-6" data-validate = "Date is required">
				<label>Date:</label><br>
				<input style="border: 1px solid black; border-radius: 5px;" type="text" id="datepicker" placeholder="Select Date" name="datepicker" />
				<input type="submit" name="date" value="Get Logs" class="btn btn-primary btn-sm">
				<span class="focus-input100"></span>
			</div>
		</form>
		

		<div id="datepicker"></div>


		<div style="padding-top: 20px;padding-bottom: 10px">
			<span class="login100-form-title">
				<?php 
				echo 'Logs on '.$date;
				?>
			</span>
		</div>


		<table style="width: 100%" id="logs-table" class="table table-small table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th>Employee Name</th>
					<th>Log Time</th>
					<th>Total Hours</th>
					<th>Over Time</th>
					<th>Location</th>
				</tr>
			</thead>
			<tbody>
				<?php  
				while($row = mysqli_fetch_array($result))  
				{  
					$emp_logs = "SELECT devicelogs_processed.LogDate as log_time, devices.DeviceLocation as device_location FROM devicelogs_processed INNER JOIN devices ON devicelogs_processed.DeviceId=devices.DeviceId WHERE devicelogs_processed.UserId=".$row["emp_id"]." AND date(devicelogs_processed.LogDate)='$date'";


					// $emp_logs = "SELECT LogDate as log_time FROM devicelogs_processed WHERE UserId=".$row["emp_id"]." AND date(LogDate)='$date'";


					$emp_logs_data = mysqli_query($con,$emp_logs);
					$datas = [];
					$location = " ";
					while($data = mysqli_fetch_array($emp_logs_data)){
						array_push($datas, $data["log_time"]);
						$location = $data["device_location"];					
					}

					$total_hours = 0;
					$overtime = 0;
					if(count($datas) == 2){
						$checkin = date("H:i:s", strtotime($datas[0]));
						$checkout = date("H:i:s", strtotime($datas[1]));
						$total_hours = round(abs($checkout - $checkin));
						if($total_hours >= 8){
							$overtime = abs($total_hours - 8);
						}
					}else if(count($datas)%2 == 0 && count($datas) != 2){
						for($i = 0; $i < count($datas); $i=$i+2){
							$checkin = date("H:i:s", strtotime($datas[i+0]));
							$checkout = date("H:i:s", strtotime($datas[i+1]));
							$total_hours += round(abs($checkout - $checkin));
							if($total_hours >= 8){
								$overtime = abs($total_hours - 8);
							}
						}
					}
					else
					{

						$checkin = date("H:i:s", strtotime($datas[0]));
						$checkout = date("H:i:s", strtotime($datas[count($datas)-1]));
						$total_hours = round(abs($checkout - $checkin));
						if($total_hours >= 8){
							$overtime = abs($total_hours - 8);
						}
					}
					// for($datas as $values)

					$datas = implode(' | ', $datas);
					if(empty($datas)){
						$datas = "Not Present";
					}

					


					echo '  
					<tr>  
					<td>'.$row["employee_name"].'</td> 
					<td>'.$datas.'</td>
					<td>'.$total_hours.' hrs </td>
					<td>'.$overtime.'</td>
					<td>'.$location.'</td>
					</tr>';  
				}  
				?>  
			</tbody>
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
	
	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>$( "#datepicker" ).datepicker();</script>

	<!--===============================================================================================-->
	<script src="js/main.js"></script>

	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>      
	


</body>
</html>
