<?php
include("../../php/config.php");
include('./asset/Header.php');
if (!isset($_SESSION['student_id'])) {
    header("location: ../../pages/index.php");
}


// <!-- NOTIFICATION ALERTS -->
$insert_msg = "";
$student_id = $_SESSION['student_id'];

if (isset($_GET["sender_id"])) {
    $sender_id = $_GET["sender_id"];
} else {
    $sender_id = $student_id;
}

if ($_SESSION['insert_msg'] !== "") {
    $action = "";

    $action = $_SESSION['alert_notification_resources'];
    switch ($action) {
        case 'success':
            $alert_msg = "Success";
            $alert_div_color = 'bg-emerald-100 border-emerald-500 text-emerald-700';
            $alert_btn_color = 'bg-emerald-200 text-emerald-700';
            break;

        case 'update':
            $alert_msg = "Update";
            $alert_div_color = 'bg-sky-100 border-sky-500 text-sky-700';
            $alert_btn_color = 'bg-sky-200 text-sky-700';
            break;

        case 'delete':
            $alert_msg = "Delete";
            $alert_div_color = 'bg-red-100 border-red-500 text-red-700';
            $alert_btn_color = 'bg-red-200 text-red-700';
            break;

        default:
            $alert_msg = "Be Warned";
            $alert_div_color = 'bg-orange-100 border-orange-500 text-orange-700';
            $alert_btn_color = 'bg-orange-200 text-orange-700';
            break;
    }

?>
    <div id="notification" class="p-4 rounded px-4 py-3 absolute <?php echo ($insert_msg || $_SESSION['insert_msg']) ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 <?php echo $alert_div_color; ?> " role="alert">
        <strong class="font-bold"><?php echo $alert_msg; ?>! &nbsp;</strong>
        <span class="block sm:inline mr-12"><?php echo  $insert_msg ? $insert_msg : $_SESSION['insert_msg']; ?></span>
        <span onclick="closeNFT(this); <?php $_SESSION['insert_msg'] = null; ?>" class="absolute top-0 bottom-0 right-0 px-3 py-3 <?php echo $alert_btn_color; ?> cursor-pointer">
            <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
        </span>
    </div>
<?php
}
?>
<div class="absolute hidden inset-0 bg-gray-600 bg-opacity-60 overflow-y-auto h-full w-full z-20" id="my-modal"></div>

