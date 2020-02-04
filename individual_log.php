<?php
include('config.php');
include('session.php');
// error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['logout'])){
	session_destroy();
	header("location: index.php");
}

if(isset($_POST['sub'])){
	 $month=$_POST['month'];
	 $year=$_POST['year'];
	 $device=$_POST['device'];
	 $empoyee_code=$_POST['empoyee_code'];
	 if($device==9){
	 	$device_code=1101;
	 	$loc="BANGALORE";
	 }
	 else{
	 	$device_code=1102;
	 	$loc="GURGAON";
	 }
}

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
		<div class="container-login100-form-btn" style="padding-bottom: 15px">
			<a href='home.php' class="btn btn-primary">View Daily Logs</a>
		</div>

		


		<table style="width: 100%" id="logs-table" class="table table-small table-striped table-hover table-bordered">
			<thead>
				<tr>
					
					<th>Total Hours</th>
					<th>Total Days</th>
					<th>Total Over Time</th>
					<th>Location</th>
				</tr>
			</thead>
			<tbody>
				

				<?php 

					$query1="SELECT DISTINCT date(date_format(`LogDate`,'%Y-%m-%d')) as uniquedays FROM DeviceLogs_".$month."_".$year." WHERE `UserId`=".$empoyee_code." AND MONTH(`LogDate`)=".$month." AND YEAR(`LogDate`)=".$year;
					
					$res=mysqli_query($con,$query1);
						$sum=0;
						$oth=0;
						$otm=0;
						$days=0;
					while ($r=mysqli_fetch_array($res)) {
						$arr=[];
						$query2="SELECT * FROM DeviceLogs_".$month."_".$year." WHERE date(`LogDate`) = '".$r['uniquedays']."' AND UserId=".$empoyee_code;
						$query2_run=mysqli_query($con,$query2);
						while($date=mysqli_fetch_array($query2_run)){
							array_push($arr, $date['LogDate']);
						}
						$checkin=strtotime($arr[0]);
						$checkout=strtotime($arr[count($arr)-1]);
						$seconds=($checkout-$checkin);
						$hours = abs(floor($seconds / 3600));
						$mins = abs(floor($seconds / 60 % 60));
						$secs = abs(floor($seconds % 60));
						$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
						if($hours>=9){
							$oth=($oth+$hours)-9;
							$otm=$otm+$mins;
							if($otm>59){
								$oth++;
								$otm=0;
							}
						}
						$sum=$sum+$hours;
						$days++;
					}
					// echo "<br>";
					// echo "TOTAL HOURS=".$sum."<br>";
					// echo "OVERTIME= ".$oth." ".$otm;
					// echo "<br>";

					echo "<tr>";					
					echo "<td>".$sum." Hours</td>";
					echo "<td>".$days."</td>";
					echo "<td>".$oth." Hours ".$otm." Min</td>";
					echo "<td>".$loc."</td>";
					echo "</tr>";


					
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