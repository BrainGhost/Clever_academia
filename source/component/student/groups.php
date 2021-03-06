<?php
include("../../php/config.php");
include('./asset/Header.php');

// <!-- NOTIFICATION ALERTS -->
$insert_msg = "";
$student_id = $_SESSION['student_id'];

if ($_SESSION['insert_msg'] !== "") {
    $action = "";
    $_SESSION['alert_notification_resources'] = "";
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
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Study Groups
        </h2>
        <span class="openModalBtn">
            <i class="fa fa-object-group text-teal-600 hover:text-teal-700 text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="bg-white border-b">
        <div class="w-full md:w-[calc(100vw-20rem)] xl:w-[1000px] p-2 flex gap-4 mx-auto overflow-x-scroll scrollbar-hide">
            <?php
            //PIE CHARTS
            $sql = "SELECT join_study_group.join_study_group_id,join_study_group.study_group_id,study_group.group_name, study_group.banner_image, students.student_id
                    FROM join_study_group
                    INNER JOIN study_group ON join_study_group.study_group_id=study_group.study_group_id
                    INNER JOIN students ON join_study_group.student_id=students.student_id
                    WHERE students.student_id = $student_id
                    ";

            $result = mysqli_query($link, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['group_name'];
                // $topic = $row['topics'];
                $profile = $row['banner_image'];
            ?>
                <div class="w-32 p-2">
                    <a id='count_notification' href="single_group.php?joinedGroup=<?php echo $row['study_group_id']; ?>" class="relative w-28 h-28 text-center cursor-pointer">
                        <div class="relative bg-gradient-to-r from-teal-500 via-gray-500 to-red-500 p-1 w-24 h-24  rounded-full mb-2 mx-auto">
                            <img src="../../resources/<?php echo $profile; ?>" class="rounded-full shadow-lg p-1 bg-white opacity-100 hover:opacity-90 w-full h-full object-contain transition duration-300 ease-in-out" alt="Avatar" />
                            <div id="badge_notification" class="bg-red-500 p-2 text-white  absolute bottom-0 right-0 rounded-full h-8 w-8 border-2 border-white flex items-center justify-center">
                                <!-- <span>11</span> -->
                                <input id="groupID" name="groupID" class="hidden bg-teal-600" value="<?php echo $row['study_group_id'] ?>" hidden>
                            </div>
                            <!-- <?php
                                    // $sql = "SELECT COUNT(*) AS tot_number FROM chat_room WHERE student_id != $student_id && chat_status = 0";
                                    // $result = mysqli_query($link, $sql);

                                    // if ($row = mysqli_fetch_assoc($result)) {
                                    //     echo "<span class='bg-red-500 p-2 text-white  absolute bottom-0 right-0 rounded-full h-10 w-10 border-2 border-white'>" . $row['tot_number'] . "</span>";
                                    // }
                                    ?> -->
                        </div>
                        <div>
                            <h5 class="text-xs text-gray-500 font-medium leading-tight mb-2"><?php echo $name; ?></h5>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>

        </div>
    </div>

    <div class="table mt-4">
        <div class="search flex justify-center">
            <div class=" w-96 my-2">
                <div class="flex items-center justify-center">
                    <label for="" class="block text-teal-700 text-sm px-2"> All groups Here. </label>
                </div>
            </div>
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded bg-white px-10">
            <div class="display_card p-2 grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 auto-rows-auto">
                <?php
                $sql = "SELECT study_group.study_group_id, study_group.group_name, study_group.group_description, study_group.created_on, study_group.banner_image,study_group.mentor_id, students.firstname, students.lastname, students.profile
                    FROM study_group
                    INNER JOIN mentor ON study_group.mentor_id=mentor.mentor_id
                    INNER JOIN mentor_application ON mentor.application_id=mentor_application.application_id
                    INNER JOIN students ON mentor_application.student_id=students.student_id
                    WHERE mentor_application.student_id != $student_id ORDER BY study_group_id DESC";

                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $group_id = $row['study_group_id'];
                    $group_name = $row['group_name'];
                    $group_description = $row['group_description'];
                    $group_creation = $row['created_on'];
                    $group_author = $row['firstname'] . ' ' . $row['lastname'];
                    $group_banner = $row['banner_image'];
                    $group_author_profile = $row['profile'];

                ?>
                    <div class="card max-w-7xl border-2 border-gray-100 rounded-xl overflow-hidden hover:shadow-lg cursor-default transition-all duration-300">
                        <div class="banner relative h-40 border-b">
                            <img src="../../resources/<?php echo $group_banner; ?>" class="background h-full w-full object-contain">
                            <div class="profile absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                                <img src="../../images/<?php echo $group_author_profile; ?>" class="profile w-24 h-24 rounded-full bg-white outline outline-white">
                            </div>
                        </div>
                        <div class="down p-2 mt-10">
                            <div class="down_content">
                                <p class="uppercase text-center text-gray-500 text-xs mb-2">
                                    <span><?php echo $group_author; ?> .</span>
                                    <span><?php echo $group_name; ?></span><br />
                                    <span><?php echo $group_creation; ?></span>
                                </p>

                                <p class="text-center text-gray-700 text-sm">
                                    <?php echo $group_description; ?>
                                </p>
                                <div class="mt-2 border-t-2 border-gray-100 flex justify-center">
                                    <a href='student_action.php?joinedGroup_all=<?php echo $group_id; ?> && joinedStudent_all=<?php echo $student_id; ?>' class='my-2 px-5 py-1 border border-teal-500 bg-teal-50 rounded-full  hover:bg-teal-100 text-teal-500 font-medium'>Join group</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        setInterval(function() {
            let groupID = $("#groupID").val();
            $.post('./viewNotifcation.php', {
                data: 'get',
                groupID: groupID
            }, function(data) {
                $("#badge_notification").html(data);
            })
            // $.ajax({
            // type: "post",
            // url: "./viewNotification.php",
            // data: { incomingid: incomingid },
            // success: function (response) {
            //     $("#badge_notification").html(response);
            // },
            // });
        }, 1000);
        $('#count_notification').on('click', function() {
            $.post('./viewNotifcation.php', {
                update: 'update'
            }, function(data) {

            })
        });
        // $('#count_notification').on('click', function name(params) {
        //     console.log('sucsess clicked');
        //     $.ajax({
        //         url: 'updateNotification.php',
        //         success: function(response) {}
        //     })
        // });
        // // setInterval(function() {
        // //     let incomingid = $("#incoming").val();
        // //     $.ajax({
        // //     type: "post",
        // //     url: "./viewNotification.php",
        // //     data: { incomingid: incomingid },
        // //     success: function (response) {
        // //         $("#badge_notification").html(response);
        // //     },
        // //     });
        // // }, 500);

    });
</script>
<?php
include './asset/Footer.php'
?>