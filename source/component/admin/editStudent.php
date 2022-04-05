<?php
    include("../../php/config.php");
    include('./asset/Header.php');

    


    //define variables and initialize with empty values
    $firstname = $lastname = $gender = $email = $dateofbirth = $department = $course = $address = $phonenumber = $registration = $graduation = "";
    $firstname_err = $lastname_err = $gender_err = $email_err = $dateofbirth_err = $department_err = $course_err = $address_err = $phonenumber_err = $registration_err = $graduation_err = "";

    #############################################
    // change the timezone from berlin to kenya/nairobi
    date_default_timezone_set("Africa/Nairobi");
    

    # Insert resources into the DB
    
    if(isset($_POST["add_student"])){
        //validate name
        if (empty($_POST['firstname'])) {
            $firstname_err = "Enter the first name.";
        }else {
            $firstname = trim($_POST['firstname']);
        }
        if (empty($_POST['lastname'])) {
            $lastname_err = "Enter the last name.";
        }else {
            $lastname = trim($_POST['lastname']);
        }

        //Email validation
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
            $sql = "SELECT student_id FROM students WHERE email = ?";
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
        // Gender
        if (empty($_POST['gender'])) {
            $gender_err = "Select gender.";
        }else {
            $gender = trim($_POST['gender']);
        }
        //phone number
        if (empty($_POST['phonenumber'])) {
            $phonenumber_err = "Select phone number.";
        }else {
            $phonenumber = trim($_POST['phonenumber']);
        }
        //validate date of birth
        if (empty($_POST['dateofbirth'])) {
            $dateofbirth_err = "Please enter a data of birth.";
        }else {
            $dateofbirth = date("Y-m-d", strtotime(trim($_POST['dateofbirth']))) ;
        }
        //registration date
        if (empty($_POST['registration'])) {
            $registration_err = "Please enter the date of registration.";
        }elseif (trim($_POST['registration']) >= date("Y")) {
            # check if the date inserted is > to the current data
            $registration_err = "Invalid year.";
        }else {
            $registration = trim($_POST['registration']);
            $graduation = trim($_POST['registration']) ; #+ add 4 years ;
        }
        //address location
        if (empty($_POST['address'])) {
            $address_err = "Enter your address location.";
        }else {
            $address = trim($_POST['address']);
        }
        //Department
        if (empty($_POST['department'])) {
            $department_err = "Enter your department.";
        }else {
            $department = trim($_POST['department']);
        }
        //Course
        if (empty($_POST['course'])) {
            $course_err = "Enter your course.";
        }else {
            $course = trim($_POST['course']);
        }

        
        ######

        if (empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($gender_err) && empty($department_err) && empty($course_err) && empty($registration_err)) {
            # file upload [pdf, word, img]
            # upload file, [PDF, WORD, PNG and JPEG] ==================START======================
            $fileName = $_FILES['profile_image']['name'];
            $fileTmpName = $_FILES['profile_image']['tmp_name'];
            $fileSize = $_FILES['profile_image']['size'];
            $fileType = $_FILES['profile_image']['type'];
            $fileError = $_FILES['profile_image']['error'];

            $fileExt = explode('.', $fileName);
            
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png');

            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 2000000) { //no more than 2mb = 2.000.000
                        $fileNameNew = $firstname.'_'.time().'.'.$fileActualExt;
                        $fileDestination = '../../images/'.$fileNameNew;
                        $fileStored = move_uploaded_file($fileTmpName, $fileDestination);
                        if ($fileStored === true ) {
                            $file = $fileNameNew;
                        }else{
                            echo "The profile was not uploaded to the DB";
                        }
                    }else{
                        echo "Your profile is too large."; 
                    }
                }else{
                    echo "There were an error uploading this profile.";
                }
            }else{
                echo "you can not upload profile of this type.";
            }
        # =========================================END================================================
            #status = approve, processing, denied
            #sql
            $sql = "INSERT INTO students(firstname, lastname, gender, email, phone_number, date_of_birth, department, major, registration_year, graduation_year, profile, level, address, has_account, student_status) 
                                VALUES ('$firstname','$lastname','$gender','$email','$phonenumber','$dateofbirth', '$department','$course','$registration','$graduation', '$file', 'standard','$address', 0, 1)";
            $result = mysqli_query($link, $sql);
            if($result){
                $_SESSION['insert_msg'] = "Student inserted successfully.";
                $_SESSION['alert_notification_resources'] = 'success';
                // header("location: ./students.php");
                
            }else{
                header("location: ./editStudent.php");
                $insert_msg = "Failed to insert Student.";
                mysqli_error($link);
            }
        }
    }
