<?php
    include("../../php/config.php");
    include('./asset/Header.php');

    


    //define variables and initialize with empty values
    $group_name = $group_description = $group_max_number = $banner_image =  "";
    $group_name_err = $group_description_err = $group_max_number_err = $banner_image_err = $insert_msg_err = "";

    #############################################
    // change the timezone from berlin to kenya/nairobi
    date_default_timezone_set("Africa/Nairobi");
    

    # Insert resources into the DB
    #need to get the mentor id from the 

    $sql = "SELECT mentor.mentor_id,students.student_id
    FROM mentor
    INNER JOIN mentor_application ON mentor.application_id=mentor_application.application_id
    INNER JOIN students ON mentor_application.student_id=students.student_id
    WHERE students.student_id = $student_id";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $mentor_id = $row['mentor_id'];
    }
    
    if(isset($_POST["create_group"])){
        //validate name
        if (empty($_POST['group_name'])) {
            $group_name_err = "Please enter the name of the group.";
        }else {
            $group_name = trim($_POST['group_name']);
        }
        //validate maxnumber
        if (empty($_POST['group_max_number'])) {
            $group_max_number_err = "Please enter the name of the group.";
        }else {
            $group_max_number = trim($_POST['group_max_number']);
        }
        //description
        
        if (empty($_POST['group_description'])) {
            $group_description_err = "Please enter the description of the group..";
        }else {
            $group_description = trim($_POST['group_description']);    
        }
        
        #date of creation
        $created_on = date("Y-m-d");

        

        if (empty($group_name_err) && empty($group_description_err)) {
            # file upload [pdf, word, img]
            # upload file, [PDF, WORD, PNG and JPEG] ==================START======================
        $fileName = $_FILES['banner_image']['name'];
        $fileTmpName = $_FILES['banner_image']['tmp_name'];
        $fileSize = $_FILES['banner_image']['size'];
        $fileType = $_FILES['banner_image']['type'];
        $fileError = $_FILES['banner_image']['error'];

        $fileExt = explode('.', $fileName);
        
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 2000000) { //no more than 2mb = 2.000.000
                    $fileNameNew = $group_name.'-'.time().'.'.$fileActualExt;
                    $fileDestination = '../../resources/'.$fileNameNew;
                    $fileStored = move_uploaded_file($fileTmpName, $fileDestination);
                    if ($fileStored === true ) {
                        $banner_image = $fileNameNew;
                    }else{
                        echo "The file was not uploaded to the DB";
                    }
                }else{
                    echo "Your file is too large."; 
                }
            }else{
                echo "There were an error uploading this banner image.";
            }
        }else{
            echo "you can not upload file of this type.";
        }
        # =========================================END================================================
            #status = approve, processing, denied
            #sql
            $sql = "INSERT INTO study_group(group_name, group_description, total_people, created_on, banner_image, mentor_id) VALUES ('$group_name','$group_description','$group_max_number','$created_on','$banner_image','$mentor_id')";
            $result = mysqli_query($link, $sql);
            if($result){
                $_SESSION['insert_msg'] = "Group created successfully.";
                $_SESSION['alert_notification_resources'] = 'success';
                header("location: ./create_group.php");
                
            }else{
                header("location: ./uploadresources.php");
                $insert_msg = "Group creation failed .";
                mysqli_error($link);
            }
        }
    }
?>
<?php
    $sql = "SELECT * FROM study_group WHERE mentor_id = $mentor_id";
    $result = mysqli_query($link, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 5) {
        echo
        "
            <div class='bg-white text-teal-900 font-semibold text-center py-20'>
                <div class='flex justify-center'>
                    <h1 class='bg-teal-50 cursor-pointer shadow-md border border-emerald-200 rounded-md w-96 py-3 px-4'>You have reached you maximamun limits of groups you are allowed to create {5}</h1>
                </div>
            </div>
        ";
    }else{
        ?>
            <div class="student-container container px-6 mx-auto grid relative">
                <div class="flex items-center border-b">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
                        Your Groups
                    </h2>
                    <span class="">
                        <i class="fa fa-book text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="mt-2 w-full">
                    <button class="new-resources">
                        <a href='./create_group.php' name='upload-resource' value='upload' class='flex items-center px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>
                            close
                            <i class="fa fa-pencil text-teal-600 text-xl ml-2" aria-hidden="true"></i>
                        </a>
                    </button>
                </div>
                <div class="form mt-4 lg:w-[700px] h-auto outline-none overflow-x-hidden overflow-y-auto z-50 shadow-xl"
                id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="relative w-auto pointer-events-none  ">
                        <form method="post" enctype="multipart/form-data">
                            <div
                            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none">
                                <div
                                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                                    <h5 class="text-2xl font-medium text-center leading-normal text-gray-600">Create A group</h5>
                                    
                                </div>
                                <div class="modal-body relative p-4 text-gray-600">
                                    <div class="row grid md:grid-cols-2 gap-4 ">
                                        <div class="form-group w-full">
                                            <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Group Name</label>
                                            <div class="input-group flex text-gray-600 w-full rounded py-2">
                                                <input type="text" name="group_name" placeholder="Name of the Group" value="<?php echo $group_name; ?>" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " /> 
                                            </div>
                                            <span class="text-xs text-red-500"><?php echo $group_name_err; ?></span>
                                        </div>
                                        <div class="form-group w-full">
                                        <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Maximum number of students</label>
                                            <div class="input-group flex text-gray-600 w-full rounded py-2">
                                                <input type="number" name="group_max_number" placeholder="Maximum of students you wish to instructed" value="<?php echo $group_max_number; ?>" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " /> 
                                            </div>
                                            <span class="text-xs text-red-500"><?php echo $group_max_number_err; ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="row grid grid-cols-2 gap-4 pt-4">
                                        <div class="form-group w-full">
                                            <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Description</label>
                                            <span class="text-sm italic text-teal-700 text-center">Tell us what this group is all about ?</span>
                                            <div class="input-group flex text-gray-600 w-full rounded py-5">
                                                <textarea name="group_description" maxlength="800" minlength="300"  cols="30" rows="10"  placeholder="Write Here ..." class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded resize-none"></textarea>
                                            </div>
                                            <span class="text-xs text-red-500"><?php echo $group_description_err; ?></span>
                                        </div>
                                        <div class="form-group w-full">
                                            <div>
                                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Banner Image</label>
                                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                                    <label for="file-select" class="block">
                                                        <span class="sr-only">Choose file</span>
                                                        <input id="file-select" type="file" name="banner_image" onchange="displayImage(this)" placeholder="Choose file" class="block w-full text-sm text-gray-500
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded-full file:border-0
                                                        file:text-xs file:font-semibold
                                                        file:bg-teal-50 file:text-teal-700
                                                        hover:file:bg-teal-100
                                                        hover:cursor-pointer
                                                        "/>
                                                    </label>
                                                </div>
                                                <span class="text-xs text-red-500"><?php echo $banner_image_err; ?></span>
                                            </div>
                                            <div class="border-2 border-white rounded outline outline-2 outline-gray-100 w-60 h-80 overflow-hidden bg-white grid place-items-center">
                                                <label for="file-select" class="">
                                                    <img id="imageDisplay"  src="../../images/camera.png" class="w-full h-full object-contain border-0">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!--  -->
                                <div
                                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                                    <a href="./create_group.php" name="cancel" class="px-6 py-2.5 text-teal-700 border-gray-300 font-medium
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

                                    <button type="submit" name="create_group" class="px-6
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
                                    ml-1">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    }
?>
<!-- Remove everything INSIDE this div to a really blank page -->




<?php
    include './asset/Footer.php'
?>