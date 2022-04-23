<?php
include '../../php/config.php';
include './asset/Header.php';
date_default_timezone_set("Africa/Nairobi");
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
                        <th data-priority="2">Patient Name</th>
                        <th data-priority="3">Appointment Date</th>
                        <th data-priority="4">Appointment Time</th>
                        <th data-priority="5">Appointment Day</th>
                        <th data-priority="6">Appointment Status</th>
                        <th data-priority="7">View</th>
                    </tr>
                </thead>
                <tbody class="bg-white transition duration-300 ease-in-out text-sm text-gray-700 ">
                    <?php
                    if (isset($_GET['search'])) {
                        $filtervalues = $_GET['search'];
                        //Display data into the table 
                        //Display data into the table
                        $sql  = "SELECT * FROM appointment  
                        INNER JOIN doctor_schedule 
                        ON doctor_schedule.doctor_schedule_id = appointment.doctor_schedule_id 
                        INNER JOIN students 
                        ON students.student_id = appointment.student_id 
                        WHERE CONCAT(doctor_schedule_date, doctor_schedule_day, doctor_schedule_start_time, doctor_schedule_end_time,average_consulting_time) LIKE '%$filtervalues%'  ORDER BY doctor_schedule_id ASC;";

                        #continue in the table itself
                        $search_result = filterTable($link, $sql);
                    } else {
                        //Display data into the table
                        $sql  = "SELECT * FROM appointment  
                        INNER JOIN doctor_schedule 
                        ON doctor_schedule.doctor_schedule_id = appointment.doctor_schedule_id 
                        INNER JOIN students 
                        ON students.student_id = appointment.student_id";

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
                                $status = "<button class='px-2 py-1 rounded bg-emerald-400 text-white'>Completed</button>";
                            }
                            if ($row['appointment_status'] == "completed") {
                                $status = "<button class='px-2 py-1 rounded bg-sky-400 text-white'>In progress</button>";
                            }
                            if ($row['appointment_status'] == "completed") {
                                $status = "<button class='px-2 py-1 rounded bg-yellow-400 text-white'>Booked</button>";
                            }
                            if ($row['appointment_status'] == "completed") {
                                $status = "<button class='px-2 py-1 rounded bg-red-400 text-white'>Canceled</button>";
                            }
                            echo
                            "
                                <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-<?php echo $primary_color; ?>-50 text-sm text-gray-900 font-light'>
                                    <td>" . $row['appointment_id'] . "</td>
                                    <td>" . $row['doctor_schedule_id'] . "</td>
                                    <td>" . $row[''] . "</td>
                                    <td>" . $row[''] . "</td>
                                    <td>" . $row[''] . "</td>
                                    <td>$status</td>
                                    <td>
                                        <div class='flex items-center'>
                                            <a href='javascript:displayModal(" . $row['appointment_id'] . ");'  class='text-sky-400 grid place-items-center rounded-full hover:text-sky-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-eye  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                        </div>
                                    </td>
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


    <?php
    include './asset/Footer.php'
    ?>