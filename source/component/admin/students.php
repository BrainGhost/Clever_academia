<?php
    include("../../php/config.php");
    include ('./asset/Header.php');
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
        <div class="p-4 rounded px-4 py-3 absolute <?php echo ($insert_msg || $_SESSION['insert_msg']) ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 <?php echo $alert_div_color;?> " role="alert">
            <strong class="font-bold"><?php echo $alert_msg; ?>! &nbsp;</strong>
            <span class="block sm:inline mr-12"><?php echo  $insert_msg ? $insert_msg : $_SESSION['insert_msg'] ; ?></span>
            <span onclick="closeNFT(this); <?php $_SESSION['insert_msg'] = null; ?>" class="absolute top-0 bottom-0 right-0 px-3 py-3 <?php echo $alert_btn_color;?> cursor-pointer">
                <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
            </span>
        </div>
    <?php     
        }
?>
<!--Overlay Effect-->
<div
	class="absolute hidden inset-0 bg-gray-600 bg-opacity-60 overflow-y-auto h-full w-full z-20"
	id="my-modal"
></div>
<!-- Remove everything INSIDE this div to a really blank page -->

<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Student management
        </h2>
        <span class="">
            <i class="fa fa-user text-<?php echo $primary_color; ?>-600 hover:text-<?php echo $primary_color; ?>-700 text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <button name="new_resources">
            <a href='./editStudent.php' name='' class='flex items-center px-4 py-1 border border-<?php echo $primary_color; ?>-500 bg-<?php echo $primary_color; ?>-50 rounded  hover:bg-<?php echo $primary_color; ?>-100 text-<?php echo $primary_color; ?>-500 font-medium'>New Student</a>
        </button>
        <div class="search flex justify-end">
            <div class=" w-96 my-2">
                <div class="flex items-center">
                    <label for="" class="block text-<?php echo $primary_color; ?>-700 text-sm px-2"> Search </label>
                    <input type="text" placeholder="Search students" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded " >
                </div>
            </div> 
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white">
            <table id="example" class="w-full">
				<thead class="bg-<?php echo $primary_color; ?>-600 border-b">
					<tr class="text-sm font-medium text-white text-left">
						<th data-priority="1">ID</th>
						<th data-priority="1">profile</th>
                        <th data-priority="2">student name</th>
                        <th data-priority="3">Gender</th>
                        <th data-priority="4">Phone number</th>
                        <th data-priority="5">date of birth</th>
                        <th data-priority="6">department</th>
                        <th data-priority="7">regist-grad</th>
						<th data-priority="8">Level</th>
                        <th data-priority="10">Address</th>
                        <th data-priority="11">Account</th>
						<th data-priority="12">Status</th>
						<th data-priority="13">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php
                        //Display data into the table 
                        $sql  = "SELECT * FROM students;";
                        $result = mysqli_query($link, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        #continue in the table itself
                        
                        if ($resultCheck > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                //schedule_status
                                $status = $row['student_status'];
                                if ($row['student_status'] == 1 ) {
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['student_id'].",".$status.");' type='button' name='change_status' value='Active' class='px-4 py-1 border border-sky-500 bg-sky-50 rounded  hover:bg-sky-100 text-sky-500 font-medium'>Active</a>";
                                }else{
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['student_id'].",".$status.");' type='button' name='change_status' value='Inactive' class='px-4 py-1 border border-red-500 bg-red-50 rounded  hover:bg-red-100 text-red-500 font-medium'>Inactive</a>"; 
                                }
                                #has an account TRUE or FALSE
                                $hasAccount = $row['has_account'];
                                if ($hasAccount == 1 ) {
                                    $has_account = "<span class='text-sky-400 font-medium uppercase'>true</span>";
                                }else{
                                    $has_account = "<span class='text-red-400 font-medium uppercase'>false</a>"; 
                                }
                                #check if profile exist
                                if ($row['profile'] !== "") {
                                    $profile = "../../images/".$row['profile'];
                                }else {
                                   $profile = "../../images/placeholder.png";
                                }
                                ?>
                                <tr class='display_image bg-white border-b transition duration-300 ease-in-out hover:bg-<?php echo $primary_color; ?>-50 text-sm text-gray-900 font-light'>
                                    <td><?php echo $row['student_id'] ?></td>
                                    <td><img src="<?php echo $profile; ?>" alt="" class="w-16 h-16"></td>
                                    <td><?php echo $row['lastname']." ".$row['firstname'] ;?></td>
                                    <td><?php echo $row['gender'] ;?></td>
                                    <td><?php echo $row['phone_number'] ;?></td>
                                    <td><?php echo $row['date_of_birth'] ;?></td>
                                    <td><?php echo $row['major'] ;?></td>
                                    <td><?php echo $row['registration_year']."-".$row['graduation_year'] ;?></td>
                                    <td><?php echo $row['level'] ;?></td>
                                    <td><?php echo $row['address'] ;?></td>
                                    <td><?php echo $has_account;?></td>
                                    <td><?php echo $status_insert;?></td>
            
                                    <td>
                                        <div class='flex items-center space-x-4'>
                                            <a title='View record' href='./action/read.php?viewid="<?php echo $row['student_id'];?>" && deletedstatus ="<?php echo $row['has_account'];?>"' class='text-sky-400 grid place-items-center rounded-full hover:text-sky-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-eye  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                            <a title='Update record' href='javascript:displayModal("<?php echo $row['student_id']; ?>");'   class='text-yellow-400 grid place-items-center rounded-full hover:text-yellow-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-pencil  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                            
                                            <a title='Delete record' href='./doctor_action.php?deletedid="<?php echo $row['student_id'];?>" && deletedstatus ="<?php echo $row['has_account'];?>"'  class='text-red-400 grid place-items-center rounded-full hover:text-red-500 transition duration-150 ease-in-out'>  
                                                <i class='fa fa-trash  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr> 
                            <?php
                            }
                            mysqli_free_result($result);
                        }else{
                            echo
                            "
                            <tr class='bg-<?php echo $primary_color; ?>-50 border border-<?php echo $primary_color; ?>-100 border-t-0 text-sm text-<?php echo $primary_color; ?>-900 font-semibold text-center'>
                                <td colspan='8'>
                                    No student records were found.
                                </td>
                            </tr>
                            ";
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
<!-- ================================CHANGE FROM ACTIVE TO INACTIVE WITH A MODAL====================================== -->
<!-- CONFIRMATION INACTIVE -> ACTIVE ACCOUNT-->

    <div id="confirm-delete-modal" class="hidden fixed z-20 inset-0 overflow-y-auto " aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div id="confirm-delete-modal-close" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <!-- <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span> -->
            
                <div class="inline-block relative align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-text-50">

                   <form method="POST" action="./action/update.php">
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
                                    <input id="updateSTATUS_TEXT" type="hidden" name="updateSTATUS_TEXT">
                                    
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    
                                    <h3 class="text-lg leading-6 font-medium text-<?php echo $primary_color; ?>-900" id="modal-title">Change account status</h3>
                                    <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to do this? this will disable +this user credentials+ and will not be able to connect or login.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" name="update_status_student" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-5 py-2 bg-<?php echo $primary_color; ?>-500 text-base font-medium text-white hover:bg-<?php echo $primary_color; ?>-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo $primary_color; ?>-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">Change Status</button>
                            <a href="./students.php" class="mt-3 w-full inline-flex justify-center rounded-md border border-<?php echo $primary_color; ?>-300 shadow-sm px-5 py-2 bg-white text-base font-medium text-<?php echo $primary_color; ?>-600 hover:bg-<?php echo $primary_color; ?>-50 focus:outline-none focus:ring-2 focus:ring-<?php echo $primary_color; ?>-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">  
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