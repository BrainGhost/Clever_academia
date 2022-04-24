<?php
include './asset/Header.php';
date_default_timezone_set("Africa/Nairobi");
if ($_SESSION["level"] == "counselor") {
    $doctor_id = $_SESSION["id"];
}
$insert_msg = $alert_msg = "";
#chnage appointment status
if (isset($_POST['approved_status'])) {
    $updateSTATUS_id = trim($_POST['updateSTATUS_id']);

    $next_status = "completed";
    $sql = "UPDATE appointment SET appointment_status='$next_status' WHERE appointment_id= $updateSTATUS_id";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $insert_msg = "Status changed successfully.";
        $alert_msg = "Completed";
    } else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}
if (isset($_POST['denied_status'])) {
    $updateSTATUS_id = trim($_POST['updateSTATUS_id']);

    $next_status = "cancelled";
    $sql = "UPDATE appointment SET appointment_status='$next_status' WHERE appointment_id= $updateSTATUS_id";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $insert_msg = "Status changed successfully.";
        $alert_msg = "Cancelled";
    } else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}

// <!-- NOTIFICATION ALERTS -->

if ($insert_msg !== "") {

?>
    <div id="notification" class="p-4 rounded px-4 py-3 absolute <?php echo ($insert_msg) ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 bg-emerald-100 border-emerald-500 text-emerald-700" role="alert">
        <strong class="font-bold"><?php echo $alert_msg; ?>! &nbsp;</strong>
        <span class="block sm:inline mr-12"><?php echo  $insert_msg; ?></span>
        <span onclick="closeNFT(this);" class="absolute top-0 bottom-0 right-0 px-3 py-3 bg-emerald-200 text-emerald-700 cursor-pointer">
            <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
        </span>
    </div>
<?php
}
?>
<!--Overlay Effect-->
<div class="absolute hidden inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-20" id="my-modal"></div>

<!-- Remove everything INSIDE this div to a really blank page -->

