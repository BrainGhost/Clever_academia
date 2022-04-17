<?php
session_start();
require_once("../../php/config.php");
    $sender_id  = $_POST["sendMessage_id"];
    $senderGroup_id  = $_POST["groupMessage_id"];
    $senderMessage = $_POST["message_write"];

    $sql = "INSERT INTO chat_room(message, join_study_group_id, student_id ) VALUES ('$senderMessage','$senderGroup_id','$sender_id')";
            $result = mysqli_query($link, $sql);
            if($result){
                header("location: ./single_group.php?joinedGroup=$senderGroup_id");
                
            }else{
                header("location: ./single_group.php?joinedGroup=$senderGroup_id");
                $insert_msg = "Failed to insert resources.";
                mysqli_error($link);
            }