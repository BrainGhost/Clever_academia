<?php
    include("../../php/config.php");
    include './asset/Header.php'
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
        <span class="openModalBtn">
            <i class="fa fa-user-plus text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <div class="search flex justify-end">
            <div class=" w-96 my-2">
                <div class="flex items-center">
                    <label for="" class="block text-teal-700 text-sm px-2"> Search </label>
                    <input type="text" placeholder="Search students" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " >
                </div>
            </div> 
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white">
            <table id="example" class="w-full">
				<thead class="bg-teal-600 border-b">
					<tr class="text-sm font-medium text-teal-50 text-left">
						<th data-priority="1">student ID</th>
                        <th data-priority="2">student name</th>
						<th data-priority="3">Email address</th>
                        <th data-priority="4">student phone No.</th>
                        <th data-priority="5">student speciality</th>
						<th data-priority="6">Speciality</th>
						<th data-priority="7">Status</th>
						<th data-priority="8">Action</th>
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
                                if ($row['doctor_status'] == 1 ) {
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['doctor_id'].",".$status.");' type='button' name='change_status' value='Active' class='px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>Active</a>";
                                }else{
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['doctor_id'].",".$status.");' type='button' name='change_status' value='Inactive' class='px-4 py-1 border border-red-500 bg-red-50 rounded  hover:bg-red-100 text-red-500 font-medium'>Inactive</a>"; 
                                }
                                echo 
                                "
                                <tr class='bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light'>
                                    <td>".$row['student_id']."</td>
                                    <td>".$row['fullname']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['phone_number']."</td>
                                    <td>".$row['address']."</td>
                                    <td>".$row['speciality']."</td>
                                    <td>$status_insert</td>
            
                                    <td>
                                        <div class='flex items-center space-x-4'>
                                            <a title='View record' href='./action/read.php?viewid=".$row['student_id']."' class='text-sky-400 grid place-items-center rounded-full hover:text-sky-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-eye  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                            <a title='Update record' href='javascript:displayModal(".$row['student_id'].");'   class='text-yellow-400 grid place-items-center rounded-full hover:text-yellow-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-pencil  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                            
                                            <a title='Delete record' href='./doctor_action.php?deletedid=".$row['student_id']."'  class='text-red-400 grid place-items-center rounded-full hover:text-red-500 transition duration-150 ease-in-out'>  
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
                                    No students records were found.
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
        <!-- Start Modal -->
    <!-- =================================================INSERT DATA INTO THE DB==================================================== -->   
    <div class="modalOpen fade hidden absolute left-1/2 top-4 -translate-x-1/2 w-[700px] mx-auto h-auto outline-none overflow-x-hidden overflow-y-auto z-50 shadow-2xl"
    id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog relative w-auto pointer-events-none  ">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
                <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none">
                    <div
                        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-2xl font-medium leading-normal text-gray-600">Add Counselor</h5>
                        <button type="button"
                        class="btn-close box-content w-6 h-6 p-1  text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="modal-body relative p-4 text-gray-600">
                        <div class="row grid md:grid-cols-2 gap-4 ">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Email address</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="email" value="<?php echo $email; ?>" name="email" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Password</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="password" value="<?php echo $password; ?>" name="password" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $password_err; ?></span>
                            </div>
                        </div>
                        <div class="row grid md:grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Full name</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $fullname; ?>" name="fullname" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $fullname_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Phone No.</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="tel" value="<?php echo $phonenumber; ?>" name="phonenumber" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $phonenumber_err; ?></span>
                            </div>
                        </div>
                        <div class="row grid md:grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="text-sm font-medium">Address</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $address; ?>" name="address" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $address_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium ">Date of birth</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="date" value="<?php echo $dateofbirth; ?>" name="dateofbirth" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded cursor-pointer bg-teal-50"     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $dateofbirth_err; ?></span>
                            </div>
                        </div>
                        <div class="row grid md:grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Degree</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $degree; ?>" name="degree" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $degree_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Speciality</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $speciality; ?>" name="speciality" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $speciality_err; ?></span>
                            </div>
                        </div>
                        <div class="row grid md:grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Image</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <label for="file-select" class="block">
                                        <span class="sr-only">Choose profile image</span>
                                        <input id="file-select" type="file" name="photoImage" onchange="displayImage(this)" placeholder="Choose file" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-xs file:font-semibold
                                        file:bg-teal-50 file:text-teal-700
                                        hover:file:bg-teal-100
                                        hover:cursor-pointer
                                        "/>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group w-full">
                                <div class="border-2 border-white cursor-pointer rounded-full outline outline-2 outline-gray-100 w-40 h-40 overflow-hidden bg-teal-50">
                                    <label for="file-select">
                                        <img id="imageDisplay"  src="../../images/placeholder.png" class="w-full h-full object-cover border-0">
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!--  -->
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <button name="reset_doctor" type="reset" class="px-6 py-2.5 text-teal-700 border-gray-300 font-medium
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

                        <button type="submit" name="save_doctor" class="px-6
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
                        ml-1">add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End Modal -->

<?php
    include './asset/Footer.php'
?>