<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="text-lg  border-b h-6 relative bg-teal-600"></div>
    <div class="bg-white shadow relative h-32 flex justify-between items-center px-10">
        <?php
        //PIE CHARTS
        $sql = "SELECT * FROM students WHERE student_id = $sender_id";

        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {

            $name = ($sender_id == $student_id) ? "Me" : $row['lastname'] . ' ' . $row['firstname'];
            $profile = $row['profile'];;
            $level = $row['level'];
            $date = date("Y") - $row['registration_year'];
        ?>
            <div class=" bg-white p-2 flex items-center gap-4 border-l-4 border-teal-600">
                <div class="h-28 w-28 rounded-full overflow-hidden ">
                    <img src="../../images/<?php echo $profile; ?>" class="h-full w-full">
                </div>
                <div class=" ">
                    <h2 class="text-lg font-bold text-teal-600"><?php echo $name; ?></h2>
                    <h1 class="text-sm text-gray-400"><?php echo $level; ?></h1>
                    <h1 class="text-sm text-gray-400"><?php echo $date; ?> year</h1>

                </div>
            </div>
        <?php
        }
        ?>
        <div class="relative">
            <i class="fa fa-comments text-teal-600 text-3xl transition duration-150 ease-in-out" aria-hidden="true"></i>
            <span class='bg-red-500 p-1 text-white  absolute -top-2 -right-2 text-xs rounded-full h-7 w-7 border-2 border-white'>12</span>
        </div>

    </div>

    <div class="mt-4 flex flex-row-reverse">

        <div class="w-[26rem] shadow-lg bg-white  ml-4">
            <div class="py-4 bg-teal-700 text-white text-center rounded-t font-bold uppercase text-sm">
                <h1>My contact list</h1>
            </div>
            <div>
                <div class="uppercase text-center text-teal-800 text-xs my-2">all</div>
                <?php
                $sql = "SELECT * FROM peer_chat
                        LEFT JOIN students ON peer_chat.incoming_id=students.student_id
                        WHERE incoming_id != $student_id AND outgoing_id = $student_id
                        GROUP BY incoming_id
                        ";

                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $peer_chat_id = $row['peer_chat_id'];
                    $student_name = $row['firstname'] . ' ' . $row['lastname'];
                    $incomig_id = $row['incoming_id'];
                    echo
                    "
                    <a href='./peerChat.php?sender_id=$incomig_id'>
                        <div class='p-2 rounded my-2 flex items-center justify-between hover:shadow transition-all duration-300 border hover:cursor-pointer'>
                            <div class='text-gray-600 text-sm'>$student_name</div>
                            <div class='bg-sky-400 rounded-full w-2 h-2'></div>
                        </div>
                    </a>
                    ";
                }
                ?>
            </div>
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class="w-full rounded shadow-lg bg-white px-10 py-2">
            <span class="flex justify-center text-xs font-bold py-1 text-teal-700 uppercase">All Chat</span>
            <div id="mainSection" class="banner h-[30rem] overflow-y-scroll scrollbar-hide p-16">
                <?php
                // //Display data into the table 
                // $sql  = "SELECT chat_room.chat_room_id,chat_room.message, students.student_id, students.lastname, students.firstname  
                // FROM chat_room 
                // INNER JOIN students ON students.student_id=chat_room.student_id
                // WHERE chat_room.study_group_id = '$study_group_id'";
                // $result = mysqli_query($link, $sql);
                // $resultCheck = mysqli_num_rows($result);
                // #continue in the table itself

                // if ($resultCheck > 0) {
                //     while ($row = mysqli_fetch_assoc($result)) {
                //         $name = $row['lastname'] . ' ' . $row['firstname'];
                //         $message = $row['message'];
                //         $message_student_id = $row['student_id'];

                //         if ($message_student_id == $student_id) {
                //             $css_side = "bg-teal-50 pl-10 pr-4 rounded-l-2xl";
                //             $css_side_flex = "justify-end";
                //         } else {
                //             $css_side = "bg-teal-100 pr-10 pl-4 rounded-r-2xl";
                //             $css_side_flex = "justify-start";
                //         }
                //         if ($mentor_name == $name) {
                //             $fullname = $name . '. ' . '<span class="text-[8px] text-red-500">Mentor</span>';
                //         } else {
                //             $fullname = $name;
                //         }
                //         echo
                //         "
                //         <div class='send mt-2 flex $css_side_flex'>
                //             <div class='$css_side py-1 border border-teal-300 rounded-t-2xl'>
                //                 <span class='text-teal-800 text-sm font-bold '>$fullname</span>
                //                 <div>
                //                     <p class='text-teal-600 text-sm float-right'>$message</p>
                //                 </div>
                //             </div>
                //         </div>
                //         ";
                //     }
                //     mysqli_free_result($result);
                // } else {
                //     echo
                //     "
                //     <div class='flex justify-center border border-teal-400 mt-10 rounded-xl bg-teal-50 font-bold p-5 text-teal-700 '>You have staterd a chat here.</div>
                //     ";
                // }
                ?>
            </div>
            <div class="down">
                <form action="" id="typingArea" class="mt-2 border-t-2 border-gray-100 flex justify-center py-2">
                    <input type="text" name="student_sendMessage_id" id="outgoing" autocomplete="off" value="<?php echo $student_id; ?>" />
                    <input type="text" name="group_sendMessage_id" id="incoming" autocomplete="off" value="<?php echo $sender_id ?>" />
                    <!-- <input type="text" name="message_write" id="typingField" class="p-2 cursor-default border border-teal-400 rounded-lg w-full px-5 text-gray-500 text-base font-bold outline-none active:shadow" required autocomplete="off"> -->
                    <textarea name="message_write" id="typingField" class="h-20 max-h-40 p-2 cursor-default border border-teal-400 rounded-lg w-full px-5 text-gray-500 text-base font-bold outline-none active:shadow resize-none" required autocomplete="off"></textarea>
                    <button type="submit" id="sendMessage" name='send' value="send" class='ml-2 px-5 py-2 cursor-pointer flex items-center border border-teal-500 bg-teal-50 rounded-lg  hover:bg-teal-100 text-teal-500 font-medium'>
                        Send<i class="fa fa-paper-plane px-2" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="./asset/js/peerChat.js"></script>
<?php
include './asset/Footer.php'
?>