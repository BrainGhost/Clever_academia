<?php
//Initialize the session
session_start();

require_once("../../php/config.php");

// define variable and initialixze them with an empty string
$doctor_id = $doctor_schedule_date = $doctor_schedule_day = $doctor_schedule_start_time = $doctor_schedule_end_time = $average_consulting_time = "";
$doctor_id_err = $doctor_schedule_date_err = $doctor_schedule_start_time_err = $doctor_schedule_end_time_err = $average_consulting_time_err = $insert_msg = "";

if($_SESSION["level"] == "counselor"){
    $doctor_id = $_SESSION["id"];
}


// echo date_default_timezone_get();
// echo date(" l, 'Y-m-d H:i A'");

if(isset($_POST["action"]))
{
    if($_POST["action"] == 'delete')
	{
        
    }
} 
?>