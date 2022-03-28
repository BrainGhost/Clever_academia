<?php
    //include config file
    include("../../php/config.php");
    //import the Header
    include './asset/Header.php';
    

    //define variables and initialize with empty values
    $fullname = $email = $password = $address = $phonenumber = $dateofbirth = $speciality = $degree = $image = $address =  "";
    $fullname_err = $email_err = $password_err = $phonenumber_err = $dateofbirth_err = $speciality_err = $degree_err = $address_err = $insert_msg = $alert_notification = $status_insert = "";


    //Processing form data when submitted
    if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["save_doctor"])) {
        # validation of inputs field

        //validate name
        if (empty($_POST['fullname'])) {
            $fullname_err = "Please enter a fullname.";
        }else {
            $fullname = trim($_POST['fullname']);
        }
        //validate email
        if (empty($_POST['email'])) {
            $email_err = "Please enter an email.";
            // check if e-mail address is well-formed
        }
        // elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     $email_err = "Invalid email format";
        // }
        else {
            // check if e-mail address already exist
            $sql = "SELECT doctor_id FROM doctors WHERE email = ?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                # Bind variable to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                #set parameters
                $param_email = trim($_POST['email']);
                #atempt to execute the parameter
                if (mysqli_stmt_execute($stmt)) {
                    # store result
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $email_err = "This email is already in the system.";
                    }else{
                        $email = trim($_POST['email']);
                    }
                }else {
                    echo "Oops!! something went wrong. please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
             
        }
        //validate password
        if (empty($_POST['password'])) {
            $password_err = "Please enter a password.";
            
        }elseif (strlen($_POST['password']) < 6) {
            $password_err = "Please the password must be atleast 6 characters.";
        }else {
            $password = trim($_POST['password']);
        }
        //validate address
        if (empty($_POST['address'])) {
            $address_err = "Please enter an address.";
        }else {
            $address = trim($_POST['address']);
        }
        //validate phone number
        if (empty(trim($_POST['phonenumber']))) {
            $phonenumber_err = "Please enter a phone number. ";
        }else {
            $phonenumber = trim($_POST['phonenumber']);
        }
        
        // if (!preg_match("/^[+]?[1-9][0-9]{9,14}$/", $_POST['password'])) {
        //     $phonenumber_err = "Phone number not valid.";
        // }
        // strlen($_POST['password']) < 10 || strlen($_POST['password']) > 15 
        //validate date of birth
        if (empty($_POST['dateofbirth'])) {
            $dateofbirth_err = "Please enter a data of birth.";
        }else {
            $dateofbirth = date("Y-m-d", strtotime(trim($_POST['dateofbirth']))) ;
        }
        //validate speciality
        if (empty($_POST['speciality'])) {
            $speciality_err = "Please enter your speciality.";
        }else {
            $speciality= trim($_POST['speciality']);
        }
        //validate degree
        if (empty($_POST['degree'])) {
            $degree_err = "Please enter a degree";
        }else {
            $degree = trim($_POST['degree']);
        }
        

         

        #Confirm if there is no error before preceddding
        if (empty($fullname_err) && empty($email_err) && empty($password_err) && empty($phonenumber_err) && empty($dateofbirth_err) && empty($speciality_err) && empty($degree_err) ) {
            #image upload
            
            $photoImageName = time() .'_'. $_FILES["photoImage"]["name"];
            $photo_tmp_name = $_FILES["photoImage"]["tmp_name"];
            $target_location = '../../images/' . $photoImageName;
            
            
            // # prepare insert data in the database
            $sql = "INSERT INTO doctors(fullname, email, password, level, address, phone_number, date_of_birth, speciality, degree, image, doctor_status) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                # Bind variable to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssssssss", $param_fullname , $param_email , $param_password, $param_level, $param_address , $param_phonenumber , $param_dateofbirth , $param_speciality , $param_degree , $param_image, $param_status );

                # Set the parameters values and execute the statement to insert row
                $param_fullname = $fullname; 
                $param_email = $email; 
                $param_password= password_hash($password, PASSWORD_DEFAULT); //Creates password hash
                $param_level= 'counselor';
                $param_address = $address; 
                $param_phonenumber = $phonenumber; 
                $param_dateofbirth = $dateofbirth; 
                $param_speciality =$speciality; 
                $param_degree = $degree;
                $param_image = $photoImageName;
                $param_status = 0;

                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    #insert the username and password to the credential talle 
                    $sql = "INSERT INTO credentials(username, email, password, profile, level) VALUES ('$param_fullname ','$param_email','$param_password', '$param_image','counselor')";
                    $result = mysqli_query($link, $sql);
                    if ($result) {
                        move_uploaded_file($photo_tmp_name, $target_location);
                        $insert_msg = "Record inserted successfully.";
                        $alert_notification = "success";
                    }else{
                        echo '<script type="text/javascript"> alert("FAILED!! Not inserted")</script>';
                    }
                    
                } else{
                    $insert_msg = "Records not saved.";
                }
                //close statement
                mysqli_stmt_close($stmt);
     
            }else {
                echo "ERROR: Could not prepare query: $sql. " .mysqli_error($link);
            }
            

        }
        

        
    }

    

