<?php
include '../../php/config.php';
include './asset/Header.php';
?>

<?php
#############################################
// change the timezone from berlin to kenya/nairobi
date_default_timezone_set("Africa/Nairobi");

// define variable and initialixze them with an empty string
$doctor_id = $doctor_schedule_date = $doctor_schedule_day = $doctor_schedule_start_time = $doctor_schedule_end_time = $average_consulting_time = "";
$doctor_schedule_date_err = $doctor_schedule_start_time_err = $doctor_schedule_end_time_err = $average_consulting_time_err = $insert_msg = $alert_notification = $status_insert = "";

$student_id = $_SESSION["student_id"];

// INSERT FUNCTIONALITY
if (isset($_POST["add"])) {
    #check for validation
    if (empty($_POST['doctor_schedule_date'])) {
        $doctor_schedule_date_err = "Date can not be empty";
    } elseif (trim($_POST['doctor_schedule_date']) < date('Y-m-d')) {
        # check if the date inserted is > to the current data
        $doctor_schedule_date_err = "Invalid date, try the day ahead of the current one.";
    } else {
        $doctor_schedule_date = date("Y-m-d", strtotime(trim($_POST['doctor_schedule_date'])));
        $doctor_schedule_day = date("l", strtotime(trim($_POST['doctor_schedule_date'])));
    }

    if (empty($_POST['doctor_schedule_start_time'])) {
        $doctor_schedule_start_time_err = "Start time can not be empty";
    } elseif (trim($_POST['doctor_schedule_date']) == date('Y-m-d') && trim($_POST['doctor_schedule_start_time']) < date("H:i A")) {
        # check if the time inserted is > to the current data
        $doctor_schedule_start_time_err = "Invalid time, try the time ahead of the current one.";
    } else {
        $doctor_schedule_start_time = trim($_POST['doctor_schedule_start_time']);
    }

    if (empty($_POST['doctor_schedule_end_time'])) {
        $doctor_schedule_end_time_err = "End time can not be empty";
    } elseif (trim($_POST['doctor_schedule_date']) == date('Y-m-d') && trim($_POST['doctor_schedule_end_time']) < date("H:i A")) {
        # check if the time inserted is > to the current data
        $doctor_schedule_end_time_err = "Invalid time, try the time ahead of the current one.";
    } else {
        $doctor_schedule_end_time = trim($_POST['doctor_schedule_end_time']);
    }
    // date("H:i A")
    if (empty($_POST['average_consulting_time'])) {
        $average_consulting_time_err = "Average consulting can not be empty";
    } else {
        $average_consulting_time = trim($_POST['average_consulting_time']);
    }



    #insert data into the database if all the errors are cleared
    if (empty($doctor_id_err) && empty($doctor_schedule_date_err) && empty($doctor_schedule_start_time_err) && empty($doctor_schedule_end_time_err) && empty($average_consulting_time_err)) {
        # insert the data if all errors are lifted
        $sql = "INSERT INTO doctor_schedule(doctor_schedule_date, doctor_schedule_day, doctor_schedule_start_time, doctor_schedule_end_time, average_consulting_time, doctor_id) VALUES ('$doctor_schedule_date' , '$doctor_schedule_day', '$doctor_schedule_start_time' ,'$doctor_schedule_end_time' ,$average_consulting_time ,$doctor_id )";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $insert_msg = "Record inserted successfully.";
            $alert_notification = "success";
        } else {
            echo "ERROR";
        }
    }
}

?>
<!--Overlay Effect-->
<div class="absolute hidden inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-20" id="my-modal"></div>

