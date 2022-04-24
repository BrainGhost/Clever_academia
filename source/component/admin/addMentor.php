<?php
include("../../php/config.php");
include('./asset/Header.php');




//define variables and initialize with empty values
$firstname = $lastname = $gender = $email = $dateofbirth = $department = $course = $address = $phonenumber = $registration = $graduation = "";
$firstname_err = $lastname_err = $gender_err = $email_err = $dateofbirth_err = $department_err = $course_err = $address_err = $phonenumber_err = $registration_err = $graduation_err = "";

#############################################
// change the timezone from berlin to kenya/nairobi
date_default_timezone_set("Africa/Nairobi");


# Action mentor into the DB
if (isset($_POST['approved_mentor'])) {
    $updateSTATUS_id = trim($_POST['updateSTATUS_id']);
    $approved_date = date("Y-m-d");

    $next_status = "approved";
    $sql = "UPDATE mentor_application SET application_status ='$next_status' WHERE application_id= $updateSTATUS_id";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $sql = "INSERT INTO mentor(application_id, since_date) VALUES ('$updateSTATUS_id',' $approved_date')";
        if (mysqli_query($link, $sql)) {
            $sql = "SELECT student_id FROM mentor_application WHERE application_id = $updateSTATUS_id";
            $result = mysqli_query($link, $sql);
            if ($row = mysqli_fetch_assoc($result)) {
                $student_mentor_id = $row["student_id"];
                $next_status = "mentor";
                $sql = "UPDATE students SET level ='$next_status' WHERE student_id= $student_mentor_id";
                $result = mysqli_query($link, $sql);
                if ($result) {
                    $_SESSION['insert_msg'] = "Application approved successfully.";
                    header("location: ./mentors.php");
                }
            }
        }
    } else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}
if (isset($_POST['denied_mentor'])) {
    $updateSTATUS_id = trim($_POST['updateSTATUS_id']);

    $next_status = "denied";
    $sql = "UPDATE mentor_application SET application_status ='$next_status' WHERE application_id= $updateSTATUS_id";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $sql = "DELETE FROM mentor_application  WHERE application_id= $updateSTATUS_id";
        if (mysqli_query($link, $sql)) {
            $insert_msg = "Application denied successfully.";
            header("location: ./addMentor.php");
        }
    } else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}
// <!-- NOTIFICATION ALERTS -->
$insert_msg = "";