?>
<!--Overlay Effect-->
<div
	class="absolute hidden inset-0 bg-gray-600 bg-opacity-60 overflow-y-auto h-full w-full z-20"
	id="my-modal"
></div>
<!-- Remove everything INSIDE this div to a really blank page -->
<!-- CONFIRMATION ACTIVATE ACCOUNT-->


<!-- NOTIFICATION ALERTS -->
<?php
    
    if ($_SESSION['insert_msg'] !== "") {
        $action = "";
        if (isset($_POST['delete'])) {
            $action = "delete";
        } elseif (isset($_POST['update_doctor'])) {
            $action = "update";
        } elseif (isset($_POST['save_doctor'])) {
            $action = "success";
        }

        switch ($action) {
            case 'success':
                $alert_msg = "Success";
                $alert_div_color = 'bg-emerald-100 border-emerald-500 text-emerald-700';
                $alert_btn_color = 'bg-emerald-200 text-emerald-700';
                break;
                
            case 'update':
                $alert_msg = "Update";
                $alert_div_color = 'bg-sky-100 border-sky-500 text-sky-700';
                $alert_btn_color = 'bg-sky-200 text-sky-700';
                break;

            case 'delete':
                $alert_msg = "Delete";
                $alert_div_color = 'bg-red-100 border-red-500 text-red-700';
                $alert_btn_color = 'bg-red-200 text-red-700';
                break;
                
            default:
                $alert_msg = "Be Warned";
                $alert_div_color = 'bg-orange-100 border-orange-500 text-orange-700';
                $alert_btn_color = 'bg-orange-200 text-orange-700';
                break;
        }
      
?>

    <div class="p-4 rounded px-4 py-3 absolute <?php echo ($insert_msg || $_SESSION['insert_msg']) ? "top-7 flex" : "top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 <?php echo $alert_div_color;?> " role="alert">
        <strong class="font-bold"><?php echo $alert_msg; ?>! &nbsp;</strong>
        <span class="block sm:inline mr-12"><?php echo  $insert_msg ? $insert_msg : $_SESSION['insert_msg'] ; ?></span>
        <span onclick="closeNFT(this); <?php $_SESSION['insert_msg'] = null; ?>" class="absolute top-0 bottom-0 right-0 px-3 py-3 <?php echo $alert_btn_color;?> cursor-pointer">
            <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
        </span>
    </div>

<?php     
    }
?>

