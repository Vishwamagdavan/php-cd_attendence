<?php
//include database configuration file
include('config.php');
error_reporting(E_ERROR | E_PARSE);

//get records from database
$query = "SELECT EmployeeName as employee_name, EmployeeCode as emp_id FROM Employees WHERE EmployeeName NOT LIKE 'Admin%' OR EmployeeName NOT REGEXP '^[0-9]'";

$result = mysqli_query($con, $query);

if(isset($_GET['report'])){
    $temp_date1 = date_create($_GET['start_date']);
    $temp_date2 = date_create($_GET['end_date']);
    $start_date = date_format($temp_date1, 'Y-m-d');
    $end_date = date_format($temp_date2, 'Y-m-d');
}

if(mysqli_num_rows($result)>0){
    $delimiter = ",";
    $filename = "attendance_from_".$start_date."_to_".$end_date.".csv";
    
    //create a file pointer
    $file = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('Employee Name', 'Total Hours', 'Total Days', 'Total OverTime', 'Location');
    fputcsv($file, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = mysqli_fetch_array($result)){


        $total_days = 0;

        $start_date = new DateTime(date_format($temp_date1, 'Y-m-d'));
        $end_date = new DateTime(date_format($temp_date2, 'Y-m-d'));
                    // $end_date = new DateTime($year.'-'.$month.'-'.cal_days_in_month(CAL_GREGORIAN, $month, $year));
                    // $end_date = $end_date->modify( '+1 day' );

        $daterange = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);

        $total_overtime = 0;
        $hours = 0;
        foreach($daterange as $dt){

            $datas = [];
            $location = " ";
            $total_hours = 0;
            $overtime = 0;
                        // echo $dt->format('Y-m-d');

            $current_date = $dt->format("Y-m-d");
            $emp_logs = "SELECT Devicelogs_Processed.LogDate as log_time, Devices.DeviceLocation as device_location FROM DeviceLogs_Processed INNER JOIN Devices ON DeviceLogs_Processed.DeviceId=Devices.DeviceId WHERE DeviceLogs_Processed.UserId=".$row["emp_id"]." AND date(DeviceLogs_Processed.LogDate)='$current_date'";

            $emp_logs_data = mysqli_query($con,$emp_logs);

            while($data = mysqli_fetch_array($emp_logs_data)){
                            // echo date('Y-m-d', strtotime($data["log_time"])).' == '.$dt->format('Y-m-d').'****';
                array_push($datas, $data["log_time"]);
                $location = $data["device_location"];                   

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

        $lineData = array($row["employee_name"], $hours, $total_days, $total_overtime, $location);
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
