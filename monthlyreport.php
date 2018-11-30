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
    $current_device = $_GET["devices"];
}

$my = date_format($temp_date1, "m_Y");

if(mysqli_num_rows($result)>0){
    $delimiter = ",";
    $filename = "attendance_from_".$start_date."_to_".$end_date.".csv";
    
    //create a file pointer
    $file = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('Employee Name', 'Total Hours', 'Total Days', 'Total Overtime', 'Location');
    fputcsv($file, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
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
            $v_datas = $datas;
            $v_datas = implode(' | ', $datas);
            if(empty($datas)){
                $datas = "Not Present";
            }


            $checkin = new DateTime($datas[0]);
            $checkout = new DateTime($datas[count($datas)-1]);

            if(count($datas) > 1){

                if(date_format($checkin, 'l') == "Sunday"){
                    $overtime = round($checkin->diff($checkout)->h * 2);
                    echo date_format($checkin, 'l');
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

        
        $hours -= $total_overtime_hrs;
        $total_days = round($hours/9);

        $lineData = array($row["employee_name"], $hours, $total_days, $total_overtime_hrs." hrs ".$total_overtime_mins." mins", $location);
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