<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Counselor management
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
                    <input type="text" placeholder="" class="text-gray-600 block w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " >
                </div>
            </div> 
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white">
            <table id="example" class="w-full">
				<thead class="bg-teal-600 border-b">
					<tr class="text-sm font-medium text-teal-50 text-left">
						<th data-priority="1">Doctor ID</th>
						<th data-priority="2">Profile</th>
                        <th data-priority="3">Doctor name</th>
						<th data-priority="4">Email address</th>
                        <th data-priority="5">Doctor phone No.</th>
                        <th data-priority="6">Doctor speciality</th>
						<th data-priority="7">Speciality</th>
						<th data-priority="8">Status</th>
						<th data-priority="9">Action</th>
					</tr>
				</thead>
				<tbody>
                    <?php
                        //Display data into the table 
                        $sql  = "SELECT * FROM doctors;";
                        $result = mysqli_query($link, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        
                        if ($resultCheck > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {         
                                $status = $row['doctor_status'];    
                                if ($row['doctor_status'] == 1 ) {
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['doctor_id'].",".$status.");' type='button' name='change_status' value='Active' class='px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>Active</a>";
                                }else{
                                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['doctor_id'].",".$status.");' type='button' name='change_status' value='Inactive' class='px-4 py-1 border border-red-500 bg-red-50 rounded  hover:bg-red-100 text-red-500 font-medium'>Inactive</a>"; 
                                }
                                ?>

                                <tr class='display_image bg-white border-b transition duration-300 ease-in-out hover:bg-teal-50 text-sm text-gray-900 font-light'>
                                    <td><?php echo $row['doctor_id'] ?></td>
                                    <td><img src="<?php echo "../../images/".$row['image']; ?>" alt="Image" class="w-20 h-20"></td>
                                    <td><?php echo $row['fullname'] ;?></td>
                                    <td><?php echo $row['email'] ;?></td>
                                    <td><?php echo $row['phone_number'] ?></td>
                                    <td><?php echo $row['address'] ?></td>
                                    <td><?php echo $row['speciality'] ?></td>
                                    <td><?php echo $status_insert ?></td>
                                    <td>
                                        <div class='flex items-center space-x-4'>
                                            <a title='View record' href=' <?php echo "./view_doctor.php?viewId=".$row['doctor_id']."";?>' class='text-sky-400 grid place-items-center rounded-full hover:text-sky-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-eye  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                            <a title='Update record' href='javascript:displayModal("<?php echo $row['doctor_id']; ?>");'   class='text-yellow-400 grid place-items-center rounded-full hover:text-yellow-500 transition duration-150 ease-in-out'>
                                                <i class='fa fa-pencil  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                            
                                            <a title='Delete record' href='./doctor_action.php?deletedid="<?php echo $row['doctor_id']; ?>" && deletedemail="<?php echo $row['email']; ?>"'  class='text-red-400 grid place-items-center rounded-full hover:text-red-500 transition duration-150 ease-in-out'>  
                                                <i class='fa fa-trash  cursor-pointer text-lg' aria-hidden='true'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                
                            <?php     
                            }
                            mysqli_free_result($result);
                        }else{
                            echo
                            "
                            <tr class='bg-teal-50 border border-teal-100 border-t-0 text-sm text-teal-900 font-semibold text-center'>
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
    <!-- =================================================UPDATE DATA INTO THE DB==================================================== -->
   
    <div class="modalOpen_update fade hidden absolute left-1/2 top-4 -translate-x-1/2 w-[700px] mx-auto h-auto outline-none overflow-x-hidden overflow-y-auto z-50 shadow-2xl"
    id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog relative w-auto pointer-events-none  ">
            <form action="./doctor_action.php" method="post" enctype="multipart/form-data">
                <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none">
                    <div
                        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-2xl font-medium leading-normal text-gray-600">Update Counselor details</h5>
                        <button type="button"
                        class="btn-close-update box-content w-6 h-6 p-1  text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times text-xl"></i>
                        </button>
                    </div>
                    <div id="modalIMP">
                        <input id="updateID" type="hidden" name="update_id">
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
                                        <input id="file-select" type="file" name="photoImager" onchange="displayImage(this)" placeholder="Choose file" class="block w-full text-sm text-gray-500
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
                                        <img id="imageDisplayer"  src="../../images/placeholder.png" class="w-full h-full object-cover border-0">
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!--  -->
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <button name="reset_doctor" type="reset" class="px-6 py-2.5 text-teal-700 border-gray-300 font-medium
                        btn-close-update
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

                        <button name="update_doctor" type="submit" class="px-6
                        py-2.5
                        bg-teal-400
                        text-white
                        font-medium
                        text-xs
                        leading-tight
                        uppercase
                        rounded
                        shadow-md
                        hover:bg-teal-500 hover:shadow-lg
                        focus:bg-teal-500 focus:shadow-lg focus:outline-none focus:ring-0
                        active:bg-teal-600 active:shadow-lg
                        transition
                        duration-150
                        ease-in-out
                        ml-1">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    

</div>
<!-- End Modal -->
<!-- ================================CHANGE FROM ACTIVE TO INACTIVE WITH A MODAL====================================== -->
<!-- CONFIRMATION INACTIVE -> ACTIVE ACCOUNT-->

    <div id="confirm-delete-modal" class="hidden fixed z-20 inset-0 overflow-y-auto " aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div id="confirm-delete-modal-close" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <!-- <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span> -->
            
                <div class="inline-block relative align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-text-50">

                   <form method="POST" action="./action/update.php">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 ">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 bg-teal-100  sm:h-10 sm:w-10">
                                    <!-- Heroicon name: outline/exclamation -->
                                    <svg class="h-6 w-6 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div id="modalSTATUS">
                                    <input id="updateSTATUS" type="hidden" name="updateSTATUS_id">
                                    <input id="updateSTATUS_TEXT" type="hidden" name="updateSTATUS_TEXT">
                                    
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    
                                    <h3 class="text-lg leading-6 font-medium text-teal-900" id="modal-title">Change account status</h3>
                                    <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to do this? this will disable +this user credentials+ and who be able to connect or login.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" name="update_status" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-5 py-2 bg-teal-500 text-base font-medium text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">Change Status</button>
                            <a href="./doctors.php" class="mt-3 w-full inline-flex justify-center rounded-md border border-teal-300 shadow-sm px-5 py-2 bg-white text-base font-medium text-teal-600 hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">  
                                Cancel
                            </a>    
                        </div>
                    </form>
                </div>  
        </div>
    </div>
<?php
    include './asset/Footer.php'
?>