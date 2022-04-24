<?php
include './asset/Header.php'
?>

<!-- Remove everything INSIDE this div to a really blank page -->

<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Reports
        </h2>
        <span class="">
            <i class="fa fa-folder text-red-600 hover:text-red-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="flex items-center border-b">
        <a href="./reports.php" class="bg-red-500 text-white px-3 py-1 border border-red-500 mb-2">Counselor</a>
        <span class="text-gray-300 text-xl mx-2">
            <>
        </span>
        <a href="./reports_mentor.php" class="bg-red-300 text-white px-3 py-1 border border-red-300 mb-2">Mentors</a>
    </div>
    <div class="w-full h-screen lg:h-auto p-2 flex flex-col items-center">
        <div class="w-full lg:w-3/5">

            <div class="container p-4">
                <div class="search flex flex-row-reverse justify-center items-center ">
                    <div name="new_resources" class="ml-4">
                        <button type='button' onclick="window.print()" name='print' value='upload' class='flex items-center px-4 py-1 border border-red-500 bg-orange-50 rounded  hover:bg-orange-100 text-red-500 font-medium'>
                            <i class="fa fa-print space-x-2 pr-2" aria-hidden="true"></i> Print
                        </button>
                    </div>
                    <form action="" method="GET" class=" w-96 my-2">
                        <div class="flex items-center">
                            <label for="" class="block text-gray-700 text-sm px-2"> Search </label>
                            <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                                                                        echo $_GET['search'];
                                                                    } ?>" placeholder="Search counselor by name" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-gray-400 focus:outline-none border border-gray-200 rounded ">
                        </div>
                    </form>
                </div>
                <div class="print_container py-2">
                    <!-- Write content here -->
                    <?php
                    if (isset($_GET['search'])) {
                        $filtervalues = $_GET['search'];
                        //Display data into the table 
                        //Display data into the table
                        $sql  = "SELECT appointment.doctor_id, doctors.fullname,
                            COUNT(*) AS tot_total,
                            SUM(case when appointment_status = 'booked' then 1 else 0 end) AS tot_booked,
                            SUM(case when appointment_status = 'process' then 1 else 0 end) AS tot_process, 
                            SUM(case when appointment_status = 'completed' then 1 else 0 end) AS tot_complete, 
                            SUM(case when appointment_status = 'cancelled' then 1 else 0 end) AS tot_cancelled
                        FROM appointment
                        INNER JOIN doctors ON appointment.doctor_id = doctors.doctor_id
                        WHERE CONCAT(fullname) LIKE '%$filtervalues%' 
                        GROUP BY doctor_id ASC; ";

                        #continue in the table itself
                        $search_result = filterTable($link, $sql);
                        // SELECT() 
                        // 
                    } else {
                        $sql  = "SELECT appointment.doctor_id, doctors.fullname,
                            COUNT(*) AS tot_total,
                            SUM(case when appointment_status = 'booked' then 1 else 0 end) AS tot_booked,
                            SUM(case when appointment_status = 'process' then 1 else 0 end) AS tot_process, 
                            SUM(case when appointment_status = 'completed' then 1 else 0 end) AS tot_complete, 
                            SUM(case when appointment_status = 'cancelled' then 1 else 0 end) AS tot_cancelled
                        FROM appointment
                        INNER JOIN doctors ON appointment.doctor_id = doctors.doctor_id
                        GROUP BY doctor_id ASC; ";
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
                    ?>
                            <div class="card grid mt-3 grid-cols-3 gap-3 p-3 border rounded-md bg-white hover:bg-gray-50 hover:shadow-md transition-all duration-300 cursor-pointer">
                                <div class="border-r pl-2">
                                    <h1 class="text-red-400 font-bold text-base">Counselor fullname</h1>
                                    <h2 class="text-base text-gray-700 mt-10"><?php echo $row['doctor_id'] . ". " . $row['fullname']; ?></h2>
                                </div>
                                <div class="border-r pl-2">
                                    <h1 class="text-red-400 font-bold text-base">Total Session</h1>
                                    <h2 class="text-base text-gray-700 mt-10 font-bold"><?php echo $row['tot_total']; ?></h2>
                                </div>
                                <div class=" ">
                                    <h1 class="text-red-400 font-bold text-base">Counseling session</h1>
                                    <div class="py-2 flex justify-between px-2">
                                        <h1 class="text-sm text-emerald-400">Completed :</h1>
                                        <span class="text-sm text-gray-700 font-bold"><?php echo $row['tot_complete']; ?></span>
                                    </div>
                                    <div class="py-2 flex justify-between px-2">
                                        <h1 class="text-sm text-orange-400">In progress :</h1>
                                        <span class="text-sm text-gray-700 font-bold"><?php echo $row['tot_process']; ?></span>
                                    </div>
                                    <div class="py-2 flex justify-between px-2">
                                        <h1 class="text-sm text-sky-400">Booked :</h1>
                                        <span class="text-sm text-gray-700 font-bold"><?php echo $row['tot_booked']; ?></span>
                                    </div>
                                    <div class="py-2 flex justify-between px-2">
                                        <h1 class="text-sm text-red-400">Canceled :</h1>
                                        <span class="text-sm text-gray-700 font-bold"><?php echo $row['tot_cancelled']; ?></span>
                                    </div>
                                </div>
                            </div>
                    <?php
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

                </div>
            </div>
        </div>

    </div>
</div>

<!-- End Modal -->

<?php
include './asset/Footer.php'
?>