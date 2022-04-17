<?php
    include("../../php/config.php");
    include ('./asset/Header.php');

// <!-- NOTIFICATION ALERTS -->
$insert_msg = "";
$student_id = $_SESSION['student_id'];
if (isset($_GET["joinedGroup"])) {
    $study_group_id = $_GET["joinedGroup"];
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
    <div id="notification" class="p-4 rounded px-4 py-3 absolute <?php echo ($insert_msg || $_SESSION['insert_msg']) ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 <?php echo $alert_div_color;?> " role="alert">
        <strong class="font-bold"><?php echo $alert_msg; ?>! &nbsp;</strong>
        <span class="block sm:inline mr-12"><?php echo  $insert_msg ? $insert_msg : $_SESSION['insert_msg'] ; ?></span>
        <span onclick="closeNFT(this); <?php $_SESSION['insert_msg'] = null; ?>" class="absolute top-0 bottom-0 right-0 px-3 py-3 <?php echo $alert_btn_color;?> cursor-pointer">
            <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
        </span>
    </div>
<?php     
    }
?>
<div
	class="absolute hidden inset-0 bg-gray-600 bg-opacity-60 overflow-y-auto h-full w-full z-20"
	id="my-modal"
></div>
<?php
    $sql = "SELECT join_study_group.join_study_group_id, join_study_group.study_group_id, join_study_group.student_id, study_group.group_name, study_group.group_description, study_group.created_on, study_group.banner_image,study_group.mentor_id, students.firstname, students.lastname
    FROM join_study_group
    INNER JOIN study_group ON join_study_group.study_group_id=study_group.study_group_id
    INNER JOIN mentor ON study_group.mentor_id=mentor.mentor_id
    INNER JOIN mentor_application ON mentor.application_id=mentor_application.application_id
    INNER JOIN students ON mentor_application.student_id=students.student_id
    WHERE join_study_group.study_group_id = $study_group_id";

    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $group_id = $row['study_group_id'];
        $group_name = $row['group_name'];
        $group_description = $row['group_description'];
        $group_creation = $row['created_on'];
        $group_banner = $row['banner_image'];
        $mentor_name = $row['firstname'].' '.$row['lastname'];
    }                    
