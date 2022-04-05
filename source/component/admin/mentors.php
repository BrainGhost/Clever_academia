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
            Mentors management
        </h2>
        <span class="openModalBtn">
            <i class="fa fa-comments text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <div class="search flex justify-end">
            <div class=" w-96 my-2">
                <div class="flex items-center">
                    <label for="" class="block text-teal-700 text-sm px-2"> Search </label>
                    <input type="text" placeholder="Search mentors" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " >
                </div>
            </div> 
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white">
            <table id="example" class="w-full">
				<thead class="bg-teal-600 border-b">
					<tr class="text-sm font-medium text-teal-50 text-left">
						<th data-priority="1">Mentor ID</th>
                        <th data-priority="2">Mentor name</th>
						<th data-priority="3">Email address</th>
                        <th data-priority="4">Mentor phone No.</th>
                        <th data-priority="5">Mentor speciality</th>
						<th data-priority="6">Speciality</th>
						<th data-priority="7">Status</th>
						<th data-priority="8">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php
                        //Display data into the table 
                        $sql  = "SELECT * FROM mentors;";
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
                                    <td>".$row['mentor_id']."</td>
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
             <!-- Start Modal -->
        <!-- ===========================================INSERT DATA INTO THE DB==================================================== -->   
        <div class="modalOpen fade hidden absolute left-1/2 top-4 -translate-x-1/2 w-[700px] mx-auto h-[440px] outline-none overflow-x-hidden overflow-y-auto scrollbar-hi20 hover:bg-opacity-50 z-50 shadow-2xl"
        id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog relative w-auto pointer-events-none  ">
                    <div
                    class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none">
                        <div
                            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-2xl font-medium leading-normal text-gray-600">Mentor requests</h5>
                            <button type="button"
                            class="btn-close box-content w-6 h-6 p-1  text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                            data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times text-xl"></i>
                            </button>
                        </div>
                        <div class="modal-body relative p-4 text-gray-600 bg-white">
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            <div class="rounded flex bg-gray-50 bg-opacity-20 hover:bg-opacity-50 mb-3 shadow hover:shadow-lg cursor-pointer">
                                <div class=" flex flex-1 p-2">
                                    <div class="avatar w-14 h-14 bg-white rounded-full overflow-hidden">
                                        <img src="../../images/looking-at-phone.png" class="w-full h-full object-contain">
                                    </div>
                                    <div class="details flex-1 ml-3 overflow-hidden">
                                        <a class="font-medium text-gray-800">Junior balibonera</a>
                                        <div class="text-opacity-80 w-4/5 truncate mt-0.5 text-gray-800">Lorem ipsum dolor sit amet, consectetur adipisicing elit....</div>
                                    </div>   
                                    <div class="times text-gray-800 uppercase">
                                        <span>11:30 am</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 ml-4 bg-slate-100 shadow-[-5px_0_18px_-12px_rgba(0,0,0,0.3)]">
                                    <div class="rounded-full px-3 py-2 bg-sky-300 hover:bg-sky-400"><span><i class="text-sky-700 fa fa-check text-xl"></i></span></div>
                                    <div class="rounded-full px-3 py-2 bg-red-300 hover:bg-red-400 ml-2"><span><i class="text-red-700 fa fa-times text-xl"></i></span></div>
                                </div>   
                            </div>
                            
                            
                        </div>
                        
                    </div>
            </div>
        </div>
</div>

<!-- End Modal -->

<?php
    include './asset/Footer.php'
?>