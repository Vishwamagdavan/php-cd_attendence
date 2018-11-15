<?php
include('config.php');
include('session.php');
error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['logout'])){
	session_destroy();
	header("location: index.php");
}

if(isset($_GET['date'])){
	$datetime = date_create($_GET['datepicker']);
	$date = date_format($datetime, 'Y-m-d');
	$current_device = $_GET['device'];
}
else {

	$datetime = new DateTime();
	$date = date_format($datetime, 'Y-m-d');
	$current_device = 9;
}

$my = date_format($datetime, 'm_Y');
// $year = date_format($datetime, 'Y');


// $get_logs = "SELECT employees.EmployeeName as employee_name, employees.EmployeeId as emp_id, devicelogs_processed.LogDate as log_date, devices.DeviceFName as device_name, devices.DeviceLocation as device_location  FROM employees LEFT JOIN devicelogs_processed ON employees.EmployeeId=devicelogs_processed.UserId INNER JOIN devices on devicelogs_processed.DeviceId=devices.DeviceId WHERE date(devicelogs_processed.LogDate)=".$date;

$get_logs = "SELECT Employees.EmployeeName as employee_name, Employees.EmployeeCode as emp_id FROM Employees WHERE EmployeeName NOT LIKE 'Admin%' OR EmployeeName NOT REGEXP '^[0-9]'";

$result = mysqli_query($con,$get_logs);

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



		<div class="container-login100-form-btn" style="padding-bottom: 15px">
			<a href='monthly_logs.php' class="btn btn-sm btn-primary">View Monthly Logs</a>
		</div>

		<form action="home.php" method="get"> 
			<div class="wrap-input100 validate-input col-md-6" data-validate = "Date is required">
				<label for="device">Select Device Location</label>
				<select name="device">
					<option value='<?php echo $current_device; ?>'>-----SELECT-----</option>
					<?php 
					$device_query=mysqli_query($con,'SELECT DeviceId as id, DeviceLocation as location FROM Devices'); 
					while($device=mysqli_fetch_assoc($device_query)) { 
						echo "<option value='$device[id]'>$device[location]</option>";
					}
					?> 

				</select> 
			</div>
			<div class="wrap-input100 validate-input col-md-6" data-validate = "Date is required">
				<label>Date:</label><br>
				<input style="border: 1px solid black; border-radius: 5px;" type="text" id="datepicker" placeholder="Select Date" name="datepicker" />
				<input type="submit" name="date" value="Get Logs" class="btn btn-primary btn-sm">
				<span class="focus-input100"></span>
			</div>
		</form>

		<form action="dayreport.php" method="get"> 
			<div class="wrap-input100 validate-input col-md-6">
				<input type="hidden" value="<?php echo $date; ?>" name="reportdate" />
				<input type="hidden" value="<?php echo $current_device; ?>" name="devices" />
				<input type="submit" name="report" value="Generate Report" class="btn btn-primary btn-sm">
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
					<th>Attendance</th>
					<th>Location</th>
				</tr>
			</thead>
			<tbody>
				<?php  


				// function sumDateIntervals(DateInterval $a, DateInterval $b)
				// {
				// 	$mins = $a->i+$b->i;
				// 	$hrs = $a->h+$b->h;
				// 	if($mins >= 60){
				// 		$hrs += $mins/60;
				// 		$mins = $mins - 60
				// 	}
				// 	return new DateInterval(sprintf('P%dY%dM%dDT%dH%dM%dS',
				// 		$a->y + $b->y,
				// 		$a->m + $b->m,
				// 		$a->d + $b->d,
				// 		$a->h + $b->h,
				// 		$a->i + $b->i,
				// 		$a->s + $b->s
				// 	));
				// }


				while($row = mysqli_fetch_array($result))  
				{  
					$emp_logs = "SELECT DeviceLogs_".$my.".LogDate as log_time, Devices.DeviceLocation as device_location FROM DeviceLogs_".$my." INNER JOIN Devices ON DeviceLogs_".$my.".DeviceId=Devices.DeviceId WHERE DeviceLogs_".$my.".DeviceId=".$current_device." AND DeviceLogs_".$my.".UserId=".$row["emp_id"]." AND date(DeviceLogs_".$my.".LogDate)='$date'";


					// $emp_logs = "SELECT LogDate as log_time FROM devicelogs_processed WHERE UserId=".$row["emp_id"]." AND date(LogDate)='$date'";


					$emp_logs_data = mysqli_query($con,$emp_logs);
					$datas = [];
					$location = " ";
					while($data = mysqli_fetch_array($emp_logs_data)){
						array_push($datas, $data["log_time"]);
						$location = $data["device_location"];					
					}

					// $total_hours = 0;
					$overtime = 0;
					$v_datas = $datas;
					$v_datas = implode(' | ', $datas);
					if(empty($datas)){
						$datas = "Not Present";
					}
					if(count($datas) > 1){
						$checkin = new DateTime($datas[0]);
						$checkout = new DateTime($datas[count($datas)-1]);

						if(strtotime(date_format($checkin, 'H:i')) <= strtotime('09:20')){


							if(strtotime(date_format($checkout, 'H:i')) >= strtotime('17:40')){


								$total_hours = $checkin->diff($checkout);

								$min_hr_in_day = new DateTime('09:00');
								$total_hours = $total_hours->format("%H:%i");
								$total_hours = new DateTime($total_hours);
								$overtime = $total_hours->diff($min_hr_in_day);



								echo '  
								<tr>  
								<td>'.$row["employee_name"].'</td> 
								<td>'.$v_datas.'</td>
								<td>'.date_format($total_hours, 'H').' hrs '.date_format($total_hours, 'i').' mins</td>
								<td>'.$overtime->h.' hrs '.$overtime->i.' mins</td>
								<td>Present</td>
								<td>'.$location.'</td>
								</tr>';  

							}
							else{


								echo '  
								<tr>  
								<td>'.$row["employee_name"].'</td> 
								<td>'.$v_datas.'</td>
								<td>'.$checkin->diff($checkout)->format("%H hrs %i mins").'</td>
								<td>No Overtime</td>
								<td>Checked Out Early</td>
								<td>'.$location.'</td>
								</tr>';  

							}



						}
						else{
							echo '  
							<tr>  
							<td>'.$row["employee_name"].'</td> 
							<td>'.$v_datas.'</td>
							<td>'.$checkin->diff($checkout)->format("%H hrs %i mins").'</td>
							<td>'.$overtime->h.' hrs '.$overtime->i.' mins</td>
							<td>Checked In Late</td>
							<td>'.$location.'</td>
							</tr>';  
						}

						// $total_hours = $checkin->diff($checkout);

					}
					else{

						echo '  
						<tr>  
						<td>'.$row["employee_name"].'</td> 
						<td>No Logs</td>
						<td> No Work</td>
						<td> No Overtime </td>
						<td>Absent</td>
						<td>'.$location.'</td>
						</tr>';  
					}





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
