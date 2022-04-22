<?php
include("../../php/config.php");
include('./asset/Header.php');

$student_id = $_SESSION['student_id'];
// <!-- NOTIFICATION ALERTS -->
$insert_msg = "";

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
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            People
        </h2>
        <span class="openModalBtn">
            <i class="fa fa-users text-teal-600 hover:text-teal-700 text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full flex justify-between">
        <div name="new_resources">
            <button type='button' onclick="window.print()" name='print' value='upload' class='flex items-center px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>Print report</button>
        </div>
        <div name="">
            <a href="peerChat.php" name='print' value='upload' class='flex items-center px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>Messages</a>
        </div>
    </div>
    <div class="table mt-4">
        <div class="search flex justify-end">
            <form action="" method="GET" class="w-96 my-2 ">
                <div class="flex items-center">
                    <label for="" class="block text-teal-700 text-sm px-2"> Search </label>
                    <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                                                                echo $_GET['search'];
                                                            } ?>" placeholder="Search people's interests" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded ">

                    <button class="submit" style="display: none;" class=" px-2 bg-teal-50 text-teal-800 border-teal-400">Search</button>
                </div>
            </form>
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class="print_container max-w-full rounded pb-10">
            <div class="text-teal-600 text-sm font-bold uppercase flex justify-center hover:underline">
                <a href="./people.php">Display all students</a>
            </div>
            <div class="pt-5 grid grid-cols-3 gap-2">
                <?php
                if (isset($_GET['search'])) {
                    $filtervalues = $_GET['search'];
                    $sql = "SELECT * FROM interest
                        INNER JOIN students ON interest.student_id=students.student_id
                        WHERE CONCAT(interest_details, level, interest_topics, firstname, lastname) LIKE '%$filtervalues%' AND students.student_id != $student_id";
                    $search_result = filterTable($link, $sql);
                } else {
                    //Display data into the table
                    $sql  = "SELECT * FROM interest
                        INNER JOIN students ON interest.student_id=students.student_id
                        WHERE students.student_id != $student_id
                        ";
                    $search_result = filterTable($link, $sql);
                }
                function filterTable($link, $sql)
                {
                    $result = mysqli_query($link, $sql);
                    return $result;
                }
                #Check if the profile is already there

                if (mysqli_num_rows($search_result) > 0) {
                    while ($row = mysqli_fetch_assoc($search_result)) {
                        $interest_id = $row['interest_id'];
                        $profile = $row['profile'];
                        $name = $row['lastname'] . ' ' . $row['firstname'];
                        $sender_id = $row['student_id'];
                        $email = $row['email'];
                        $phone = $row['phone_number'];
                        $details = $row['interest_details'];
                        $topics = $row['interest_topics'];
                        $topics_1 = explode(",", $topics);
                        $level = $row['level'];
                        $date = date("Y") - $row['registration_year'];
                ?>
                        <div id="box-container" class=" relative bg-white card border-2 border-gray-100 rounded-xl  hover:shadow-lg cursor-default transition-all duration-300">
                            <div class="banner relative h-24 border-b">
                                <div class="absolute bottom-4 pl-[8rem] px-4 py-2 text-gray-600 uppercase  w-full flex justify-evenly font-bold">
                                    <h1><?php echo $name; ?></h1>
                                    <span class="text-teal-400"> - </span>
                                    <h1><?php echo $date; ?> year</h1>
                                    <!-- <a href="./peerMessage.php" class="relative text-<?php echo $primary_color; ?>-600 hover:text-<?php echo $primary_color; ?>-700">
                                        <i class="fa fa-comments text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
                                        <div class="absolute top-0 -right-2 grid place-items-center bg-red-50 shadow-md h-5 w-5 rounded-full font-bold text-xs">
                                            <?php
                                            // $sql = "SELECT COUNT(*) AS tot_number FROM students";
                                            // $result = mysqli_query($link, $sql);

                                            // if ($row = mysqli_fetch_assoc($result)) {
                                            //     echo "<span>" . $row['tot_number'] . "</span>";
                                            // }
                                            // mysqli_free_result($result);
                                            ?>

                                        </div>
                                    </a> -->
                                </div>
                                <div class="profile absolute -bottom-10 left-6 transform ">
                                    <img src="../../images/<?php echo $profile; ?>" class="bg-white profile w-24 h-24 rounded-full outline outline-gray-200 border-2 border-white">
                                </div>
                            </div>
                            <div class="down p-2 mt-2 px-10 bg-white">
                                <div class="down_content ">
                                    <p class="uppercase  text-center text-gray-500 text-sm mb-2 pl-[7rem]">
                                        <span><?php echo $level; ?> .</span>
                                        <span class="lowercase italic text-base"><?php echo $email; ?></span><br />
                                        <span class="tracking-widest"><?php echo $phone; ?></span>
                                    </p>

                                    <p class="text-center text-gray-700 text-base">
                                        <?php echo $details; ?>
                                    </p>
                                    <div class="pl-10 ">
                                        <ul class="list-disc list-inside grid grid-cols-3 gap-2 pt-3">
                                            <?php
                                            foreach ($topics_1 as $item) {
                                                echo
                                                "
                                                        <li class='text-teal-500'>
                                                            <span class='text-gray-700'>$item</span>
                                                        </li>
                                                        ";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <a href="peerChat.php?sender_id=<?php echo $sender_id; ?>" id="clip_path" class="absolute bottom-0 right-0 bg-teal-500 text-white w-14 h-14 rounded-full border-4 border-white shadow-md cursor-pointer p-2 flex items-center justify-center">
                                <i class="fa fa-comments text-xl transition duration-150 ease-in-out" aria-hidden="true"></i>
                            </a>
                        </div>
                <?php
                    }
                } else {
                    echo
                    "
                        <div class='flex items-center cursor-default justify-center px-4 py-2 border border-teal-500 bg-teal-50 rounded text-teal-500 font-medium'>
                            No profile Yet
                        </div>
                        ";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<!-- ================================CHANGE FROM APPROVED, DENIED ETC  WITH A MODAL====================================== -->

<div id="confirm-delete-modal" class="hidden fixed z-20 inset-0 overflow-y-auto " aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div id="confirm-delete-modal-close" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <!-- <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span> -->

        <div class="inline-block relative align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-text-50">

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 ">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 bg-teal-100  sm:h-10 sm:w-10">
                            <!-- Heroicon name: outline/exclamation -->
                            <svg class="h-6 w-6 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div id="modalSTATUS">
                            <input id="updateSTATUS" type="hidden" name="updateSTATUS_id">
                            <!-- <input id="updateSTATUS_TEXT" type="hidden" name="updateSTATUS_id">  -->
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">

                            <h3 class="text-lg leading-6 font-medium text-teal-900" id="modal-title">Change resources status</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to do this? this will change the resource status, which is your action now.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" name="approved_status" value="approved" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-5 py-2 bg-teal-500 text-base font-medium text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-20 sm:text-sm cursor-pointer">
                        Approved
                    </button>
                    <button type="submit" name="denied_status" value="denied" class="mt-3 w-full inline-flex justify-center rounded-md border border-teal-300 shadow-sm px-5 py-2 bg-teal-50 text-base font-medium text-teal-600 hover:bg-teal-100 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-20 sm:text-sm cursor-pointer">
                        Denied
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include './asset/Footer.php'
?>