<!-- NOTIFICATION ALERTS -->
<?php
// if ( isset($_GET['success']) && $_GET['success'] == 1 )
// {
//     echo 
//     "
//     <div class='bg-sky-100 text-sky-700 border border-sky-900 my-3 rounded w-96 mx-auto flex items-center'>
//         <h1 class='text-sky-700 text-sm py-4'>updated well</h1>
//         <span id='close-nft' class='absolute top-0 bottom-0 right-0 px-3 py-3 bg-sky-200 text-sky-700 cursor-pointer'>
//             <i class='fa fa-times text-xl pointer-events-none' ></i>
//         </span>
//     </div>
//     ";
// }
/* <?php echo ($alert_notification == 'success' ) ? 'Success' : 'Update' ;?> -> alert_msg*/
/* <?php echo ($alert_notification == 'success' ) ? 'Success' : 'Update' ;?> -> alert_div_color*/
/* <?php echo ($alert_notification == 'success' ) ? 'Success' : 'Update' ;?> -> alert_btn_color */
// $_SESSION["insert_msg"] = "junior";
// if ($_SESSION["insert_msg"] = "junior") {
//     $_SESSION["insert_msg"] = null;
// } 


if ($_SESSION['insert_msg'] !== "") {
    $action = "";
    if (isset($_POST['delete'])) {
        $action = "delete";
    } elseif (isset($_POST['update'])) {
        $action = "update";
    } elseif (isset($_POST['add'])) {
        $action = "success";
    }

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

<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Appointment schedule
        </h2>

    </div>
    <div class="mt-2">
        <div class="search flex justify-end">
            <form action="" method="GET" class=" w-96 mt-8 my-2">
                <div class="flex items-center">
                    <label for="" class="block text-<?php echo $primary_color; ?>-700 text-sm px-2"> Search </label>
                    <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                                                                echo $_GET['search'];
                                                            } ?>" placeholder="Search appoitments" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded ">
                </div>
            </form>
        </div>
        <div id='recipients' class="overflow-hidden rounded bg-white">
            <table id="example" class="min-w-full" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead class="bg-teal-600 border-b">
                    <tr class="text-sm font-medium text-white text-left">
                        <th data-priority="1">Schedule date</th>
                        <th data-priority="2">Schedule day</th>
                        <th data-priority="3">Start time</th>
                        <th data-priority="4">End time</th>
                        <th data-priority="5">Consulting time</th>
                        <th data-priority="4">Doctor name</th>
                        <th data-priority="6">Status</th>
                        <th data-priority="7">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['search'])) {
                        $filtervalues = $_GET['search'];

                        //Display data into the table
                        $sql  = "SELECT doctor_schedule_id, doctor_schedule_date, 
                        (SELECT DAYNAME(doctor_schedule_date)) AS doctor_schedule_day, 
                        (SELECT TIME_FORMAT(doctor_schedule_start_time, ' %H:%i %p ')) AS doctor_schedule_start_time, 
                        (SELECT DAYNAME(doctor_schedule_date)) AS doctor_schedule_day, 
                        (SELECT TIME_FORMAT(doctor_schedule_end_time, ' %H:%i %p ')) AS doctor_schedule_end_time, 
                        average_consulting_time, schedule_status, doctors.fullname, booked_status 
                        FROM doctor_schedule
                        INNER JOIN doctors ON doctor_schedule.doctor_id = doctors.doctor_id
                        WHERE CONCAT(doctor_schedule_date, doctor_schedule_day, doctor_schedule_start_time, doctor_schedule_end_time,average_consulting_time, fullname) LIKE '%$filtervalues%'  ORDER BY doctor_schedule_id ASC;";

                        $search_result = filterTable($link, $sql);
                    } else {
                        //Display data into the table
                        $sql  = "SELECT doctor_schedule_id, doctor_schedule_date, doctor_schedule.doctor_id,
                        (SELECT DAYNAME(doctor_schedule_date)) AS doctor_schedule_day, 
                        (SELECT TIME_FORMAT(doctor_schedule_start_time, ' %H:%i %p ')) AS doctor_schedule_start_time, 
                        (SELECT DAYNAME(doctor_schedule_date)) AS doctor_schedule_day, 
                        (SELECT TIME_FORMAT(doctor_schedule_end_time, ' %H:%i %p ')) AS doctor_schedule_end_time, 
                        average_consulting_time, schedule_status, doctors.fullname, booked_status 
                        FROM doctor_schedule
                        INNER JOIN doctors ON doctor_schedule.doctor_id = doctors.doctor_id
                        ;";

                        $search_result = filterTable($link, $sql);
                    }

                    #continue in the table itself
                    function filterTable($link, $sql)
                    {
                        $result = mysqli_query($link, $sql);
                        return $result;
                    }
                    if (mysqli_num_rows($search_result) > 0) {
                        while ($row = mysqli_fetch_assoc($search_result)) {

                            if ($row['schedule_status'] == "1") {
                                $status_insert = "<span class='text-sky-400 italic font-medium'>Active</span>";
                            } elseif ($row['schedule_status'] == "0") {
                                $status_insert = "<span class='text-red-400 italic font-medium'>Inactive</span>";
                            }
                            if ($row['schedule_status'] == "1") {
                                if ($row['booked_status'] == 1) {
                                    $status_book = "<a href='javascript:displayModal_inactive(" . $row['doctor_schedule_id'] . ", " . $row['doctor_id'] . ");' type='button' name='change_status' value='Active' class='px-4 py-1 border border-sky-500 bg-sky-50 rounded  hover:bg-sky-100 text-sky-500 font-medium'>Book this</a>";
                                } else {
                                    $status_book = "<button type='button' class='px-4 py-1 border border-red-300 bg-red-50 rounded text-red-300 font-medium cursor-not-allowed'>Already booked</button>";
                                }
                            } else {
                                $status_book = "<button type='button' class='px-4 py-1 border border-gray-300 bg-gray-50 hover:bg-gray-100 rounded text-gray-400 font-medium'>Wait activation</button>";
                            }

                            echo
                            "
                                <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light'>
                                    <td>" . $row['doctor_schedule_date'] . "</td>
                                    <td>" . $row['doctor_schedule_day'] . "</td>
                                    <td>" . $row['doctor_schedule_start_time'] . "</td>
                                    <td>" . $row['doctor_schedule_end_time'] . "</td>
                                    <td>" . $row['average_consulting_time'] . " Minutes</td>
                                    <td>" . $row['fullname'] . "</td>
                                    <td>$status_insert</td>
                                    <td>
                                        <div class='flex items-center'>$status_book</div>
                                    </td>
                                </tr>
                                ";
                        }
                    } else {
                        echo
                        "
                            <tr class='bg-teal-50 border border-teal-100 border-t-0 text-sm text-teal-900 font-semibold text-center'>
                                <td colspan='8'>
                                    No records were found.
                                </td>
                            </tr>
                            ";
                    }

                    ?>

                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- ================================CHANGE FROM ACTIVE TO INACTIVE WITH A MODAL====================================== -->
