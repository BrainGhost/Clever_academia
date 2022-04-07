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