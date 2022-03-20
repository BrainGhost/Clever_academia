<?php
    include '../../php/config.php';
    include './asset/Header.php';
?>

<?php
#############################################
// define variable and initialixze them with an empty string
$doctor_id = $doctor_schedule_date = $doctor_schedule_day = $doctor_schedule_start_time = $doctor_schedule_end_time = $average_consulting_time = "";
$doctor_schedule_date_err = $doctor_schedule_start_time_err = $doctor_schedule_end_time_err = $average_consulting_time_err = $insert_msg = $alert_notification = "";

if($_SESSION["level"] == "counselor"){
    $doctor_id = $_SESSION["id"];
}
// INSERT FUNCTIONALITY
if(isset($_POST["add"]))
{
    #check for validation
    if(empty($_POST['doctor_schedule_date'])){
        $doctor_schedule_date_err = "Date can not be empty";
    }elseif (trim($_POST['doctor_schedule_date']) < date('Y-m-d') ) {
        # check if the date inserted is > to the current data
        $doctor_schedule_date_err = "Invalid date, try the day ahead of the current one.";
        
    }else{
        $doctor_schedule_date = date("Y-m-d", strtotime(trim($_POST['doctor_schedule_date'])));
        $doctor_schedule_day = date("l", strtotime(trim($_POST['doctor_schedule_date'])));
    }

    if(empty($_POST['doctor_schedule_start_time'])){
        $doctor_schedule_start_time_err = "Start time can not be empty";
    }else{
        $doctor_schedule_start_time = trim($_POST['doctor_schedule_start_time']);
    }

    if(empty($_POST['doctor_schedule_end_time'])){
        $doctor_schedule_end_time_err = "End time can not be empty";
    }else{
        $doctor_schedule_end_time = trim($_POST['doctor_schedule_end_time']);
    }
    
    if(empty($_POST['average_consulting_time'])){
        $average_consulting_time_err = "Average consulting can not be empty";
    }else{
        $average_consulting_time = trim($_POST['average_consulting_time']);
    }

    #insert data into the database if all the errors are cleared
    if (empty($doctor_id_err) && empty($doctor_schedule_date_err) && empty($doctor_schedule_start_time_err) && empty($doctor_schedule_end_time_err) && empty($average_consulting_time_err)) {
        # insert the data if all errors are lifted
        $sql = "INSERT INTO doctor_schedule(doctor_schedule_date, doctor_schedule_day, doctor_schedule_start_time, doctor_schedule_end_time, average_consulting_time, doctor_id) VALUES ('$doctor_schedule_date' , '$doctor_schedule_day', '$doctor_schedule_start_time' ,'$doctor_schedule_end_time' ,$average_consulting_time ,$doctor_id )";
        $result = mysqli_query($link, $sql);
        if($result){
            $insert_msg = "Record inserted successfully.";
            
            $insert_msg = "Record inserted successfully.";
            $alert_notification = "success";
        }else{
            echo "ERROR";
        }
    }        
}

?>
<!--Overlay Effect-->
<div
	class="absolute hidden inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-20"
	id="my-modal"
></div>

<!-- NOTIFICATION ALERTS -->
<div class="p-4 rounded px-4 py-3 absolute <?php echo $insert_msg ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 <?php echo ($alert_notification == 'success' ) ? 'bg-emerald-100 border-emerald-500 text-emerald-700' : 'bg-red-100 border-red-500 text-red-700' ;?> " role="alert">
    <strong class="font-bold"><?php echo ($alert_notification == 'success' ) ? 'Success' : 'Danger' ;?>!</strong>
    <span class="block sm:inline mr-12"><?php echo $insert_msg; ?></span>
    <span id="close-nft" class="absolute top-0 bottom-0 right-0 px-3 py-3 <?php echo ($alert_notification == 'success' ) ? 'bg-emerald-200 text-emerald-700' : 'bg-red-200 text-red-700' ;?> cursor-pointer">
        <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
    </span>