?>
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Student management
        </h2>
        <span class="">
            <i class="fa fa-user text-<?php echo $primary_color; ?>-600 hover:text-<?php echo $primary_color; ?>-700 text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <button class="new-resources">
            <a href='./students.php' type='button' name='upload-resource' value='upload' class='flex items-center px-4 py-1 border border-<?php echo $primary_color; ?>-500 bg-<?php echo $primary_color; ?>-50 rounded  hover:bg-<?php echo $primary_color; ?>-100 text-<?php echo $primary_color; ?>-500 font-medium'>
                close
                <i class="fa fa-times text-<?php echo $primary_color; ?>-600 text-xl ml-2" aria-hidden="true"></i>
            </a>
        </button>
    </div>
    <div class="form mt-4 lg:w-[900px] h-auto outline-none overflow-x-hidden overflow-y-auto z-50 shadow-xl"
    id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="relative w-auto pointer-events-none  ">
            <form method="post" enctype="multipart/form-data">
            <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none">
                    <div
                        class="hidden modal-header flex-shrink-0 items-center justify-center  p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-2xl font-medium leading-normal text-gray-600">Add student</h5>
                    </div>
                    <div class="modal-body relative p-4 text-gray-600">
                        <div class="row grid md:grid-cols-2 gap-4 ">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">First name</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $firstname; ?>" name="firstname" id="" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $firstname_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Last name</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $lastname; ?>" name="lastname" id="" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $lastname_err; ?></span>
                            </div>
                        </div>
                        <div class="row grid md:grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Email</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="email" value="<?php echo $email; ?>" name="email" id="" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Gender</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="radio" name="gender" value="Male" id="" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded "/>Male 
                                    <input type="radio" name="gender" value="Female" id="" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded "/>Female
                                </div>
                                <span class="text-xs text-red-500"><?php echo $gender_err; ?></span>
                            </div>
                        </div>
                        <div class="row grid md:grid-cols-2 gap-4 items-center">
                        <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium ">Date of birth</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="date" value="<?php echo $dateofbirth; ?>" name="dateofbirth" id="doctor_schedule_date" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded cursor-pointer bg-<?php echo $primary_color; ?>-50"     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $dateofbirth_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Phone No.</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="tel" value="<?php echo $phonenumber; ?>" name="phonenumber" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $phonenumber_err; ?></span>
                            </div> 
                        </div>
                        <div class="row grid md:grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="text-sm font-medium">Address</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $address; ?>" name="address" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $address_err; ?></span>
                            </div>
                            <div class="form-group w-full flex">
                                <div class="w-full">
                                    <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium ">Registration</label>
                                    <div class="input-group flex text-gray-600 w-full rounded py-2">
                                        <input type="number" min="2000" max="2050" maxlength="4" step="1" placeholder="<?php echo date("Y");?>"  name="registration" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded" /> 
                                    </div>
                                    <span class="text-xs text-red-500"><?php echo $registration_err; ?></span>
                                </div>
                                <div class="w-full ml-4 hidden">
                                    <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium ">Graduation</label>
                                    <div class="input-group flex text-gray-600 w-full rounded py-2">
                                        <input type="number" min="2000" max="2050" maxlength="4" step="1" placeholder="<?php echo date("Y");?>"  name="graduation" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded" /> 
                                    </div>
                                    <span class="text-xs text-red-500"><?php echo $graduation_err; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row grid md:grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Department</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $department; ?>" name="department" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $department_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Course</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $course; ?>" name="course" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-<?php echo $primary_color; ?>-400 focus:outline-none border border-gray-200 rounded "     /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $course_err; ?></span>
                            </div>
                        </div>
                        <div class="row grid md:grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Profile</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <label for="file-select" class="block">
                                        <span class="sr-only">Choose profile image</span>
                                        <input id="file-select" type="file" name="profile_image" onchange="displayImage(this)" placeholder="Choose file" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-xs file:font-semibold
                                        file:bg-<?php echo $primary_color; ?>-50 file:text-<?php echo $primary_color; ?>-700
                                        hover:file:bg-<?php echo $primary_color; ?>-100
                                        hover:cursor-pointer
                                        "/>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group w-full">
                                <div class="border-2 border-white cursor-pointer rounded-full outline outline-2 outline-gray-100 w-40 h-40 overflow-hidden bg-<?php echo $primary_color; ?>-50">
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
                        <a href="./students.php" name="cancel" class="px-10 py-3 text-<?php echo $primary_color; ?>-700 border-gray-300 font-medium
                        -close
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
                        ease-in-out">Cancel</a>

                        <button type="submit" name="add_student" class="px-10
                        py-3
                        bg-<?php echo $primary_color; ?>-600
                        text-white
                        font-medium
                        text-xs
                        leading-tight
                        uppercase
                        rounded
                        shadow-md
                        hover:bg-<?php echo $primary_color; ?>-700 hover:shadow-lg
                        focus:bg-<?php echo $primary_color; ?>-700 focus:shadow-lg focus:outline-none focus:ring-0
                        active:bg-<?php echo $primary_color; ?>-800 active:shadow-lg
                        transition
                        duration-150
                        ease-in-out
                        ml-1">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
    include './asset/Footer.php'
?>