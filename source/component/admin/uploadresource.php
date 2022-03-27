<?php
    include("../../php/config.php");
    include('./asset/Header.php');

    


    //define variables and initialize with empty values
    $resource_name = $ofYear = $file =  "";
    $resource_name_err = $ofYear_err = $file_err = $insert_msg_err = "";

    #############################################
    // change the timezone from berlin to kenya/nairobi
    date_default_timezone_set("Africa/Nairobi");
    

    # Insert resources into the DB
    $author = $_SESSION['username'];
    
    if(isset($_POST["upload_resource"])){
        //validate name
        if (empty($_POST['resource_name'])) {
            $resource_name_err = "Please enter the name of the document.";
        }else {
            $resource_name = trim($_POST['resource_name']);
        }
        //year
        if (empty($_POST['ofYear'])) {
            $ofYear_err = "Please enter the year of the document.";
        }elseif (trim($_POST['ofYear']) > date("Y")) {
            # check if the date inserted is > to the current data
            $ofYear_err = "Invalid year.";
        }else {
            $ofYear = trim($_POST['ofYear']);
        }
        
        // //resources
        // if (empty($_POST['resource_image'])) {
        //     $file_err = "Please enter the file.";
        // }
        
        #date of creation
        $created_on = date("Y-m-d");

        if ($_SESSION["level"] = "admin") {
            $status = "approved";
        }else{
            $status = "processing";
        }

        if (empty($resource_name_err) && empty($ofYear_err) && empty($file_err)) {
            # file upload [pdf, word, img]
            # upload file, [PDF, WORD, PNG and JPEG] ==================START======================
        $fileName = $_FILES['resource_image']['name'];
        $fileTmpName = $_FILES['resource_image']['tmp_name'];
        $fileSize = $_FILES['resource_image']['size'];
        $fileType = $_FILES['resource_image']['type'];
        $fileError = $_FILES['resource_image']['error'];

        $fileExt = explode('.', $fileName);
        
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'word');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 2000000) { //no more than 2mb = 2.000.000
                    $fileNameNew = $resource_name.'-'.$ofYear.'_'.time().'.'.$fileActualExt;
                    $fileDestination = '../../resources/'.$fileNameNew;
                    $fileStored = move_uploaded_file($fileTmpName, $fileDestination);
                    if ($fileStored === true ) {
                        $file = $fileNameNew;
                    }else{
                        echo "The file was not uploaded to the DB";
                    }
                }else{
                    echo "Your file is too large."; 
                }
            }else{
                echo "There were an error uploading this file.";
            }
        }else{
            echo "you can not upload file of this type.";
        }
        # =========================================END================================================
            #status = approve, processing, denied
            #sql
            $sql = "INSERT INTO resources(resource_name, ofyear, resource_file, created_on, author, resource_status) VALUES ('$resource_name','$ofYear','$file','$created_on','$author','$status')";
            $result = mysqli_query($link, $sql);
            if($result){
                $_SESSION['insert_msg'] = "Resources inserted successfully.";
                $_SESSION['alert_notification_resources'] = 'success';
                header("location: ./resources.php");
                
            }else{
                header("location: ./uploadresources.php");
                $insert_msg = "Failed to insert resources.";
                mysqli_error($link);
            }
        }
    }
?>
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            E-resources management
        </h2>
        <span class="">
            <i class="fa fa-book text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <button class="new-resources">
            <a href='./resources.php' type='button' name='upload-resource' value='upload' class='flex items-center px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>
                close
                <i class="fa fa-times text-teal-600 text-xl ml-2" aria-hidden="true"></i>
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
                        <h5 class="text-2xl font-medium text-center leading-normal text-gray-600">Add new resources</h5>
                        
                    </div>
                    <div class="modal-body relative p-4 text-gray-600">
                        <div class="row grid md:grid-cols-2 gap-4 ">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Name</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" name="resource_name" placeholder="Name of the Item" value="<?php echo $resource_name; ?>" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded " /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $resource_name_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium ">Year</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="number" min="2000" max="2050" maxlength="4" step="1" placeholder="<?php echo date("Y");?>"  name="ofYear" id="ofYear" class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded" /> 
                                </div>
                                <span class="text-xs text-red-500"><?php echo $ofYear_err; ?></span>
                            </div>
                        </div>
                        
                        <div class="row grid grid-cols-2 gap-4 items-center">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Image</label>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <label for="file-select" class="block">
                                        <span class="sr-only">Choose file</span>
                                        <input id="file-select" type="file" name="resource_image" onchange="displayImage(this)" placeholder="Choose file" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-xs file:font-semibold
                                        file:bg-teal-50 file:text-teal-700
                                        hover:file:bg-teal-100
                                        hover:cursor-pointer
                                        "/>
                                    </label>
                                </div>
                                <span class="text-xs text-red-500"><?php echo $file_err; ?></span>
                            </div>
                            <div class="form-group w-full">
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
                        <a href="./resources.php" name="cancel" class="px-6 py-2.5 text-teal-700 border-gray-300 font-medium
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

                        <button type="submit" name="upload_resource" class="px-6
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
                        ml-1">upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
    include './asset/Footer.php'
?>