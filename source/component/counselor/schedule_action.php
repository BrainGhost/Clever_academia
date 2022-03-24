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

// date_default_timezone_set("Africa/Nairobi");
// echo date_default_timezone_get();
// echo date("H:i A");
// if($_POST["action"] == 'update')
// 	{
        
//     }


if (isset($_GET["delete_id"])) {
    $delete_id  = $_GET["delete_id"];
    # prepare statement
    $sql = "DELETE FROM doctor_schedule WHERE doctor_schedule_id=$delete_id";

    $result = mysqli_query($link, $sql);
    if ($result) {
        $_SESSION['insert_msg'] = "Deleted successfully.";
        $_SESSION['alert_notification'] = "delete";
        header("location: ./index.php");
    }else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}


// $update_id = $_POST["update_id"];
// echo $update_id;


// if($_POST["action"] == 'update')
// 	{
//         if(isset($_GET["update_id"]))
//         {
//             $update_id = $_POST["update_id"];
//             //variable
//             $doctor_schedule_date = date("Y-m-d", strtotime(trim($_POST['doctor_schedule_date'])));
//             $doctor_schedule_day = date("l", strtotime(trim($_POST['doctor_schedule_date'])));
//             $doctor_schedule_start_time = trim($_POST['doctor_schedule_start_time']);
//             $doctor_schedule_end_time = trim($_POST['doctor_schedule_end_time']);
//             $average_consulting_time = trim($_POST['average_consulting_time']);

//             //statement
//             $sql = "UPDATE doctor_schedule SET doctor_schedule_date='$doctor_schedule_date',doctor_schedule_day='$doctor_schedule_day',doctor_schedule_start_time='$doctor_schedule_start_time',doctor_schedule_end_time='$doctor_schedule_end_time',average_consulting_time='$average_consulting_time' WHERE doctor_schedule_id= $update_id ";
//             $result = mysqli_query($link, $sql);
//             if($result){
//                 $insert_msg = "Updated successfully.";
//                 $alert_notification = "success";
//                 // header("location: ./index.php");
//             }else{
//                 echo "Oops! Something went wrong. Please try later";
//                 die(mysqli_error($link));
//             }

//         }
//     }


#===========================the working code for updating=============================
        if(isset($_POST["update"]))
        {
            $update_id = trim($_POST['update_id']);
            //variable
            $doctor_schedule_date = date("Y-m-d", strtotime(trim($_POST['doctor_schedule_date'])));
            $doctor_schedule_day = date("l", strtotime(trim($_POST['doctor_schedule_date'])));
            $doctor_schedule_start_time = trim($_POST['doctor_schedule_start_time']);
            $doctor_schedule_end_time = trim($_POST['doctor_schedule_end_time']);
            $average_consulting_time = trim($_POST['average_consulting_time']);
        
            //statement
            $sql = "UPDATE doctor_schedule SET doctor_schedule_date='$doctor_schedule_date',doctor_schedule_day='$doctor_schedule_day',doctor_schedule_start_time='$doctor_schedule_start_time',doctor_schedule_end_time='$doctor_schedule_end_time',average_consulting_time='$average_consulting_time' WHERE doctor_schedule_id= $update_id ";
            $result = mysqli_query($link, $sql);
            if($result){
                $_SESSION['insert_msg'] = "Updated successfully.";
                $_SESSION['alert_notification'] = "update";
                header("location: ./index.php");
            }else{
                echo "Oops! Something went wrong. Please try later";
                die(mysqli_error($link));
            }
        
        } 

#===========================updating the status=============================

if(isset($_POST['update_status'])){
    $updateSTATUS_id = trim($_POST['updateSTATUS_id']);
    $updateSTATUS_TEXT = trim($_POST['updateSTATUS_TEXT']);
    
    //input status to be changes to
	if($updateSTATUS_TEXT == 1)
	{
        $next_status = 0;
	}elseif ($updateSTATUS_TEXT == 0) {
        $next_status = 1;
    }
    
    $sql = "UPDATE doctor_schedule SET schedule_status='$next_status' WHERE doctor_schedule_id= $updateSTATUS_id ";
    $result = mysqli_query($link, $sql);
        if($result){
            $_SESSION['insert_msg'] = "Status change successfully.";
            $_SESSION['alert_notification'] = "success";
            header("location: ./index.php");
        }else{
            echo "Oops! Something went wrong. Please try later";
            die(mysqli_error($link));
        }
}

