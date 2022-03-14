
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
                            <span class=" text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
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
                            <span class=" text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
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
                            <span class=" text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
                                <i class="fa fa-eye  cursor-pointer text-lg" aria-hidden="true"></i>
                            </span>
                        </td>
                    </tr>
                    
				</tbody>

			</table>
		</div>
    </div>


<?php
    include './asset/Footer.php'
?>