<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Appointment Management
        </h2>
    </div>
    <div class="mt-2 rounded shadow bg-white">
        <div class="flex items-center border-b p-2">
            <h2 class="my-2 text-lg font-thin text-gray-600 flex-1">
                Appointment list
            </h2>
            <div class="flex h-8">
                <input type="text" placeholder="" class="bg-slate-100 text-gray-600 block w-full mr-2 px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded ">
                <input type="text" placeholder="" class="bg-slate-100 text-gray-600 block w-full mr-2 px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded ">
                <span class="bg-<?php echo $primary_color; ?>-600 grid place-items-center rounded hover:bg-<?php echo $primary_color; ?>-700 transition duration-150 ease-in-out">
                    <i class="fa fa-search px-2 text-white  cursor-pointer text-lg" aria-hidden="true"></i>
                </span>
            </div>

        </div>
        <div class="search flex justify-end mx-2">
            <form action="" method="GET" class=" w-96 mt-8 my-2">
                <div class="flex items-center">
                    <label for="" class="block text-<?php echo $primary_color; ?>-700 text-sm px-2"> Search </label>
                    <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                                                                echo $_GET['search'];
                                                            } ?>" placeholder="Search resources" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded ">
                </div>
            </form>
        </div>
        <div id='recipients' class="overflow-hidden ">
            <table id="example" class="min-w-full " style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead class="bg-<?php echo $primary_color; ?>-600 border-b">
                    <tr class="text-sm font-medium text-white text-left">
                        <th data-priority="1">Appointment No.</th>
                        <th data-priority="1">Made on.</th>
                        <th data-priority="2">Patient Name</th>
                        <th data-priority="3">Appointment Date</th>
                        <th data-priority="4">Appointment Day</th>
                        <th data-priority="5">Appointment Time</th>
                        <th data-priority="6">Appointment Status</th>
                        <th data-priority="6">Changes Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white transition duration-300 ease-in-out text-sm text-gray-700 ">
                    <?php
                    if (isset($_GET['search'])) {
                        $filtervalues = $_GET['search'];
                        //Display data into the table 
                        //Display data into the table
                        $sql  = "SELECT
                        appointment.appointment_id, appointment.appointment_time, appointment.appointment_status,
                        (SELECT DAYNAME(doctor_schedule.doctor_schedule_date)) AS doctor_schedule_day, 
                        (SELECT TIME_FORMAT(doctor_schedule.doctor_schedule_start_time, ' %H:%i %p ')) AS doctor_schedule_start_time, 
                        (SELECT DATE_FORMAT(doctor_schedule.doctor_schedule_date, ' %Y-%m-%d ')) AS doctor_schedule_date,
                        students.firstname, students.lastname
                         FROM appointment  
                            INNER JOIN doctor_schedule 
                            ON doctor_schedule.doctor_schedule_id = appointment.doctor_schedule_id 
                            INNER JOIN students 
                            ON students.student_id = appointment.student_id
                        WHERE doctor_schedule.doctor_id = $doctor_id
                        AND CONCAT(doctor_schedule_day, doctor_schedule_start_time,doctor_schedule_date, appointment_status) LIKE '%$filtervalues%' ORDER BY appointment_id ASC;";

                        #continue in the table itself
                        $search_result = filterTable($link, $sql);
                    } else {
                        //Display data into the table
                        $sql  = "SELECT
                        appointment.appointment_id, appointment.appointment_time, appointment.appointment_status,
                        (SELECT DAYNAME(doctor_schedule.doctor_schedule_date)) AS doctor_schedule_day, 
                        (SELECT TIME_FORMAT(doctor_schedule.doctor_schedule_start_time, ' %H:%i %p ')) AS doctor_schedule_start_time, 
                        (SELECT DATE_FORMAT(doctor_schedule.doctor_schedule_date, ' %Y-%m-%d ')) AS doctor_schedule_date,
                        students.firstname, students.lastname
                         FROM appointment  
                            INNER JOIN doctor_schedule 
                            ON doctor_schedule.doctor_schedule_id = appointment.doctor_schedule_id 
                            INNER JOIN students 
                            ON students.student_id = appointment.student_id
                        WHERE doctor_schedule.doctor_id = $doctor_id;";

                        #continue in the table itself
                        $search_result = filterTable($link, $sql);
                    }
                    function filterTable($link, $sql)
                    {
                        $result = mysqli_query($link, $sql);
                        return $result;
                    }
                    if (mysqli_num_rows($search_result) > 0) {
                        while ($row = mysqli_fetch_assoc($search_result)) {
                            //schedule_status
                            $status = " ";
                            if ($row['appointment_status'] == "completed") {
                                $status = "<button class='px-3 py-1 rounded-full bg-emerald-400 text-white'>Completed</button>";
                            }
                            if ($row['appointment_status'] == "progress") {
                                $status = "<button class='px-3 py-1 rounded-full bg-orange-400 text-white'>In progress..</button>";
                            }
                            if ($row['appointment_status'] == "booked") {
                                $status = "<button class='px-3 py-1 rounded-full bg-sky-400 text-white'>Booked</button>";
                            }
                            if ($row['appointment_status'] == "cancelled") {
                                $status = "<button class='px-3 py-1 rounded-full bg-red-400 text-white'>Canceled</button>";
                            }
                            $change_status = "<a href='javascript:displayModal_inactive(" . $row['appointment_id'] . ");' type='button' name='change_status' class='px-4 py-1 border border-sky-500 bg-sky-50 rounded  hover:bg-sky-100 text-sky-500 font-medium'>Change</a>";
                            echo
                            "
                                <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-sky-50 text-sm text-gray-900 font-light'>
                                    <td>" . $row['appointment_id'] . "</td>
                                    <td>" . $row['appointment_time'] . "</td>
                                    <td>" . $row['lastname'] . " " . $row['firstname'] . "</td>
                                    <td>" . $row['doctor_schedule_date'] . "</td>
                                    <td>" . $row['doctor_schedule_day'] . "</td>
                                    <td>" . $row['doctor_schedule_start_time'] . "</td>
                                    <td>$status</td>
                                    <td>$change_status</td>
                                </tr>
                                ";
                        }
                    } else {
                        echo
                        "
                            <tr class='bg-<?php echo $primary_color; ?>-50 border border-<?php echo $primary_color; ?>-100 border-t-0 text-sm text-<?php echo $primary_color; ?>-900 font-semibold text-center'>
                                <td colspan='8'>
                                    No records were found.
                                </td>
                            </tr>
                            ";
                    }
                    #close connection
                    mysqli_close($link);
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

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
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 bg-<?php echo $primary_color; ?>-100  sm:h-10 sm:w-10">
                            <!-- Heroicon name: outline/exclamation -->
                            <svg class="h-6 w-6 text-<?php echo $primary_color; ?>-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div id="modalSTATUS">
                            <input id="updateSTATUS" type="hidden" name="updateSTATUS_id">
                            <!-- <input id="updateSTATUS_TEXT" type="hidden" name="updateSTATUS_id">  -->
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">

                            <h3 class="text-lg leading-6 font-medium text-<?php echo $primary_color; ?>-900" id="modal-title">Change appointment status</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to do this? this will change the appointment status.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" name="approved_status" value="completed" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-5 py-2 bg-sky-500 text-base font-medium text-white hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 sm:ml-3 sm:w-20 sm:text-sm cursor-pointer">
                        Completed
                    </button>
                    <button type="submit" name="denied_status" value="cancel" class="mt-3 w-full inline-flex justify-center rounded-md border border-sky-300 shadow-sm px-5 py-2 bg-sky-50 text-base font-medium text-sky-600 hover:bg-sky-100 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-20 sm:text-sm cursor-pointer">
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