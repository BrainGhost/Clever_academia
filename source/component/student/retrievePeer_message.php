<?php
session_start();
require_once("../../php/config.php");
// $student_id = $_SESSION['student_id'];


$outgoingid = $_SESSION['student_id'];
$incomingid = mysqli_real_escape_string($link, $_POST['incomingid']);
//Display data into the table 
$sql  = "SELECT *  FROM peer_chat
LEFT JOIN students ON peer_chat.incoming_id=students.student_id
WHERE incoming_id = '$incomingid' AND outgoing_id = '$outgoingid'";

$result = mysqli_query($link, $sql);
$resultCheck = mysqli_num_rows($result);
#continue in the table itself

if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['lastname'] . ' ' . $row['firstname'];
        $message = $row['message'];

        if ($outgoingid) {
            $css_side = "bg-teal-50 pl-10 pr-4 rounded-l-2xl";
            $css_side_flex = "justify-end";
        } else {
            $css_side = "bg-teal-100 pr-10 pl-4 rounded-r-2xl";
            $css_side_flex = "justify-start";
        }

        if ($outgoingid == $row['outgoing_id']) {
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
    <div class='flex justify-center border border-teal-400 mt-10 rounded-xl bg-teal-50 font-bold p-5 text-teal-700 '>You have staterd a chat here.</div>
    ";
}
