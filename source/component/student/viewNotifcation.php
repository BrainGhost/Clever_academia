<?php
session_start();
require_once("../../php/config.php");
$student_id = $_SESSION['student_id'];
// $groupID = mysqli_real_escape_string($link, $_POST['groupID']);

if (isset($_POST['data'])) {
    $sql = "SELECT COUNT(*) AS tot_number FROM chat_room WHERE student_id != $student_id && chat_status = 0 ";
    $result = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<span>" . $row['tot_number'] . "</span>";
    }
}

if (isset($_POST['update'])) {
    $sql = "UPDATE chat_room SET chat_status = 1  WHERE student_id != $student_id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo "Failed to insert resources.";
        mysqli_error($link);
    }
}
