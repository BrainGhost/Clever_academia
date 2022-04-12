<?php
    include("../../php/config.php");
    include ('./asset/Header.php');

// <!-- NOTIFICATION ALERTS -->
$insert_msg = "";
$student_id = $_SESSION['student_id'];

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
    <div class="p-4 rounded px-4 py-3 absolute <?php echo ($insert_msg || $_SESSION['insert_msg']) ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 <?php echo $alert_div_color;?> " role="alert">
        <strong class="font-bold"><?php echo $alert_msg; ?>! &nbsp;</strong>
        <span class="block sm:inline mr-12"><?php echo  $insert_msg ? $insert_msg : $_SESSION['insert_msg'] ; ?></span>
        <span onclick="closeNFT(this); <?php $_SESSION['insert_msg'] = null; ?>" class="absolute top-0 bottom-0 right-0 px-3 py-3 <?php echo $alert_btn_color;?> cursor-pointer">
            <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
        </span>
    </div>
<?php     
    }
    //Display data into the table 
    $sql  = "SELECT * FROM mentor";
    $result = mysqli_query($link, $sql);
    $resultCheck = mysqli_num_rows($result);
    #continue in the table itself
    
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // $profile = ;
            // $name = ;
            // $topic = ;
        }
        mysqli_free_result($result);
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
            Dashboard
        </h2>
        <span class="openModalBtn">
            <i class="fa fa-home text-teal-600 hover:text-teal-700 text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="bg-white shadow-lg">
        <div class="w-[calc(100vw-20rem)] xl:w-[1000px] p-2 flex gap-4 mx-auto overflow-x-scroll scrollbar-hide">
            <?php
            //PIE CHARTS
            $sql = "SELECT * FROM students";

            $result = mysqli_query($link, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['firstname'].' '.$row['lastname'];
                $topic = $row['major'];
                $profile = $row['profile'];
            ?>
                <div class="w-40 p-2">
                    <a href="view_mentor.php?<?php echo $row['student_id']; ?>" class=" relative w-30 text-center cursor-pointer">
                        <div class="bg-gradient-to-r from-teal-500 via-gray-500 to-red-500 p-1 rounded-full mb-2 mx-auto">
                            <img
                                src="../../images/<?php echo $profile; ?>"
                                class="rounded-full shadow-lg p-1 bg-white opacity-100 hover:opacity-50 transition duration-300 ease-in-out"
                                alt="Avatar"
                            /> 
                        </div>
                        <div>
                            <h5 class="text-xl text-teal-800 font-medium leading-tight mb-2"><?php echo $name; ?></h5>
                            <p class="text-gray-500"><?php echo $topic; ?></p>
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
                <div class="flex items-center">
                    <label for="" class="block text-teal-700 text-sm px-2"> View all the latest update Here. </label>
                </div>
            </div> 
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white">
            <table id="example" class="w-full">
				<thead class="bg-teal-600 border-b">
					<tr class="text-sm font-medium text-white text-left">
						<th data-priority="1">Course ID</th>
                        <th data-priority="2">Name</th>
                        <th data-priority="3">Topics.</th>
						<th data-priority="4">Action</th>
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
                                if ($row['status'] == "approved" ) {
                                    $status_insert = "<button type='button' class='px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>Already joined</button>";
                                }elseif($row['status'] == "processing" ) {
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['application_id'].");' class='px-8 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>Join</a>";
                                }else{
                                    $status_insert = ""; 
                                }
                                $application_id = $row['application_id'];
                                $application_reason = $row['application_reason'];
                                $date = $row['date'];

                                if($row['status'] !== "approved"){
                                ?>
                                    <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light'>
                                        <td><?php echo $application_id; ?></td>
                                        <td><?php echo $application_reason; ?></td>
                                        <td><?php echo $date; ?></td>
                                        <td><?php echo $status_insert; ?></td>
                                    </tr>
                                <?php
                                }else{
                                    echo 
                                    "
                                    <tr class='bg-white text-teal-900 font-semibold text-center'>
                                        <td colspan='8'>
                                            <div class='flex justify-center'>
                                                <h1 class='bg-teal-50 cursor-pointer shadow-md border border-emerald-200 rounded-md w-96 py-3 px-4'>You are a mentor, you can now use your priviliges to help other by creating study groups , so that other student who wish to join can learn from you and other member. This will contribute to your school activity award. The more life you can impact the better</h1>
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
                                    No request found.
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

<?php
    include './asset/Footer.php'
?>