</div>
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Schedule Management
        </h2>
        <span class="openModalBtn">
            <i class="fa fa-plus-circle text-teal-600 hover:text-teal-700 cursor-pointer text-3xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2">
        <div class="search flex justify-end">
            <div class=" w-96 my-2">
                <div class="flex items-center">
                    <label for="" class="block text-teal-700 text-sm px-2"> Search </label>
                    <input type="text" placeholder="" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " >
                </div>
            </div> 
        </div>
        <div id='recipients' class="overflow-hidden rounded shadow bg-white">
            <table id="example" class="min-w-full" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
				<thead class="bg-teal-600 border-b">
					<tr class="text-sm font-medium text-teal-50 text-left">
						<th data-priority="1">Schedule date</th>
						<th data-priority="2">Schedule day</th>
						<th data-priority="3">Start time</th>
						<th data-priority="4">End time</th>
						<th data-priority="5">Consulting time</th>
						<th data-priority="6">Status</th>
						<th data-priority="7">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php
                        //Display data into the table 
                        $sql  = "SELECT doctor_schedule_id, doctor_schedule_date, (SELECT DAYNAME(doctor_schedule_date)) AS doctor_schedule_day, (SELECT TIME_FORMAT(doctor_schedule_start_time, ' %H:%i %p ')) AS doctor_schedule_start_time, (SELECT DAYNAME(doctor_schedule_date)) AS doctor_schedule_day, (SELECT TIME_FORMAT(doctor_schedule_end_time, ' %H:%i %p ')) AS doctor_schedule_end_time, average_consulting_time, doctor_id FROM doctor_schedule;";
                        $result = mysqli_query($link, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        #continue in the table itself
                        
                        if ($resultCheck > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo
                                "
                                <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light'>
                                    <td>".$row['doctor_schedule_date']."</td>
                                    <td>".$row['doctor_schedule_day']."</td>
                                    <td>".$row['doctor_schedule_start_time']."</td>
                                    <td>".$row['doctor_schedule_end_time']."</td>
                                    <td>".$row['average_consulting_time']." Minutes</td>
                                    <td>
                                        <button class='px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-sky-100 text-teal-500 font-medium'>
                                            Active
                                        </button>
                                        <button class='hidden px-4 py-1 border border-red-500 bg-red-50 rounded  hover:bg-red-100 text-red-500 font-medium'>
                                            Inactive
                                        </button>
                                    </td>
                                    <td>
                                        <div class='flex items-center'>
                                            <span class='text-sky-400 grid place-items-center rounded-full hover:text-sky-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-pencil  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </span>
                                            <a href='schedule_action.php?id=".$row['doctor_schedule_id']."' class='text-red-400 grid place-items-center rounded-full hover:text-red-500 px-4 transition duration-150 ease-in-out'>
                                                <i class='fa fa-trash  cursor-pointer text-xl' aria-hidden='true'></i>
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
    
    <div class="modalOpen fade hidden absolute left-1/2 top-10 -translate-x-1/2 w-[700px] mx-auto h-auto outline-none overflow-x-hidden overflow-y-auto z-30"
    id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post">
            <div class="modal-dialog relative w-auto pointer-events-none  ">
                <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none">
                    <div
                        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-2xl font-medium leading-normal text-gray-600">Add shedule data</h5>
                        <button type="button"
                        class="btn-close box-content w-6 h-6 p-1  text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="modal-body relative p-4 text-gray-600">
                        <div class="form-group">
                            <label class="text-base">Schedule Date</label>
                            <div class="input-group flex text-gray-600 w-full rounded pt-2 pb-1">
                                <div class="input-group-prepend bg-gray-100 py-2 px-3 text-base">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="date" name="doctor_schedule_date" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 bg-teal-50 cursor-pointer rounded "  autocomplete="off" /> 
                            </div>
                            <span class="text-xs text-red-500"><?php echo $doctor_schedule_date_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label class="text-base">Start Time</label>
                            <div class="input-group flex text-gray-600 w-full rounded pt-2 pb-1">
                                <div class="input-group-prepend input-group-prepend bg-gray-100 py-2 px-3 text-base">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                </div>
                                <input type="time" min="09:00" max="18:00" name="doctor_schedule_start_time" id="doctor_schedule_start_time" class="form-control datetimepicker-input text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded "   autocomplete="off" />
                            </div>
                            <span class="text-xs text-red-500"><?php echo $doctor_schedule_start_time_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label class="text-base">End Time</label>
                            <div class="input-group input-group flex text-gray-600 w-full rounded pt-2 pb-1">
                                <div class="input-group-prepend input-group-prepend bg-gray-100 py-2 px-3 text-base">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                </div>
                                <input type="time" min="09:00" max="18:00" name="doctor_schedule_end_time" id="doctor_schedule_end_time" class="form-control datetimepicker-input text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded "  autocomplete="off" />
                            </div>
                            <span class="text-xs text-red-500"><?php echo $doctor_schedule_end_time_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label class="text-base">Average Consulting Time</label>
                            <div class="input-group input-group input-group flex text-gray-600 w-full rounded pt-2 pb-1">
                                <div class="input-group-prepend bg-gray-100 py-2 px-3 text-base">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                </div>
                                <select name="average_consulting_time" id="average_consulting_time" class="bg-white form-control text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded" >
                                    <option value="">Select Consulting Duration</option>
                                    <?php
                                    $count = 0;
                                    for($i = 1; $i <= 15; $i++)
                                    {
                                        $count += 5;
                                        echo '<option value="'.$count.'">'.$count.' Minutes</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <span class="text-xs text-red-500"><?php echo $average_consulting_time_err; ?></span>
                        </div>
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button" class="px-6 py-2.5 text-teal-700 border-gray-300 font-medium
                        btn-close
                        text-xs
                        leading-tight
                        uppercase
                        rounded
                        shadow-md
                        hover:bg-gray-50 hover:shadow-lg
                        focus:bg-gray-50 focus:shadow-lg focus:outline-none focus:ring-0
                        active:bg-gray-50 active:shadow-lg
                        transition
                        duration-150
                        ease-in-out">Close</button>

                        <button type="submit" name="add" class="px-6
                        py-2.5
                        bg-teal-600
                        text-white
                        font-medium
                        text-xs
                        leading-tight
                        uppercase
                        rounded
                        shadow-md
                        hover:bg-teal-700 hover:shadow-lg
                        focus:bg-teal-700 focus:shadow-lg focus:outline-none focus:ring-0
                        active:bg-teal-800 active:shadow-lg
                        transition
                        duration-150
                        ease-in-out
                        ml-1">Add</button>
                    </div>
                </div>
            </div>
        </form>      
    </div>
</div>


<!-- Modal -->

<?php
    include './asset/Footer.php'
?>