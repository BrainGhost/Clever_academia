
<?php
    include './asset/Header.php'
?>

<!--Overlay Effect-->
<div
	class="absolute hidden inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-20"
	id="my-modal"
></div>

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
                <input type="text" placeholder="" class="bg-slate-100 text-gray-600 block w-full mr-2 px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " >
                <input type="text" placeholder="" class="bg-slate-100 text-gray-600 block w-full mr-2 px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " >
                <span class="bg-teal-600 grid place-items-center rounded hover:bg-teal-700 transition duration-150 ease-in-out">
                    <i class="fa fa-search px-2 text-white  cursor-pointer text-lg" aria-hidden="true"></i>
                </span>
            </div>
            
        </div>
        <div class="search flex justify-end mx-2">
            <div class=" w-96 mt-8 my-2">
                <div class="flex items-center">
                    <label for="" class="block text-gray-700 text-sm px-2"> Search </label>
                    <input type="text" placeholder="" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " >
                </div>
            </div> 
        </div>
        <div id='recipients' class="overflow-hidden ">
            <table id="example" class="min-w-full " style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
				<thead class="bg-teal-600 border-b">
					<tr class="text-sm font-medium text-teal-50 text-left">
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
                    <tr class=" border-b  hover:bg-teal-50 ">
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>
                            <button class="px-2 py-1 rounded bg-emerald-400 text-white">
                                Completed
                            </button>
                        </td>
                        <td>
                            <span class="openModalBtn text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
                                <i class="fa fa-eye  cursor-pointer text-lg" aria-hidden="true"></i>
                            </span>
                        </td>
                    </tr>
                    <tr class=" border-b  hover:bg-teal-50 ">
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>
                            <button class="px-2 py-1 rounded bg-yellow-400 text-white">
                                Booked
                            </button>
                        </td>
                        <td>
                            <span class="openModalBtn text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
                                <i class="fa fa-eye  cursor-pointer text-lg" aria-hidden="true"></i>
                            </span>
                        </td>
                    </tr>
                    <tr class=" border-b  hover:bg-teal-50 ">
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>
                            <button class="px-2 py-1 rounded bg-red-400 text-white">
                                Cancel
                            </button>
                        </td>
                        <td>
                            <span class="openModalBtn text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
                                <i class="fa fa-eye  cursor-pointer text-lg" aria-hidden="true"></i>
                            </span>
                        </td>
                    </tr>
                    <tr class=" border-b  hover:bg-teal-50 ">
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>
                            <button class="px-2 py-1 rounded bg-sky-400 text-white">
                                In progress
                            </button>
                        </td>
                        <td>
                            <span class="openModalBtn text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
                                <i class="fa fa-eye  cursor-pointer text-lg" aria-hidden="true"></i>
                            </span>
                        </td>
                    </tr>
                    
				</tbody>

			</table>
		</div>
    </div>
    
    <div class="modalOpen fade hidden absolute left-1/2 top-10 -translate-x-1/2 w-[700px] mx-auto h-auto outline-none overflow-x-hidden overflow-y-auto z-30"
    id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="input-group flex text-gray-600 w-full rounded py-2">
                            <div class="input-group-prepend bg-gray-100 py-2 px-3 text-base">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="" name="doctor_schedule_date" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " required readonly /> 
                        </div>
                    </div>
                    <div class="form-group">
		          		<label class="text-base">Start Time</label>
                        <div class="input-group flex text-gray-600 w-full rounded py-2">
                            <div class="input-group-prepend input-group-prepend bg-gray-100 py-2 px-3 text-base">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                            </div>
		          		    <input type="text" name="doctor_schedule_start_time" id="doctor_schedule_start_time" class="form-control datetimepicker-input text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " data-toggle="datetimepicker" data-target="#doctor_schedule_start_time" required onkeydown="return false" onpaste="return false;" ondrop="return false;" autocomplete="off" />
                        </div>
		          	</div>
                    <div class="form-group">
                        <label class="text-base">End Time</label>
                        <div class="input-group input-group flex text-gray-600 w-full rounded py-2">
                            <div class="input-group-prepend input-group-prepend bg-gray-100 py-2 px-3 text-base">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                            </div>
                            <input type="text" name="doctor_schedule_end_time" id="doctor_schedule_end_time" class="form-control datetimepicker-input text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " data-toggle="datetimepicker" data-target="#doctor_schedule_end_time" required onkeydown="return false" onpaste="return false;" ondrop="return false;" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-base">Average Consulting Time</label>
                        <div class="input-group input-group input-group flex text-gray-600 w-full rounded py-2">
                            <div class="input-group-prepend bg-gray-100 py-2 px-3 text-base">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                            </div>
                            <select name="average_consulting_time" id="average_consulting_time" class="bg-white form-control text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded" required>
                                <option value="">Select Consulting Duration</option>
                                <?php
                                $count = 0;
                                for($i = 1; $i <= 15; $i++)
                                {
                                    $count += 5;
                                    echo '<option value="'.$count.'">'.$count.' Minute</option>';
                                }
                                ?>
                            </select>
                        </div>
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

                    <button type="button" class="px-6
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
        </div>
    </div>
</div>


<!-- Modal -->

<?php
    include './asset/Footer.php'
?>