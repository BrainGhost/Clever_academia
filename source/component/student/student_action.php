<?php
//Initialize the session
session_start();

require_once("../../php/config.php");

if (isset($_GET["deletedID"])) {
    $delete_id  = $_GET["deletedID"];
    # prepare statement
    $sql = "DELETE FROM mentor_application WHERE application_id=$delete_id";

    $result = mysqli_query($link, $sql);
    if ($result) {
        $_SESSION['insert_msg'] = "Deleted successfully.";
        $_SESSION['alert_notification'] = "delete";
        header("location: ./application.php");
    }else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}
if (isset($_GET["joinedGroup"]) && isset($_GET["joinedStudent"])) {
    $study_group_id = $_GET["joinedGroup"];
    $student_id = $_GET["joinedStudent"];
    $sql  = "SELECT * FROM join_study_group WHERE student_id = '$student_id' && study_group_id = $study_group_id";
            $result = mysqli_query($link, $sql);
            $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        $_SESSION['insert_msg'] = "Already, a member of this group.";
        $_SESSION['alert_notification_resources'] = 'warning';
        header("location: ./index.php");
    }else{
        $sql = "INSERT INTO join_study_group(student_id, study_group_id) VALUES ('$student_id', '$study_group_id')";
        $result = mysqli_query($link, $sql);
        if($result){
            $_SESSION['insert_msg'] = "You have joined successfully.";
            $_SESSION['alert_notification_resources'] = 'success';
            header("location: ./index.php");
            
        }else{
            header("location: ./index.php");
            $insert_msg = "Failed to insert Student.";
            mysqli_error($link);
        }
    }
}
#from the all group page
if (isset($_GET["joinedGroup_all"]) && isset($_GET["joinedStudent_all"])) {
    $study_group_id = $_GET["joinedGroup_all"];
    $student_id = $_GET["joinedStudent_all"];
    $sql  = "SELECT * FROM join_study_group WHERE student_id = '$student_id' && study_group_id = $study_group_id";
            $result = mysqli_query($link, $sql);
            $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        $_SESSION['insert_msg'] = "Already, a member of this group.";
        $_SESSION['alert_notification_resources'] = 'warning';
        header("location: ./groups.php");
    }else{
        $sql = "INSERT INTO join_study_group(student_id, study_group_id) VALUES ('$student_id', '$study_group_id')";
        $result = mysqli_query($link, $sql);
        if($result){
            $_SESSION['insert_msg'] = "You have joined successfully.";
            $_SESSION['alert_notification_resources'] = 'success';
            header("location: ./groups.php");
            
        }else{
            header("location: ./groups.php");
            $insert_msg = "Failed to insert Student.";
            mysqli_error($link);
        }
    }
}
#delete group by mentor
if (isset($_GET["group_deletedID"])) {
    $delete_id  = $_GET["group_deletedID"];
    # prepare statement
    $sql = "DELETE FROM study_group WHERE study_group_id=$delete_id";

    $result = mysqli_query($link, $sql);
    if ($result) {
        $_SESSION['insert_msg'] = "Deleted successfully.";
        $_SESSION['alert_notification'] = "delete";
        header("location: ./create_group.php");
    }else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}
#delete group by mentor
if (isset($_GET["leaveGroup"]) && isset($_GET["leaveStudent"])) {
    $leaveGroup_id  = $_GET["leaveGroup"];
    $LeaveStudent_id  = $_GET["leaveStudent"];
    # prepare statement
    $sql = "DELETE FROM join_study_group WHERE study_group_id=$leaveGroup_id && student_id=$LeaveStudent_id";

    $result = mysqli_query($link, $sql);
    if ($result) {
        $_SESSION['insert_msg'] = "You have successfully left the group.";
        $_SESSION['alert_notification'] = "delete";
        header("location: ./groups.php");
    }else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}