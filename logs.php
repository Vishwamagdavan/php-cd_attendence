<?php
include('config.php');

$get_logs = "SELECT employees.EmployeeName as employee_name, devicelogs_processed.LogDate as log_date, devices.DeviceFName as device_name, devices.DeviceLocation as device_location  FROM devicelogs_processed INNER JOIN employees ON devicelogs_processed.UserId=employees.EmployeeId INNER JOIN devices on devicelogs_processed.DeviceId=devices.DeviceId";


$result = mysqli_query($con,$get_logs);


while($row = $result->fetch_array(MYSQLI_ASSOC)){
  $data[] = $row;
}


$results = ["sEcho" => 1,
        	"iTotalRecords" => count($data),
        	"iTotalDisplayRecords" => count($data),
        	"aaData" => $data ];


echo json_encode($results);

 
?>