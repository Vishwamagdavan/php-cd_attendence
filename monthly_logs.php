<?php
include('config.php');
include('session.php');
error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['logout'])){
	session_destroy();
	header("location: index.php");
}

if(isset($_GET['date'])){
	$temp_date1 = date_create($_GET['start']);
	$temp_date2 = date_create($_GET['end']);
	$start_date = date_format($temp_date1, 'Y-m-d');
	$end_date = date_format($temp_date2, 'Y-m-d');
}
else {

	$temp_date1 = new DateTime();
	$temp_date2 = $temp_date1->modify( '+10 day' );
	$start_date = date_format($temp_date1, 'Y-m-d');
	$end_date = date_format($temp_date2, 'Y-m-d');
}
// $date = '2018-09-27';


// $get_logs = "SELECT employees.EmployeeName as employee_name, employees.EmployeeId as emp_id, devicelogs_processed.LogDate as log_date, devices.DeviceFName as device_name, devices.DeviceLocation as device_location  FROM employees LEFT JOIN devicelogs_processed ON employees.EmployeeId=devicelogs_processed.UserId INNER JOIN devices on devicelogs_processed.DeviceId=devices.DeviceId WHERE date(devicelogs_processed.LogDate)=".$date;

$get_logs = "SELECT Employees.EmployeeName as employee_name, Employees.EmployeeCode as emp_id FROM Employees WHERE EmployeeName NOT LIKE 'Admin%' OR EmployeeName NOT REGEXP '^[0-9]'";

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
			Monthly Dashboard
		</span>


		<div class="container-login100-form-btn" style="padding-bottom: 15px">
			<a href='home.php' class="btn btn-sm btn-primary">View Daily Logs</a>
		</div>
		
		<form action="monthly_logs.php" method="get"> 
			<div class="wrap-input100 validate-input col-md-6" data-validate = "Date is required">
				<label>Select Date Range:</label><br>
				<input style="border: 1px solid black; border-radius: 5px;" type="text" id="datepicker" placeholder="Select Start Date" name="start" />
				<input style="border: 1px solid black; border-radius: 5px;" type="text" id="datepicker2" placeholder="Select End Date" name="end" />
				<input type="submit" name="date" value="Get Logs" class="btn btn-primary btn-sm">
				<span class="focus-input100"></span>
			</div>
		</form>


		<form action="monthlyreport.php" method="get"> 
			<div class="wrap-input100 validate-input col-md-6">
				<input style="border: 1px solid black; border-radius: 5px;" type="hidden" value="<?php echo $start_date; ?>" name="start_date" />
				<input style="border: 1px solid black; border-radius: 5px;" type="hidden" value="<?php echo $end_date; ?>" name="end_date" />
				<input type="submit" name="report" value="Generate Report" class="btn btn-primary btn-sm">
				<span class="focus-input100"></span>
			</div>
		</form>
		

		<div id="datepicker"></div>


		<div style="padding-top: 20px;padding-bottom: 10px">
			<span class="login100-form-title">
				<?php 
				echo 'Attendance from '.date_format($temp_date1, 'd/m/Y').'-'.date_format($temp_date2, 'd/m/Y');
				?>
			</span>
		</div>


		<table style="width: 100%" id="logs-table" class="table table-small table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th>Employee Name</th>
					<th>Total Hours</th>
					<th>Total Days</th>
					<th>Total Over Time</th>
					<th>Location</th>
				</tr>
			</thead>
			<tbody>
				<?php  
				while($row = mysqli_fetch_array($result)){


					// $emp_logs = "SELECT devicelogs_processed.LogDate as log_time, devices.DeviceLocation as device_location FROM devicelogs_processed INNER JOIN devices ON devicelogs_processed.DeviceId=devices.DeviceId WHERE devicelogs_processed.UserId=".$row["emp_id"]." AND month(devicelogs_processed.LogDate)='$month' AND year(devicelogs_processed.LogDate)='$year'";


					// // $emp_logs = "SELECT LogDate as log_time FROM devicelogs_processed WHERE UserId=".$row["emp_id"]." AND date(LogDate)='$date'";


					// $emp_logs_data = mysqli_query($con,$emp_logs);
					
					$total_days = 0;

					$start_date = new DateTime(date_format($temp_date1, 'Y-m-d'));
					$end_date = new DateTime(date_format($temp_date2, 'Y-m-d'));
					// $end_date = new DateTime($year.'-'.$month.'-'.cal_days_in_month(CAL_GREGORIAN, $month, $year));
					// $end_date = $end_date->modify( '+1 day' );

					$daterange = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);

					// $start_date = date_format($start_date, 'Y-m-d');
					// $end_date = date_format($end_date, 'Y-m-d');
					// echo $start_date.'-'.$end_date;
					
					$total_overtime = 0;
					$hours = 0;
					foreach($daterange as $dt){
						// echo $dt->format("Y-m-d") . "\n";
						
						$datas = [];
						$total_hours = 0;
						$overtime = 0;
						
						// echo $dt->format('Y-m-d');

						$current_date = $dt->format("Y-m-d");
						$emp_logs = "SELECT DeviceLogs_Processed.LogDate as log_time, Devices.DeviceLocation as device_location FROM DeviceLogs_Processed INNER JOIN Devices ON DeviceLogs_Processed.DeviceId=Devices.DeviceId WHERE DeviceLogs_Processed.UserId=".$row["emp_id"]." AND date(DeviceLogs_Processed.LogDate)='$current_date'";

						$emp_logs_data = mysqli_query($con,$emp_logs);

						while($data = mysqli_fetch_array($emp_logs_data)){
							// echo date('Y-m-d', strtotime($data["log_time"])).' == '.$dt->format('Y-m-d').'****';
							array_push($datas, $data["log_time"]);
							$location = $datas["device_location"];

						}
						


						if(count($datas) == 2){
							$checkin = date("H:i:s", strtotime($datas[0]));
							$checkout = date("H:i:s", strtotime($datas[1]));
							$total_hours = round(abs($checkout - $checkin));
							if($total_hours >= 9){
								$overtime = abs($total_hours - 9);
							}
						}else if(count($datas)%2 == 0 && count($datas) != 2){
							for($i = 0; $i < count($datas); $i=$i+2){
								$checkin = date("H:i:s", strtotime($datas[i+0]));
								$checkout = date("H:i:s", strtotime($datas[i+1]));
								$total_hours += round(abs($checkout - $checkin));
								if($total_hours >= 9){
									$overtime = abs($total_hours - 9);	
								}
							}
						}
						else
						{

							$checkin = date("H:i:s", strtotime($datas[0]));
							$checkout = date("H:i:s", strtotime($datas[count($datas)-1]));
							$total_hours = round(abs($checkout - $checkin));
							if($total_hours >= 9){
								$overtime = abs($total_hours - 9);
							}
						}


						$total_overtime += $overtime;
						$hours += $total_hours;
						if(abs($total_hours - $overtime) == 9){
							$total_days += 1;
						}
					}
					// 	$start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
					// }                                     


					echo '<tr>  
					<td>'.$row["employee_name"].'</td> 
					<td>'.$hours.' hrs</td>
					<td>'.$total_days.' days</td>
					<td>'.$total_overtime.' hrs</td>
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
	<script>
		$( "#datepicker" ).datepicker();
		$( "#datepicker2" ).datepicker();
	</script>

	<!--===============================================================================================-->
	<script src="js/main.js"></script>

	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>      



</body>
</html>
