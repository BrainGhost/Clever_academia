<?php
include './asset/Header.php';
?>

<!-- Remove everything INSIDE this div to a really blank page -->

<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Dashboard
        </h2>
        <span class="">
            <i class="fa fa-home text-<?php echo $primary_color; ?>-600 hover:text-<?php echo $primary_color; ?>-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <div class="grid grid-cols-4 gap-4">
            <?php
            //Display data into the table 
            $sql  = "SELECT ( SELECT COUNT(*) FROM students ) AS tot_students, ( SELECT COUNT(*) FROM mentor ) AS tot_mentors, ( SELECT COUNT(*) FROM resources ) AS tot_resources, ( SELECT COUNT(*) FROM doctors WHERE level = 'counselor') AS tot_doctors; ";
            $result = mysqli_query($link, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $total_students = $row['tot_students'];
                $total_mentors = $row['tot_mentors'];
                $total_resources = $row['tot_resources'];
                $total_doctors = $row['tot_doctors'];
            }
            mysqli_free_result($result);
            #close connection
            mysqli_close($link);
            ?>

            <a href="./students.php" class="w-full p-6 bg-sky-100 border-b-4 border-sky-600 rounded-lg shadow-md cursor-pointer">
                <!--Metric Card-->
                <div class="">
                    <div class="flex flex-col items-center">
                        <div class="flex-shrink pr-4 ">
                            <div class="rounded-full py-4 px-5 bg-sky-300">
                                <i class="text-2xl text-sky-600 fa fa-users fa-2x fa-inverse"></i>
                            </div>
                        </div>
                        <div class="grid place-items-center mt-4">
                            <p class="font-bold text-4xl text-sky-600"><?php echo $total_students; ?>
                                <span class="text-sky-400 text-xl">
                                    <i class="fas fa-caret-up"></i>
                                </span>
                                </>
                            <h2 class="font-bold uppercase text-sky-500 mt-1">Total students</h2>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </a>
            <a href="./mentors.php" class="w-full p-6 bg-green-100 border-b-4 border-green-600 rounded-lg shadow-md cursor-pointer">
                <!--Metric Card-->
                <div class="">
                    <div class="flex flex-col items-center">
                        <div class="flex-shrink pr-4 ">
                            <div class="rounded-full py-4 px-5  bg-green-300">
                                <i class="text-2xl text-green-600 fa fa-graduation-cap fa-2x fa-inverse"></i>
                            </div>
                        </div>
                        <div class="grid place-items-center mt-4">
                            <p class="font-bold text-4xl text-green-600"><?php echo $total_mentors; ?>
                                <span class="text-green-400 text-xl">
                                    <i class="fas fa-caret-up"></i>
                                </span>
                            </p>
                            <h2 class="font-bold uppercase text-green-500 mt-1">Total mentors</h2>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </a>
            <a href="./resources.php" class="w-full p-6 bg-red-100 border-b-4 border-red-600 rounded-lg shadow-md cursor-pointer">
                <!--Metric Card-->
                <div class="">
                    <div class="flex flex-col items-center">
                        <div class="flex-shrink pr-4 ">
                            <div class="rounded-full py-4 px-5  bg-red-300">
                                <i class="text-2xl text-red-600 fa fa-book fa-2x fa-inverse"></i>
                            </div>
                        </div>
                        <div class="grid place-items-center mt-4">
                            <p class="font-bold text-4xl text-red-600"><?php echo $total_resources; ?>
                                <span class="text-red-400 text-xl">
                                    <i class="fas fa-caret-up"></i>
                                </span>
                            </p>
                            <h2 class="font-bold uppercase text-red-500 mt-1">Total resources</h2>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </a>
            <a href="./doctors.php" class="w-full p-6 bg-yellow-100 border-b-4 border-yellow-600 rounded-lg shadow-md cursor-pointer">
                <!--Metric Card-->
                <div class="">
                    <div class="flex flex-col items-center">
                        <div class="flex-shrink pr-4 ">
                            <div class="rounded-full py-4 px-5  bg-yellow-300">
                                <i class="text-2xl text-yellow-600 fa fa-child fa-2x fa-inverse"></i>
                            </div>
                        </div>
                        <div class="grid place-items-center mt-4">
                            <p class="font-bold text-4xl text-yellow-600"><?php echo $total_doctors; ?>
                                <span class="text-yellow-400 text-xl">
                                    <i class="fas fa-caret-up"></i>
                                </span>
                            </p>
                            <h2 class="font-bold uppercase text-yellow-500 mt-1">Total counselor</h2>
                        </div>
                    </div>
                </div>
                <!--/Metric Card-->
            </a>
        </div>
        <div class="w-full h-[calc(100vh-30rem)] bg-white mt-8 flex">
            <div id="piechart" style="width: 50%; height: 100%;"></div>
            <div id="line_top_x" style="width: 50%; height: 100%;" class="p-4"></div>
        </div>
    </div>
</div>
<!-- End Modal -->

<?php
include './asset/Footer.php'
?>