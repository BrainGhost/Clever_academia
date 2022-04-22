<?php
session_start();
require_once("../../php/config.php");
// $student_id = $_SESSION['student_id'];


#############################################
// change the timezone from berlin to kenya/nairobi
date_default_timezone_set("Africa/Nairobi");
$date = date("Y-m-d H:i:s");

if (isset($_POST['send'])) {
    $sender_id  = $_POST["student_sendMessage_id"];
    $senderGroup_id  = $_POST["group_sendMessage_id"];
    $senderMessage = $_POST["message_write"];

    $sql = "INSERT INTO peer_chat(message, time, status, incoming_id, outgoing_id ) VALUES ('$senderMessage','$date','0','$senderGroup_id', '$sender_id')";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo "Failed to insert resources.";
        mysqli_error($link);
    }
}