if ($insert_msg !== "") {
?>
    <div class="p-4 rounded px-4 py-3 absolute <?php echo $insert_msg ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 bg-emerald-100 border-emerald-500 text-emerald-700 " role="alert">
        <strong class="font-bold">Warning! &nbsp;</strong>
        <span class="block sm:inline mr-12"><?php echo  $insert_msg; ?></span>
        <span onclick="closeNFT(this);" class="absolute top-0 bottom-0 right-0 px-3 py-3 bg-emerald-200 text-emerald-700 cursor-pointer">
            <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
        </span>
    </div>
<?php
}
?>
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Mentors management
        </h2>
        <a href="./addMentor.php" class="relative text-<?php echo $primary_color; ?>-600 hover:text-<?php echo $primary_color; ?>-700">
            <i class="fa fa-comments text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
            <div class="absolute top-0 -right-2 grid place-items-center bg-red-50 shadow-md h-5 w-5 rounded-full font-bold text-xs">
                <?php
                $sql = "SELECT COUNT(*) AS tot_number FROM mentor_application WHERE application_status = 'processing' ";
                $result = mysqli_query($link, $sql);

                if ($row = mysqli_fetch_assoc($result)) {
                    echo "<span>" . $row['tot_number'] . "</span>";
                }
                mysqli_free_result($result);
                ?>

            </div>
        </a>
    </div>
    <div class="mt-2 w-full">
        <button class="new-resources">
            <a href='./mentors.php' type='button' name='upload-resource' value='upload' class='flex items-center px-4 py-1 border border-<?php echo $primary_color; ?>-500 bg-<?php echo $primary_color; ?>-50 rounded  hover:bg-<?php echo $primary_color; ?>-100 text-<?php echo $primary_color; ?>-500 font-medium'>
                close
                <i class="fa fa-times text-<?php echo $primary_color; ?>-600 text-xl ml-2" aria-hidden="true"></i>
            </a>
        </button>
    </div>
    <div class="form mt-4 lg:w-[900px] h-auto outline-none overflow-x-hidden overflow-y-auto" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="relative w-auto pointer-events-none  ">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none">

                    <div class="modal-body relative p-4 text-gray-600 bg-white">
                        <?php
                        //PIE CHARTS
                        $sql = "SELECT mentor_application.application_id, mentor_application.application_reason, mentor_application.topics, mentor_application.date, mentor_application.application_status, students.firstname, students.lastname, students.profile
                            FROM mentor_application 
                            INNER JOIN students ON mentor_application.student_id=students.student_id
                            WHERE application_status = 'processing' OR application_status = 'approved'
                            ";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            // $topic = substr($row['application_reason'], 0, 80);
                            $application_reason = $row['application_reason'];
                            if ($row['application_status'] == "approved") {
                                $application_status = "<a href='javascript:displayModal_inactive(" . $row['application_id'] . ");' type='button' name='change_status' class='w-24 py-1 border text-sm border-sky-400 bg-sky-50 rounded-xl  hover:bg-sky-100 text-sky-400 font-medium'>Approved</a>";
                            } elseif ($row['application_status'] == "denied") {
                                $application_status = "<a href='javascript:displayModal_inactive(" . $row['application_id'] . ");' type='button' name='change_status' class='w-24 py-1 border text-sm border-red-400 bg-red-50 rounded-xl  hover:bg-red-100 text-red-400 font-medium'>denied</a>";
                            } else {
                                $application_status = "<a href='javascript:displayModal_inactive(" . $row['application_id'] . ");' type='button' name='change_status' class='w-24 py-1 border text-sm border-yellow-400 bg-yellow-50 rounded-xl  hover:bg-yellow-100 text-yellow-400 font-medium'>Processing</a>";
                            }

                            if ($row['date'] == date("Y-m-d")) {
                                $date = "Today";
                            } else {
                                $date = $row['date'];
                            }
                        ?>
                            <div class="w-full h-auto rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer transition-all duration-300">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/<?php echo $row['profile']; ?>" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden ">
                                        <a class="font-medium text-gray-800"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></a>
                                        <span class="text-gray-700 text-sm"><?php echo '. ' . $row['topics']; ?></span>
                                        <div class="text-opacity-80 w-11/12 h-auto mt-0.5 text-gray-600 ">
                                            <?php echo $application_reason; ?>
                                        </div>
                                    </div>
                                    <div class="times text-gray-700 mt-2 text-sm">
                                        <span><?php echo $date; ?></span>
                                    </div>
                                </div>

                                <div class="flex items-center ml-4 bg-white shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <button class="px-2 "><?php echo $application_status; ?></button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </form>
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

                            <h3 class="text-lg leading-6 font-medium text-<?php echo $primary_color; ?>-900" id="modal-title">Change Mentor status</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to do this? Action will take after you have clicked any of the button. which will it be ?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" name="approved_mentor" value="approved" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-5 py-2 bg-<?php echo $primary_color; ?>-500 text-base font-medium text-white hover:bg-<?php echo $primary_color; ?>-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo $primary_color; ?>-500 sm:ml-3 sm:w-20 sm:text-sm cursor-pointer">
                        Approved
                    </button>
                    <button type="submit" name="denied_mentor" value="denied" class="mt-3 w-full inline-flex justify-center rounded-md border border-<?php echo $primary_color; ?>-300 shadow-sm px-5 py-2 bg-<?php echo $primary_color; ?>-50 text-base font-medium text-<?php echo $primary_color; ?>-600 hover:bg-<?php echo $primary_color; ?>-100 focus:outline-none focus:ring-2 focus:ring-<?php echo $primary_color; ?>-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-20 sm:text-sm cursor-pointer">
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