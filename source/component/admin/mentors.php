<?php
    include("../../php/config.php");
    include './asset/Header.php';
    // <!-- NOTIFICATION ALERTS -->
    $insert_msg = "";

    if ($_SESSION['insert_msg'] !== "") {

    ?>
        <div class="p-4 rounded px-4 py-3 absolute <?php echo $_SESSION['insert_msg'] ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 bg-emerald-100 border-emerald-500 text-emerald-700 " role="alert">
            <strong class="font-bold">Warning! &nbsp;</strong>
            <span class="block sm:inline mr-12"><?php echo $_SESSION['insert_msg'] ; ?></span>
            <span onclick="closeNFT(this); <?php $_SESSION['insert_msg'] = null; ?>" class="absolute top-0 bottom-0 right-0 px-3 py-3 bg-emerald-200 text-emerald-700 cursor-pointer">
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
            Mentors management
        </h2>  
        <a href="./addMentor.php" class="relative text-<?php echo $primary_color; ?>-600 hover:text-<?php echo $primary_color; ?>-700">
            <i class="fa fa-comments text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
            <div class="absolute top-0 -right-2 grid place-items-center bg-red-50 shadow-md h-5 w-5 rounded-full font-bold text-xs">
                <?php
                $sql = "SELECT COUNT(*) AS tot_number FROM mentor_application WHERE application_status = 'processing'";
                $result = mysqli_query($link, $sql);
            
                if ($row = mysqli_fetch_assoc($result)) {
                    echo "<span>".$row['tot_number']."</span>";
                }
                mysqli_free_result($result);
                ?>
                
            </div>
        </a>
    </div>
    <div class="mt-2 w-full">
        <button name="new_resources">
            <a href='./addMentor.php' name='' class='flex items-center px-4 py-1 border border-<?php echo $primary_color; ?>-500 bg-<?php echo $primary_color; ?>-50 rounded  hover:bg-<?php echo $primary_color; ?>-100 text-<?php echo $primary_color; ?>-500 font-medium'>View application</a>
        </button>
        <div class="search flex justify-end">
            <div class=" w-96 my-2">
                <div class="flex items-center">
                    <label for="" class="block text-<?php echo $primary_color; ?>-700 text-sm px-2"> Search </label>
                    <input type="text" placeholder="Search mentors" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded " >
                </div>
            </div> 
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white">
            <table id="example" class="w-full">
				<thead class="bg-<?php echo $primary_color; ?>-600 border-b">
					<tr class="text-sm font-medium text-white text-left">
						<th data-priority="1">Mentor ID</th>
                        <th data-priority="2">Profile</th>
                        <th data-priority="3">Full name</th>
                        <th data-priority="4">Gender</th>
                        <th data-priority="5">speciality</th>
                        <th data-priority="6">Mentor</th>
						<th data-priority="7">Email address</th>
                        <th data-priority="8">phone No.</th>
                        <th data-priority="9">Graduation date</th>
						<th data-priority="10">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php
                        //Display data into the table 
                        $sql = "SELECT mentor.mentor_id,mentor.since_date, mentor_application.topics, students.firstname, students.lastname,students.email,students.gender, students.phone_number,students.graduation_year, students.profile
                            FROM mentor
                            INNER JOIN mentor_application ON mentor.application_id=mentor_application.application_id
                            INNER JOIN students ON mentor_application.student_id=students.student_id
                            ";
                        $result = mysqli_query($link, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        #continue in the table itself
                        
                        if ($resultCheck > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                #check if profile exist
                                if ($row['profile'] !== "") {
                                    $profile = "../../images/".$row['profile'];
                                }else {
                                   $profile = "../../images/placeholder.png";
                                }
                                echo 
                                "
                                <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-<?php echo $primary_color; ?>-50 text-sm text-gray-900 font-light'>
                                    <td>".$row['mentor_id']."</td>
                                    <td><img src='$profile' class='w-16 h-16'></td>
                                    <td>".$row['firstname'].' '.$row['lastname']."</td>
                                    <td>".$row['gender']."</td>
                                    <td>".$row['topics']."</td>
                                    <td class='text-center'>".'Since<br/>'.$row['since_date']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['phone_number']."</td>
                                    <td>".$row['graduation_year']."</td>
            
                                    <td>
                                        <div class='flex items-center space-x-4'>
                                            <a title='Delete record' href='./doctor_action.php?mentordeletedid=".$row['mentor_id']."'  class='text-red-400 grid place-items-center rounded-full hover:text-red-500 transition duration-150 ease-in-out'>  
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
                            <tr class='bg-<?php echo $primary_color; ?>-50 border border-<?php echo $primary_color; ?>-100 border-t-0 text-sm text-<?php echo $primary_color; ?>-900 font-semibold text-center'>
                                <td colspan='8'>
                                    No Mentors records were found.
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