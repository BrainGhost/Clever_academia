<?php
    include("../../php/config.php");
    include ('./asset/Header.php');

// <!-- NOTIFICATION ALERTS -->
$insert_msg = "";
$student_id = $_SESSION['student_id'];

if ($_SESSION['insert_msg'] !== "") {
        $action = "";
        $_SESSION['alert_notification_resources']="";
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
    <div id="notification" class=" p-4 rounded px-4 py-3 absolute <?php echo ($insert_msg || $_SESSION['insert_msg']) ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 <?php echo $alert_div_color;?> " role="alert">
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
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Mentorship Application
        </h2>
        <span class="openModalBtn">
            <i class="fa fa-users text-teal-600 hover:text-teal-700 text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <button name="new_resources">
            <a href='./applymentor.php' type='button' name='upload0resource' value='upload' class='flex items-center px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>Apply</a>
        </button>
    </div>
    <div class="table mt-4">
        <div class="search flex justify-center">
            <div class=" w-96 my-2">
                <div class="flex items-center justify-center">
                    <label class="block text-teal-700 text-sm px-2 "> View your application progress here </label>
                </div>
            </div> 
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white">
            <?php
                $sql = "SELECT mentor.mentor_id,students.student_id
                FROM mentor
                INNER JOIN mentor_application ON mentor.application_id=mentor_application.application_id
                INNER JOIN students ON mentor_application.student_id=students.student_id
                WHERE students.student_id = $student_id";
                $result = mysqli_query($link, $sql);
                $resultCheck = mysqli_num_rows($result);
                #continue in the table itself
                
                if ($resultCheck > 0) {
                    echo 
                    "
                    <tr class='bg-white text-teal-900 font-semibold text-center'>
                        <td colspan='8'>
                            <div class='flex justify-center p-4'>
                                <h1 class='bg-teal-50 text-gray-600 cursor-pointer shadow-md border border-emerald-200 rounded-md w-96 py-3 px-4'>You are a mentor, you can now use your priviliges to help other by creating study groups , so that other student who wish to join can learn from you and other member. This will contribute to your school activity award. The more life you can impact the better</h1>
                            </div>
                        </td>
                    </tr>
                    ";
                }else{
                    ?>
                    <table id="example" class="w-full">
                        <thead class="bg-teal-600 border-b">
                            <tr class="text-sm font-medium text-white text-left">
                                <th data-priority="1"> ID</th>
                                <th data-priority="2">Reason</th>
                                <th data-priority="2">Topics</th>
                                <th data-priority="3">created On.</th>
                                <th data-priority="4">Status</th>
                                <th data-priority="5">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //Display data into the table 
                                $sql  = "SELECT * FROM mentor_application WHERE student_id = $student_id";
                                $result = mysqli_query($link, $sql);
                                $resultCheck = mysqli_num_rows($result);
                                #continue in the table itself
                                
                                if ($resultCheck > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        //schedule_status
                                        if ($row['application_status'] == "approved" ) {
                                            $status_insert = "<span class='text-sky-400 font-medium'>Approved</span>";
                                        }elseif($row['application_status'] == "processing" ) {
                                            $status_insert = "<span class='text-yellow-600 font-medium'>Processing...</span>";
                                        }else{
                                            $status_insert = "<span class='text-red-700 font-medium'>Denied</span>"; 
                                        }
                                        $application_id = $row['application_id'];
                                        $application_reason = $row['application_reason'];
                                        $topics = $row['topics'];
                                        $date = $row['date'];

                                        if($row['application_status'] !== "approved"){

                                        
                                        ?>
                                            <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light'>
                                                <td><?php echo $application_id; ?></td>
                                                <td><?php echo $application_reason; ?></td>
                                                <td><?php echo $topics; ?></td>
                                                <td><?php echo $date; ?></td>
                                                <td><?php echo $status_insert; ?></td>
                                                <td>
                                                    <div class='flex items-center space-x-4'>
                                                        <a title='edit' href='applymentor.php?editID=<?php echo $application_id; ?>'  class='text-sky-400 grid place-items-center rounded-full hover:text-sky-500 transition duration-150 ease-in-out'>
                                                            <i class='fa fa-pencil  cursor-pointer text-lg' aria-hidden='true'></i>
                                                        </a>
                                                        <a title='delete' href='./student_action.php?deletedID=<?php echo $application_id; ?>' class='text-red-400 grid place-items-center rounded-full hover:text-red-500 transition duration-150 ease-in-out'>
                                                            <i class='fa fa-trash  cursor-pointer text-lg' aria-hidden='true'></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php
                                        }else{
                                            echo 
                                            "
                                            <tr class='bg-white text-teal-900 font-semibold text-center'>
                                                <td colspan='8'>
                                                    <div class='flex justify-center'>
                                                        <h1 class='bg-teal-50 cursor-pointer shadow-md border border-emerald-200 rounded-md w-96 py-3 px-4'>You were once a mentor, Contact the admin to enable you for another application</h1>
                                                    </div>
                                                </td>
                                            </tr>
                                            ";
                                            
                                        }
                                    }
                                    mysqli_free_result($result);
                                }else { ?>
                                    <tr class='bg-teal-50 border border-teal-100 border-t-0 text-sm text-teal-900 font-semibold text-center'>
                                        <td colspan='8'>
                                            You have no application.
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
                    <?php
                }
            ?>
		</div>
    </div>
</div>

<?php
    include './asset/Footer.php'
?>