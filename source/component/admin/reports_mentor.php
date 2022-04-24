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
        <a href="./reports.php" class="bg-red-300 text-white px-3 py-1 border border-red-300 mb-2">Counselor</a>
        <span class="text-gray-300 text-xl mx-2">
            <>
        </span>
        <a href="./reports_mentor.php" class="bg-red-500 text-white px-3 py-1 border border-red-500 mb-2">Mentors</a>
    </div>
    <div class="w-full h-screen lg:h-auto p-2 flex justify-center">

        <div class="w-full lg:w-3/5 ">

            <div class="container p-4">
                <div class="search flex flex-row-reverse justify-center items-center ">
                    <div name="new_resources" class="ml-4">
                        <button type='button' onclick="window.print()" name='print' value='upload' class='flex items-center px-4 py-1 border border-red-500 bg-red-50 rounded  hover:bg-red-100 text-red-500 font-medium'>
                            <i class="fa fa-print space-x-2 pr-2" aria-hidden="true"></i> Print
                        </button>
                    </div>
                    <form action="" method="GET" class=" w-96 my-2">
                        <div class="flex items-center">
                            <label for="" class="block text-gray-700 text-sm px-2"> Search </label>
                            <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                                                                        echo $_GET['search'];
                                                                    } ?>" placeholder="Search mentor by name" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-gray-400 focus:outline-none border border-gray-200 rounded ">
                        </div>
                    </form>
                </div>
                <div class="print_container py-2">
                    <!-- Write content here -->
                    <?php
                    if (isset($_GET['search'])) {
                        $filtervalues = $_GET['search'];
                        //Display data into the table 
                        $sql  = "SELECT study_group.mentor_id, mentor_application.student_id, students.firstname, students.lastname,
                            COUNT(*) AS tot_total
                            FROM study_group
                            INNER JOIN mentor ON study_group.mentor_id = mentor.mentor_id
                            INNER JOIN mentor_application ON mentor.application_id=mentor_application.application_id
                            INNER JOIN students ON mentor_application.student_id=students.student_id
                            WHERE CONCAT(firstname, lastname) LIKE '%$filtervalues%'
                            GROUP BY mentor_id ASC";

                        // #continue in the table itself
                        $search_result = filterTable($link, $sql);
                    } else {
                        $sql  = "SELECT study_group.mentor_id, study_group.group_name, mentor_application.student_id, students.firstname, students.lastname,
                            COUNT(*) AS tot_total
                            FROM study_group
                            INNER JOIN mentor ON study_group.mentor_id = mentor.mentor_id
                            INNER JOIN mentor_application ON mentor.application_id=mentor_application.application_id
                            INNER JOIN students ON mentor_application.student_id=students.student_id
                            GROUP BY mentor_id ASC";
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
                            $study_mentor_id = $row['mentor_id'];
                    ?>
                            <div class="card grid mt-3 grid-cols-3 gap-3 p-3 border rounded-md bg-white hover:bg-red-50 hover:shadow-md transition-all duration-300 cursor-pointer">
                                <div class="border-r pl-2">
                                    <h1 class="text-red-400 font-bold text-base">Mentor fullname</h1>
                                    <h2 class="text-base text-gray-700 mt-10"><?php echo $row['lastname'] . ". " . $row['firstname']; ?></h2>
                                </div>
                                <div class="border-r pl-2">
                                    <h1 class="text-red-400 font-bold text-base">Number of groups create</h1>
                                    <h2 class="text-base text-gray-700 mt-10 font-bold"><?php echo $row['tot_total']; ?></h2>
                                </div>
                                <div class=" ">
                                    <h1 class="text-red-400 font-bold text-base">List of Groups names</h1>
                                    <?php
                                    $sql = "SELECT * FROM study_group WHERE mentor_id = '$study_mentor_id'";
                                    $result = mysqli_query($link, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $study_name = $row['group_name'];
                                        echo
                                        "
                                        <div class='py-2 flex justify-between px-2'>
                                            <h1 class='text-sm text-gray-700'>*.$study_name</h1>
                                        </div>
                                        ";
                                    }
                                    ?>
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
                    ?>
                </div>
            </div>
        </div>
        <div class="mt-16 rounded border bg-red-50 border-red-500 w-48 h-80 p-2">
            <h1 class="text-red-400 font-bold text-base py-4 bg-red-100 rounded text-center">Statistic <span><i class="fa fa-line-chart" aria-hidden="true"></i></span> </h1>
            <?php
            //Display data into the table 
            $sql  = "SELECT ( SELECT COUNT(*) FROM topics ) AS tot_topics, 
            ( SELECT COUNT(*) FROM study_group ) AS tot_groups, 
            ( SELECT COUNT(*) FROM mentor ) AS tot_mentor, 
            ( SELECT COUNT( DISTINCT student_id) FROM join_study_group ) AS tot_students; ";
            $result = mysqli_query($link, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $total_topics = $row['tot_topics'];
                $total_groups = $row['tot_groups'];
                $total_mentor = $row['tot_mentor'];
                $total_students = $row['tot_students'];
            }
            mysqli_free_result($result);
            #close connection
            mysqli_close($link);
            ?>
            <div class="border-r pl-2 text-sm pt-2">
                <h1 class="text-red-400 font-bold">* Groups Total students</h1>
                <h2 class=" text-gray-700 mt-2 text-center"><?php echo $total_students; ?></h2>
            </div>
            <div class="border-r pl-2 text-sm pt-2">
                <h1 class="text-red-400 font-bold">* Total Groups </h1>
                <h2 class=" text-gray-700 mt-2 text-center"><?php echo $total_groups; ?></h2>
            </div>
            <div class="border-r pl-2 text-sm pt-2">
                <h1 class="text-red-400 font-bold">* Groups mentors</h1>
                <h2 class=" text-gray-700 mt-2 text-center"><?php echo $total_mentor; ?></h2>
            </div>
            <div class="border-r pl-2 text-sm pt-2">
                <h1 class="text-red-400 font-bold">* Courses</h1>
                <h2 class=" text-gray-700 mt-2 text-center"><?php echo $total_topics; ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- End Modal -->

<?php
include './asset/Footer.php'
?>