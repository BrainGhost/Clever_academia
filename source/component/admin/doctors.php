
<?php
    //import the Header
    include './asset/Header.php';
    //include config file
    require_once("../../php/config.php");

    //define variables and initialize with empty values
    $fullname = $email = $password = $address = $phonenumber = $dateofbirth = $speciality = $degree = $image = "";
    $fullname_err = $email_err = $password_err = $phonenumber_err = $dateofbirth_err = $speciality_err = $degree_err = $image_err = $insert_msg = "";

    //Processing form data when submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        # validation of inputs field

        #email validation



        #Confirm if there is no error before preceddding
        if (empty($fullname_err) && empty($email_err) && empty($password_err) && empty($phonenumber_err) && empty($dateofbirth_err) && empty($speciality_err) && empty($degree_err) && empty($image_err )) {
            # prepare insert data in the database
             
            $sql = "INSERT INTO doctors(fullname, email, password, level, address, phone_number, date_of_birth, speciality, degree, image) VALUES (?,?,?,?,?,?,?,?,?,?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                # Bind variable to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssssssb", $param_fullname , $param_email , $param_password, $param_level, $param_address , $param_phonenumber , $param_dateofbirth , $param_speciality , $param_degree , $param_image );

                # Set the parameters values and execute the statement to insert row
                $param_fullname = $_POST['fullname']; 
                $param_email = $_POST['email']; 
                $param_password= password_hash($_POST['password'], PASSWORD_DEFAULT); //Creates password hash
                $param_level= 'counselor';
                $param_address = $_POST['address']; 
                $param_phonenumber = $_POST['phonenumber']; 
                $param_dateofbirth = $_POST['dateofbirth']; 
                $param_speciality = $_POST['speciality']; 
                $param_degree = $_POST['degree']; 
                $param_image = "image_bo";

                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    $insert_msg = "Records inserted successfully.";
                } else{
                    echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
                }
                //close statement
                mysqli_stmt_close($stmt);
     
            }else {
                echo "ERROR: Could not prepare query: $sql. " .mysqli_error($link);
            }

        }
        #close connection
        mysqli_close($link);
    }
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
            Counselor management
        </h2>
        <span class="openModalBtn">
            <i class="fa fa-user-plus text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
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
            <table id="example" class="min-w-full " style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
				<thead class="bg-teal-600 border-b">
					<tr class="text-sm font-medium text-teal-50 text-left">
						<th data-priority="1">Image</th>
						<th data-priority="2">Email address</th>
						<th data-priority="3">Password</th>
						<th data-priority="4">Doctor name</th>
						<th data-priority="5">Doctor phone No.</th>
						<th data-priority="6">Doctor speciality</th>
						<th data-priority="6">Status</th>
						<th data-priority="7">Action</th>
					</tr>
				</thead>
				<tbody>
                    <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light">
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                        <td>
                            <button class="px-2 py-1 rounded bg-sky-400 text-white">
                                Active
                            </button>
                            <button class="hidden px-2 py-1 rounded bg-red-400 text-white">
                                Inactive
                            </button>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <span class=" text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
                                    <i class="fa fa-eye  cursor-pointer text-lg" aria-hidden="true"></i>
                                </span>
                                <span class=" text-yellow-600 grid place-items-center rounded-full hover:text-yellow-700 px-3 transition duration-150 ease-in-out">
                                    <i class="fa fa-pencil  cursor-pointer text-lg" aria-hidden="true"></i>
                                </span>
                                <span class=" text-red-600 grid place-items-center rounded-full hover:text-red-700 transition duration-150 ease-in-out">
                                    <i class="fa fa-window-close  cursor-pointer text-xl" aria-hidden="true"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light">
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                        <td>
                            <button class="hidden px-2 py-1 rounded bg-sky-400 text-white">
                                Active
                            </button>
                            <button class=" px-2 py-1 rounded bg-red-400 text-white">
                                Inactive
                            </button>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <span class=" text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
                                    <i class="fa fa-eye  cursor-pointer text-lg" aria-hidden="true"></i>
                                </span>
                                <span class=" text-yellow-600 grid place-items-center rounded-full hover:text-yellow-700 px-3 transition duration-150 ease-in-out">
                                    <i class="fa fa-pencil  cursor-pointer text-lg" aria-hidden="true"></i>
                                </span>
                                <span class=" text-red-600 grid place-items-center rounded-full hover:text-red-700 transition duration-150 ease-in-out">
                                    <i class="fa fa-window-close  cursor-pointer text-xl" aria-hidden="true"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light">
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                        <td>
                            <button class="px-2 py-1 rounded bg-sky-400 text-white">
                                Active
                            </button>
                            <button class="hidden px-2 py-1 rounded bg-red-400 text-white">
                                Inactive
                            </button>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <span class=" text-sky-600 grid place-items-center rounded-full hover:text-sky-700 transition duration-150 ease-in-out">
                                    <i class="fa fa-eye  cursor-pointer text-lg" aria-hidden="true"></i>
                                </span>
                                <span class=" text-yellow-600 grid place-items-center rounded-full hover:text-yellow-700 px-3 transition duration-150 ease-in-out">
                                    <i class="fa fa-pencil  cursor-pointer text-lg" aria-hidden="true"></i>
                                </span>
                                <span class=" text-red-600 grid place-items-center rounded-full hover:text-red-700 transition duration-150 ease-in-out">
                                    <i class="fa fa-window-close  cursor-pointer text-xl" aria-hidden="true"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
				</tbody>

			</table>
		</div>
    </div>
 <!-- Start Modal -->   
    <div class="modalOpen fade hidden absolute left-1/2 top-4 -translate-x-1/2 w-[700px] mx-auto h-auto outline-none overflow-x-hidden overflow-y-auto z-30"
    id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog relative w-auto pointer-events-none  ">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
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
                        <div class="row grid grid-cols-2 gap-4 ">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Email address</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="email" name="email" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " required   /> 
                                </div>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Password</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="password" name="password" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " required   /> 
                                </div>
                            </div>
                        </div>
                        <div class="row grid grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Full name</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="" name="fullname" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " required   /> 
                                </div>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Phone No.</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" name="phonenumber" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " required   /> 
                                </div>
                            </div>
                        </div>
                        <div class="row grid grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="text-sm font-medium">Address</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="" name="address" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " required   /> 
                                </div>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Date of birth</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" name="dateofbirth" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " required   /> 
                                </div>
                            </div>
                        </div>
                        <div class="row grid grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Degree</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="" name="degree" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " required   /> 
                                </div>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Speciality</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="" name="speciality" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " required   /> 
                                </div>
                            </div>
                        </div>
                        <div class="row grid grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Image</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <label class="block">
                                        <span class="sr-only">Choose profile image</span>
                                        <input type="file" placeholder="Choose file" class="block w-full text-sm text-gray-500
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
                                <div class="border-2 border-white rounded outline outline-2 outline-teal-400 w-40 h-48 bg-teal-50">
                                    <img src="https://www.gameclimate.com/wp-content/uploads/2012/12/luigis_mansion_dark_moon_orange_brain_ghost-980x980.jpg" class="w-full h-full object-cover border-0">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <button type="reset" class="px-6 py-2.5 text-teal-700 border-gray-300 font-medium
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

                        <button type="submit" class="px-6
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