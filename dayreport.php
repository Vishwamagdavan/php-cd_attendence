<?php
//include database configuration file
include('config.php');
error_reporting(E_ERROR | E_PARSE);

//get records from database
$query = "SELECT EmployeeName as employee_name, EmployeeCode as emp_id FROM Employees WHERE EmployeeName NOT LIKE 'Admin%' OR EmployeeName NOT REGEXP '^[0-9]'";

$result = mysqli_query($con, $query);

if(isset($_GET['report'])){
    $temp_date = date_create($_GET['reportdate']);
    $date = date_format($temp_date, 'Y-m-d');
}

if(mysqli_num_rows($result)>0){
    $delimiter = ",";
    $filename = "attendance_in_" . $date . ".csv";
    
    //create a file pointer
    $file = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('Employee Name', 'Log Times', 'Total Hours', 'Over Time', 'Location');
    fputcsv($file, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = mysqli_fetch_array($result)){


        $emp_logs = "SELECT DeviceLogs_Processed.LogDate as log_time, Devices.DeviceLocation as device_location FROM DeviceLogs_Processed INNER JOIN Devices ON DeviceLogs_Processed.DeviceId=Devices.DeviceId WHERE DeviceLogs_Processed.UserId=".$row["emp_id"]." AND date(DeviceLogs_Processed.LogDate)='$date'";


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

        $datas = implode(' , ', $datas);
        if(empty($datas)){
            $datas = "Not Present";
        }

        $lineData = array($row["employee_name"], $datas, $total_hours, $overtime, $location);
        fputcsv($file, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($file, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($file);
}
exit;

?>
