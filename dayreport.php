<?php
//include database configuration file
include('config.php');
error_reporting(E_ERROR | E_PARSE);

//get records from database

if(isset($_GET['report'])){
    $temp_date = date_create($_GET['reportdate']);
    $date = date_format($temp_date, 'Y-m-d');
    $current_device = $_GET["devices"];
        if($current_device==9){
        $device_emp_code=1101;
    }
    else{
        $device_emp_code=1102;
    }

    $query = "SELECT EmployeeName as employee_name, EmployeeCode as emp_id FROM Employees WHERE LEFT(EmployeeCode,4)='$device_emp_code'";

    $result = mysqli_query($con, $query);

}

$my = date_format($temp_date, "n_Y");

if(mysqli_num_rows($result)>0){
    $delimiter = ",";
    $filename = "attendance_in_" . $date . ".csv";
    
    //create a file pointer
    $file = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('Employee Name', 'Log Times', 'Total Hours', 'Over Time', 'Attendance', 'Location');
    fputcsv($file, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = mysqli_fetch_array($result)){


       $emp_logs = "SELECT DeviceLogs_".$my.".LogDate as log_time, Devices.DeviceLocation as device_location FROM DeviceLogs_".$my." INNER JOIN Devices ON DeviceLogs_".$my.".DeviceId=Devices.DeviceId WHERE DeviceLogs_".$my.".DeviceId=".$current_device." AND DeviceLogs_".$my.".UserId=".$row["emp_id"]." AND date(DeviceLogs_".$my.".LogDate)='$date'";



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


                $lineData = array($row["employee_name"], $v_datas, date_format($total_hours, 'H').' hrs '.date_format($total_hours, 'i'), $overtime->h.' hrs '.$overtime->i.' mins', "Present", $location);
                fputcsv($file, $lineData, $delimiter);

            }
            else{


                $lineData = array($row["employee_name"], $v_datas, $checkin->diff($checkout)->format('%H hrs %i mins'), $overtime->h.' hrs '.$overtime->i.' mins', "Checked Out Early", $location);
                fputcsv($file, $lineData, $delimiter);

            }



        }
        else{

            $lineData = array($row["employee_name"], $v_datas, $checkin->diff($checkout)->format('%H hrs %i mins'), $overtime->h.' hrs '.$overtime->i.' mins', "Checked In Late", $location);
            fputcsv($file, $lineData, $delimiter);
        }


    }
    else{

        $lineData = array($row["employee_name"], "No Logs", "No Work", "No Overtime", "Absent", $location);
        fputcsv($file, $lineData, $delimiter);
    }



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
