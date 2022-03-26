<?php
    include("../../php/config.php");
    include ('./asset/Header.php');

// <!-- NOTIFICATION ALERTS -->

$insert_msg = "";

if ($_SESSION['insert_msg'] !== "") {
        $action = "";
        if ($_SESSION['alert_notification'] = "delete") {
            $action = "delete";
        } elseif ($_SESSION['alert_notification'] = "update") {
            $action = "update";
        } elseif ($_SESSION['alert_notification'] = "success") {
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
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            E-resources management
        </h2>
        <span class="">
            <i class="fa fa-book text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <button name="new_resources">
            <a href='./uploadresource.php' type='button' name='upload0resource' value='upload' class='flex items-center px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>New resource</a>
        </button>
    </div>
    <div class="table mt-4">
        <div class="search flex justify-end">
            <div class=" w-96 my-2">
                <div class="flex items-center">
                    <label for="" class="block text-teal-700 text-sm px-2"> Search </label>
                    <input type="text" placeholder="Search resources" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " >
                </div>
            </div> 
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white">
            <table id="example" class="w-full">
				<thead class="bg-teal-600 border-b">
					<tr class="text-sm font-medium text-teal-50 text-left">
						<th data-priority="1"> ID</th>
                        <th data-priority="2">Name</th>
						<th data-priority="3">ofYear</th>
                        <th data-priority="4">created By.</th>
                        <th data-priority="5">date of upload</th>
						<th data-priority="6">Status</th>
						<th data-priority="7">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php
                        //Display data into the table 
                        $sql  = "SELECT * FROM resources;";
                        $result = mysqli_query($link, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        #continue in the table itself
                        
                        if ($resultCheck > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                //schedule_status
                                $status = $row['resource_status'];
                                if ($row['resource_status'] == "approved" ) {
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['resource_id'].",".$status.");' type='button' name='change_status' class='px-4 py-1 border border-sky-500 bg-sky-50 rounded-xl  hover:bg-sky-100 text-sky-500 font-medium'>Approved</a>";
                                }elseif($row['resource_status'] == "denied" ) {
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['resource_id'].",".$status.");' type='button' name='change_status' class='px-4 py-1 border border-red-500 bg-yellow-50 rounded-xl  hover:bg-yellow-100 text-yellow-500 font-medium'>denied</a>";
                                }else{
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['resource_id'].",".$status.");' type='button' name='change_status' class='px-4 py-1 border border-yellow-500 bg-yellow-50 rounded-xl  hover:bg-yellow-100 text-yellow-500 font-medium'>Processing</a>"; 
                                }


                                $author_display = $row['author'];
                                if ($author_display = $_SESSION["username"]) {
                                    $author_name = "me";
                                }else {
                                    $author_name = $row['author'];
                                }
                                echo 
                                "
                                <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light'>
                                    <td>".$row['resource_id']."</td>
                                    <td>".$row['resource_name']."</td>
                                    <td>".$row['ofyear']."</td>
                                    <td>$author_name</td>
                                    <td>".$row['created_on']."</td>
                                    <td>$status_insert</td>
            
                                    <td>
                                        <div class='flex items-center space-x-4'>
                                            <a title='View record' href='./action/read.php?viewid=".$row['resource_id']."' class='text-sky-400 grid place-items-center rounded-full hover:text-sky-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-eye  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                            <a title='Update record' href='javascript:displayModal(".$row['resource_id'].");'   class='text-yellow-400 grid place-items-center rounded-full hover:text-yellow-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-pencil  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                            
                                            <a title='Delete record' href='./doctor_action.php?deletedid=".$row['resource_id']."'  class='text-red-400 grid place-items-center rounded-full hover:text-red-500 transition duration-150 ease-in-out'>  
                                                <i class='fa fa-trash  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                ";  
                            }
                            mysqli_free_result($result);
                        }else{
                            echo
                            "
                            <tr class='bg-teal-50 border border-teal-100 border-t-0 text-sm text-teal-900 font-semibold text-center'>
                                <td colspan='8'>
                                    No resources records were found.
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

<?php
    include './asset/Footer.php'
?>