// if($_POST["action"] == 'update')
// 	{
//     }
 

























// UPDATE FUNCTIONALITY
// $update_id  = $_GET["update_id"];
// $sql = "SELECT * FROM doctor_schedule doctor_schedule_id= $update_id ";
// $sql  = "SELECT doctor_schedule_id, doctor_schedule_date, (SELECT DAYNAME(doctor_schedule_date)) AS doctor_schedule_day, (SELECT TIME_FORMAT(doctor_schedule_start_time, ' %H:%i %p ')) AS doctor_schedule_start_time, (SELECT DAYNAME(doctor_schedule_date)) AS doctor_schedule_day, (SELECT TIME_FORMAT(doctor_schedule_end_time, ' %H:%i %p ')) AS doctor_schedule_end_time, average_consulting_time, doctor_id FROM doctor_schedule;";
// $result = mysqli_query($link, $sql);
// $row = mysqli_fetch_assoc($result);

// $date = $row['doctor_schedule_date'];
// $start_time = $row['doctor_schedule_start_time'];
// $end_time = $row['doctor_schedule_end_time'];
// $average_time = $row['average_consulting_time'];

if(isset($_POST["add"]))
{
    #check for validation
    if(empty($_POST['doctor_schedule_date'])){
        $doctor_schedule_date_err = "Date can not be empty";

    }elseif (trim($_POST['doctor_schedule_date']) < date('Y-m-d') ) {
        # check if the date inserted is > to the current data
        $doctor_schedule_date_err = "Invalid date, try the day ahead of the current one.";  
    }else{
        $doctor_schedule_date = date("Y-m-d", strtotime(trim($_POST['doctor_schedule_date'])));
        $doctor_schedule_day = date("l", strtotime(trim($_POST['doctor_schedule_date'])));
    }

    if(empty($_POST['doctor_schedule_start_time'])){
        $doctor_schedule_start_time_err = "Start time can not be empty";

    }elseif (trim($_POST['doctor_schedule_date']) == date('Y-m-d') && trim($_POST['doctor_schedule_start_time']) < date("H:i A") ) {
        # check if the time inserted is > to the current data
        $doctor_schedule_start_time_err = "Invalid time, try the time ahead of the current one.";
          
    }else{
        $doctor_schedule_start_time = trim($_POST['doctor_schedule_start_time']);
    }

    if(empty($_POST['doctor_schedule_end_time'])){
        $doctor_schedule_end_time_err = "End time can not be empty";

    }elseif (trim($_POST['doctor_schedule_date']) == date('Y-m-d') && trim($_POST['doctor_schedule_end_time']) < date("H:i A")) {
            # check if the time inserted is > to the current data
            $doctor_schedule_end_time_err = "Invalid time, try the time ahead of the current one."; 
          
    }else{
        $doctor_schedule_end_time = trim($_POST['doctor_schedule_end_time']);
    }
    
    if(empty($_POST['average_consulting_time'])){
        $average_consulting_time_err = "Average consulting can not be empty";
    }else{
        $average_consulting_time = trim($_POST['average_consulting_time']);
    }

    #insert data into the database if all the errors are cleared
    if (empty($doctor_id_err) && empty($doctor_schedule_date_err) && empty($doctor_schedule_start_time_err) && empty($doctor_schedule_end_time_err) && empty($average_consulting_time_err)) {
        # insert the data if all errors are lifted
        $sql = "UPDATE doctor_schedule SET doctor_schedule_date='$doctor_schedule_date',doctor_schedule_day='$doctor_schedule_day',doctor_schedule_start_time='$doctor_schedule_start_time',doctor_schedule_end_time='$doctor_schedule_end_time',average_consulting_time='$average_consulting_time' WHERE doctor_schedule_id= $update_id ";
        $result = mysqli_query($link, $sql);
        if($result){
            $insert_msg = "Updated successfully.";
            $alert_notification = "success";
        }else{
            echo "ERROR";
        }
    }        
}
?>


 