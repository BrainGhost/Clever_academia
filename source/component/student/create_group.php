<?php
include("../../php/config.php");
include('./asset/Header.php');

// <!-- NOTIFICATION ALERTS -->
$insert_msg = "";

if ($_SESSION['insert_msg'] !== "") {
    $action = "";
    // if ($_SESSION['alert_notification_resources'] = 'delete') {
    //     $action = "delete";
    // } elseif ($_SESSION['alert_notification_resources'] = 'update') {
    //     $action = "update";
    // } elseif ($_SESSION['alert_notification_resources'] = 'success') {
    //     $action = $_SESSION['alert_notification_resources'];
    // }
    $_SESSION['alert_notification_resources'] = '';
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
$sql = "SELECT mentor.mentor_id,students.student_id
    FROM mentor
    INNER JOIN mentor_application ON mentor.application_id=mentor_application.application_id
    INNER JOIN students ON mentor_application.student_id=students.student_id
    WHERE students.student_id = $student_id";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $mentor_id = $row['mentor_id'];
}
?>
<div class="absolute hidden inset-0 bg-gray-600 bg-opacity-60 overflow-y-auto h-full w-full z-20" id="my-modal"></div>
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Your Groups
        </h2>
        <span class="openModalBtn">
            <i class="fa fa-pencil text-teal-600 hover:text-teal-700 text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <?php
        $sql = "SELECT * FROM study_group WHERE mentor_id = $mentor_id";
        $result = mysqli_query($link, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 5) {
            echo
            "
                <div class='bg-white text-teal-900 font-semibold text-center'>
                    <div class='flex justify-center'>
                        <h1 class='bg-teal-50 cursor-pointer shadow-md border border-emerald-200 rounded-md w-96 py-3 px-4'>You have reached you maximamun limits of groups you are allowed to create {5}</h1>
                    </div>
                </div>
                ";
        } else {
            echo
            "
                <button name='new_resources'>
                    <a href='./add_group.php' name='addgroup' value='upload' class='flex items-center px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>Create a group</a>
                </button>
                ";
        }
        ?>
    </div>
    <div class="table mt-4">
        <div class="search flex justify-end">
            <div class=" w-96 my-2">
                <div class="items-center hidden">
                    <label for="" class="block text-teal-700 text-sm px-2"> Search </label>
                    <input type="text" placeholder="Search resources" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded ">
                </div>
            </div>
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white">
            <table id="example" class="w-full">
                <thead class="bg-teal-600 border-b">
                    <tr class="text-sm font-medium text-white text-left">
                        <th data-priority="1"> ID</th>
                        <th data-priority="2">Group Name</th>
                        <th data-priority="3">Description</th>
                        <th data-priority="4">created On.</th>
                        <th data-priority="6">Status</th>
                        <th data-priority="7">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Display data into the table 
                    $sql  = "SELECT * FROM study_group WHERE mentor_id = '$mentor_id'";
                    $result = mysqli_query($link, $sql);
                    $resultCheck = mysqli_num_rows($result);
                    #continue in the table itself

                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $group_id = $row['study_group_id'];
                            $group_name = $row['group_name'];
                            $group_description = $row['group_description'];
                            $group_creation = $row['created_on'];

                            if ($row['mentor_id'] === $mentor_id) {
                                $author_name = "Me";
                            }
                    ?>
                            <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light'>
                                <td><?php echo $group_id; ?></td>
                                <td><?php echo $group_name; ?></td>
                                <td><?php echo $group_description; ?></td>
                                <td><?php echo $group_creation; ?></td>
                                <td>
                                    <div class="mt-2 border-t-2 border-gray-100 flex justify-center">
                                        <a href="single_group.php?joinedGroup=<?php echo $group_id; ?>" class="my-2 px-4 py-1 border border-teal-500 bg-teal-50 rounded-full  hover:bg-teal-100 text-teal-500 font-medium">open</a>
                                    </div>
                                </td>
                                <td>
                                    <div class='flex items-center space-x-4'>
                                        <a title='View resource' href='./student_action.php?group_deletedID=<?php echo $group_id; ?>' class='text-red-400 grid place-items-center rounded-full hover:text-red-500 transition duration-150 ease-in-out'>
                                            <i class='fa fa-trash  cursor-pointer text-lg' aria-hidden='true'></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        mysqli_free_result($result);
                    } else { ?>
                        <tr class='bg-teal-50 border border-teal-100 border-t-0 text-sm text-teal-900 font-semibold text-center'>
                            <td colspan='8'>
                                You have not created any group yet.
                            </td>
                        </tr>
                    <?php
                    }

                    #close connection
                    mysqli_close($link);
                    ?>

                </tbody>
                <!--    -->

            </table>
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