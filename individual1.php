<?php
include('config.php');
include('session.php');
// error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['logout'])){
	session_destroy();
	header("location: index.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>IEEE Indvidual Dashboard</title>
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
	<span class="navbar-brand mb-0 h1" style="color: white">IEEE Attendance Manager</span>
	<form>

		<div class="container-login100-form-btn" style="padding-bottom: 15px">

			<input type="submit" name="logout" value="Logout" class="login100-form-btn">
		</div>
	</form>
</nav>

<body>
	<div class="container" style="padding-top:20px ">


		<div class="card text-center">
		  	<div class="card-header">
		    	Indvidual Log
		  	</div>
		  	<form action="individual_log1.php" method="post">
		 		<div class="card-body">
		 		
				  	<div class="row">
		            	<div class="col-md-3">
		                	<div class="form-group">
		                 		<select name="device" class="form-control">
		                 			<option >Select Location</option>
									<option value="14">IEEE Madras</option> <!--Changed 14 for IEEE login-->
								</select>
		                	</div>	                
		              <!-- /.form-group -->
		            	</div>
			            <div class="col-md-3">		                
			                 <div class="form-group">
			                  	<select name="month" class="form-control">
			                  		<option >Select Month</option>
									<option value="1">JAN</option>
									<option value="2">FEB</option>
									<option value="3">MAR</option>
									<option value="4">APR</option>
									<option value="5">MAY</option>
									<option value="6">JUN</option>
									<option value="7">JUL</option>
									<option value="8">AUG</option>
									<option value="9">SEP</option>
									<option value="10">OCT</option>
									<option value="11">NOV</option>
									<option value="12">DEC</option>
								</select>							
			                </div>
			            </div>
			            <div class="col-md-3">
			            	<div class="form-group">
			            		<select name="year" class="form-control">
			            			<option >Select Year</option>
									<option>2018</option>
									<option>2019</option>
									<option>2020</option>
								</select>
			            	</div>
			          	</div>
			          	<div class="col-md-3">
			            	<div class="form-group">
			            		<select name="empoyee_code" class="form-control">
			            			<option >Select Employee</option>
									<?php

										$device_query=mysqli_query($con,"SELECT EmployeeName as name , EmployeeCode as id FROM Employees WHERE Status = 'Working' AND id LIKE '12%");
										while($device=mysqli_fetch_assoc($device_query)) {
											// foreach ($device as $key => $value) {
											# code...
											echo "<option value='$device[id]'>$device[name]</option>"
											;
										// }
										
										}
									?>

								</select>
			            	</div>
			          	</div>

	          		</div>
          	
				</div>
				 <div class="card-footer text-muted">
				  	<div class="row">
				  		
				  		<div class="col-md-3 pull-right">
				  			<div class="form-group">
				  				<input type="submit" class="form-control btn btn-primary " name="sub" value="GET LOGS">
				  			</div>
				  			
				  		</div>
				  		

				  	</div>
				</div>
		</form>
		</div>
		

		</form>
		
<!-- 		<form action="monthly_logs.php" method="get"> 
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
				<label>Select Date Range:</label><br>
				<input style="border: 1px solid black; border-radius: 5px;" type="text" id="datepicker" placeholder="Select Start Date" name="start" />
				<input style="border: 1px solid black; border-radius: 5px;" type="text" id="datepicker2" placeholder="Select End Date" name="end" />
				<input type="submit" name="date" value="Get Logs" class="btn btn-primary btn-sm">
				<span class="focus-input100"></span>
			</div>
		</form>


		<form action="monthlyreport.php" method="get"> 
			<div class="wrap-input100 validate-input col-md-6">
				<input type="hidden" value="<?php echo $start_date; ?>" name="start_date" />
				<input type="hidden" value="<?php echo $end_date; ?>" name="end_date" />
				<input type="hidden" value="<?php echo $current_device; ?>" name="devices" />
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

				// function sumDateIntervals(DateInterval $a, DateInterval $b)
				// {
				// 	return new DateInterval(sprintf('P%dY%dM%dDT%dH%dM%dS',
				// 		$a->y + $b->y,
				// 		$a->m + $b->m,
				// 		$a->d + $b->d,
				// 		$a->h + $b->h,
				// 		$a->i + $b->i,
				// 		$a->s + $b->s
				// 	));
				// }
				while($row = mysqli_fetch_array($result)){

					
					$total_days = 0;
					$total_overtime_hrs = 0;
					$total_overtime_mins = 0;
					$hours = 0;


					$start_date = new DateTime(date_format($temp_date1, 'Y-m-d'));
					$end_date = new DateTime(date_format($temp_date2, 'Y-m-d'));
					// $end_date = new DateTime($year.'-'.$month.'-'.cal_days_in_month(CAL_GREGORIAN, $month, $year));
					// $end_date = $end_date->modify( '+1 day' );

					$daterange = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);

					// $start_date = date_format($start_date, 'Y-m-d');
					// $end_date = date_format($end_date, 'Y-m-d');
					// echo $start_date.'-'.$end_date;
					$location=" ";
					$datas=[];

					foreach($daterange as $dt){
						// echo $dt->format("Y-m-d") . "\n";
						
						$datas = [];
						$total_hours = 0;
						$overtime = 0;

						
						// echo $dt->format('Y-m-d');

						$current_date = $dt->format("Y-m-d");
						$emp_logs = "SELECT DeviceLogs_".$my.".LogDate as log_time, Devices.DeviceLocation as device_location FROM DeviceLogs_".$my." INNER JOIN Devices ON DeviceLogs_".$my.".DeviceId=Devices.DeviceId WHERE DeviceLogs_".$my.".DeviceId=".$current_device." AND DeviceLogs_".$my.".UserId=".$row["emp_id"]." AND date(DeviceLogs_".$my.".LogDate)='$current_date'";

						$emp_logs_data = mysqli_query($con,$emp_logs);

						while($data = mysqli_fetch_array($emp_logs_data)){
							// echo date('Y-m-d', strtotime($data["log_time"])).' == '.$dt->format('Y-m-d').'****';
							array_push($datas, $data["log_time"]);
							$location = $datas["device_location"];

						}
						

						$overtime = 0;
						$v_datas = implode(' | ', $datas);
						if(empty($datas)){
							$datas = "Not Present";
						}


						$checkin = new DateTime($datas[0]);
						$checkout = new DateTime($datas[count($datas)-1]);
						
						if(count($datas) > 1){

							if(date_format($checkin, 'l') == "Sunday"){
								$overtime = round($checkin->diff($checkout)->h * 2);
								//echo date_format($checkin, 'l');
								$total_overtime_hrs += $overtime;
								$hours += $checkin->diff($checkout)->h;
							}
							else {

								if(strtotime(date_format($checkin, 'H:i')) <= strtotime('09:20')){


									if(strtotime(date_format($checkout, 'H:i')) >= strtotime('17:40')){


										$total_hours = $checkin->diff($checkout);

										$min_hr_in_day = new DateTime('09:00');
										$total_hours = $total_hours->format("%H:%i");
										$total_hours = new DateTime($total_hours);
										$overtime = $total_hours->diff($min_hr_in_day);
										$total_days += 1;

									}

								}
								$total_overtime_hrs += $overtime->h;

								$total_overtime_mins += $overtime->i;

								$hours += $checkin->diff($checkout)->h;

							}
						}



					}



					$total_overtime_hrs += intval($total_overtime_mins/60);
					$total_overtime_mins = $total_overtime_mins%60;

					//$hours -= $total_overtime_hrs;
					$total_days = round($hours/9);

					echo '  
					<tr>  
					<td>'.$row["employee_name"].'</td> 
					<td>'.$hours.'</td>
					<td>'.$total_days.'</td>
					<td>'.$total_overtime_hrs.' hrs '.$total_overtime_mins.' mins</td>
					<td>'.$location.'</td>
					</tr>';  
					// 	$start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
					// }                                     

				}
				?>  
			</tbody>
		</table>
 -->
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