<!-- CONFIRMATION INACTIVE -> ACTIVE ACCOUNT-->
<?php

#close connection
mysqli_close($link);
?>
<div id="confirm-delete-modal" class="hidden fixed z-20 inset-0 overflow-y-auto " aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div id="confirm-delete-modal-close" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <!-- <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span> -->

        <div class="inline-block relative align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-text-50">

            <form method="POST" action="./student_action.php">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 ">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 bg-sky-100  sm:h-10 sm:w-10">
                            <!-- Heroicon name: outline/exclamation -->
                            <svg class="h-6 w-6 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div id="modalSTATUS">
                            <input id="updateSTATUS" type="text" name="schedule_appointment_id" text>
                            <input id="updateSTATUS_TEXT" type="text" name="schedule_appointment_doctor" text>
                            <input id="student_id_confirm" type="text" value="<?php echo $student_id; ?>" name="student_id" hidden>

                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">

                            <h3 class="text-lg leading-6 font-medium text-sky-700" id="modal-title">Cofirm booking</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Confirm you booking,you will receive a message of confirmation. Check you mail after this action</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" name="confirm_booking" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-5 py-2 bg-sky-500 text-base font-medium text-white hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">Confirm</button>
                    <a href="./counselling.php" class="mt-3 w-full inline-flex justify-center rounded-md border border-sky-300 shadow-sm px-5 py-2 bg-white text-base font-medium text-sky-600 hover:bg-sky-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include './asset/Footer.php'
?>