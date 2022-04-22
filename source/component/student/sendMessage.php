<?php
session_start();
require_once("../../php/config.php");

if (isset($_POST['send'])) {
    $sender_id  = $_POST["student_sendMessage_id"];
    $senderGroup_id  = $_POST["group_sendMessage_id"];
    $senderMessage = $_POST["message_write"];


    $sql = "INSERT INTO chat_room(message, study_group_id, student_id, chat_status ) VALUES ('$senderMessage','$senderGroup_id','$sender_id', '0')";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo "Failed to insert resources.";
        mysqli_error($link);
    }
}
