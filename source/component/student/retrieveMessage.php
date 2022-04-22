<?php
require_once("../../php/config.php");
session_start();
$outgoingid = $_SESSION['student_id'];
$incomingid = mysqli_real_escape_string($link, $_POST['incomingid']);
//Display data into the table 
$sql  = "SELECT *  FROM chat_room 
    LEFT JOIN students ON chat_room.student_id=students.student_id
    WHERE study_group_id = '$incomingid'";

$result = mysqli_query($link, $sql);
$resultCheck = mysqli_num_rows($result);
#continue in the table itself

if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['lastname'] . ' ' . $row['firstname'];
        $message = $row['message'];
        $message_student_id = $row['student_id'];

        if ($message_student_id == $outgoingid) {
            $css_side = "bg-teal-50 pl-10 pr-4 rounded-l-2xl";
            $css_side_flex = "justify-end";
        } else {
            $css_side = "bg-teal-100 pr-10 pl-4 rounded-r-2xl";
            $css_side_flex = "justify-start";
        }
        // if ($mentor_name == $name) {
        //     $fullname = $name . '. ' . '<span class="text-[8px] text-red-500">Mentor</span>';
        // } else {
        //     $fullname = $name;
        // }
        if ($outgoingid == $row['student_id']) {
            $yourname =  'You';
        } else {
            $yourname = $name;
        }
        echo
        "
            <div class='send mt-2 flex $css_side_flex'>
                <div class='$css_side py-1 max-w-[25rem] border border-teal-300 rounded-t-2xl'>
                    <span class='text-teal-800 text-sm font-bold '>$yourname</span>
                    <div>
                        <p class='text-teal-600 text-sm float-right'>$message</p>
                    </div>
                </div>
            </div>
            ";
    }
    mysqli_free_result($result);
} else {
    echo
    "
        <div class='flex justify-center border border-teal-400 mt-10 rounded-xl bg-teal-50 p-2 text-xs font-bold text-teal-700 '>You have staterd a chat here.</div>
        ";
}