?>
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="text-lg  border-b h-20 relative bg-black">
        <img src="../../resources/<?php echo $group_banner;?>" class="w-full h-full object-cover opacity-70" alt="">
        <div class="absolute inset-0 flex flex-col md:flex-row items-center">
            <div class="flex-1 flex">
                <h2 class="bg-gray-50 px-2 py-1 my-2 md:my-6 font-semibold text-gray-700">
                    Group Name: <span class="text-gray-500"><?php echo $group_name;?></span>
                </h2>
            </div>
            
            <div>
                <h2 class="bg-gray-50 px-2 py-1 my-2 md:my-6 font-semibold text-gray-700 flex-1">
                    Mentor: <span class="text-gray-500"><?php echo $mentor_name;?></span>
                </h2>
            </div>
        </div>
        
    </div>
    <div class="bg-white shadow">
        <div class="w-[calc(100vw-20rem)] xl:w-[1000px] p-2 flex gap-4 mx-auto overflow-x-scroll scrollbar-hide justify-center">
            <div class="w-full md:w-1/2 shadow-md p-4 rounded text-gray-700">
                    <p><?php echo $group_description;?></p>
            </div>
            <?php
                $sql = "SELECT * FROM students WHERE student_id = $student_id";
                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $levell = $row['level'];
                }
                if ($levell === "standard") {
                    echo 
                    "
                    <div class='flex items-center'>
                        <a href='student_action.php?leaveGroup=$group_id && leaveStudent=$student_id' class='my-2 px-4 py-1 border border-red-500 bg-red-50 rounded-md  hover:bg-red-100 text-red-500 font-medium'>Leave this group</a>
                    </div>
                    ";
                }else {
                    echo 
                    " ";
                }
            ?>
            
                     
        </div>
    </div>
    
    <div class="mt-4 flex flex-row-reverse">
        
        <div class="w-[20rem] shadow-lg bg-white  ml-4">
            <div class="py-4 bg-teal-700 text-white text-center rounded-t font-bold uppercase text-sm">
                <h1>All the students</h1>
            </div>
            <div>
                <div class="uppercase text-center text-teal-800 text-xs my-2">all</div>
                <?php
                    $sql = "SELECT join_study_group.join_study_group_id, students.firstname, students.lastname
                    FROM join_study_group
                    INNER JOIN students ON join_study_group.student_id=students.student_id
                    WHERE join_study_group.study_group_id = $study_group_id";
                
                    $result = mysqli_query($link, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $group_id = $row['join_study_group_id'];
                        $student_name = $row['firstname'].' '.$row['lastname'];
                        echo
                        "
                            <div class='p-2 rounded my-2 flex items-center justify-between hover:shadow transition-all duration-300 border hover:cursor-pointer'>
                                <div class='text-gray-600 text-sm'>$student_name</div>
                                <div class='bg-sky-600 rounded-full w-2 h-2'></div>
                            </div>
                        ";
                        
                    } 
                ?>
            </div>
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class="w-full rounded shadow-lg bg-white px-10 py-2">
            <span class="flex justify-center text-xs font-bold py-1 text-teal-700 uppercase">All Chat</span>
            <div class="banner h-96 overflow-y-scroll scrollbar-hide">
            <?php
                //Display data into the table 
                $sql  = "SELECT chat_room.chat_room_id,chat_room.message, students.student_id, students.lastname, students.firstname  
                FROM chat_room 
                INNER JOIN students ON students.student_id=chat_room.student_id
                WHERE chat_room.join_study_group_id = '$study_group_id'";
                $result = mysqli_query($link, $sql);
                $resultCheck = mysqli_num_rows($result);
                #continue in the table itself
                
                if ($resultCheck > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $name = $row['lastname'].' '.$row['firstname'];
                        $message = $row['message'];
                        $message_student_id = $row['student_id'];

                        if($message_student_id == $student_id){
                            $css_side = "bg-teal-50 pl-10 pr-4 rounded-l-2xl";
                            $css_side_flex = "justify-end";
                        }else{
                            $css_side = "bg-teal-100 pr-10 pl-4 rounded-r-2xl";
                            $css_side_flex = "justify-start";
                        }
                        echo
                        "
                        <div class='send mt-2 flex $css_side_flex'>
                            <div class='$css_side py-1 border border-teal-300 rounded-t-2xl'>
                                <span class='text-teal-800 text-sm font-bold '>$name</span>
                                <div>
                                    <p class='text-teal-600 text-sm float-right'>$message</p>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                    mysqli_free_result($result);
                }else{
                    echo
                    "
                    <div class='flex justify-center border border-teal-400 mt-10 rounded-xl bg-teal-50 font-bold p-5 text-teal-700 '>You have staterd a chat here.</div>
                    ";
                }
            ?>    
            </div>
            <div class="down mt-10"> 
                <form action="sendMessage.php" method="POST" class="mt-2 border-t-2 border-gray-100 flex justify-center py-2">
                    <input type="hidden" name="sendMessage_id" value="<?php echo $student_id ?>" />
                    <input type="hidden" name="groupMessage_id" value="<?php echo $study_group_id ?>" />
                    <input type="text" name="message_write" class="p-2 border border-teal-400 rounded-lg w-full px-5 text-gray-500 text-base font-bold outline-none active:shadow" required autocomplete="off">
                    
                    <button type="submit" name='sendMessage_btn' class='ml-2 px-5 py-2 flex items-center border border-teal-500 bg-teal-50 rounded-lg  hover:bg-teal-100 text-teal-500 font-medium'>
                        Send<i class="fa fa-paper-plane px-2" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    include './asset/Footer.php'
?>