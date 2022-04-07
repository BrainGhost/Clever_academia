<?php
    include("../../php/config.php");
    include('./asset/Header.php');

    //define variables and initialize with empty values
    // $application_reason =  "";
    $application_reason_err = $insert_msg = "";
    ############################################
    $motif_update = "";
  if (isset($_GET["editID"])) {
     $editID = $_GET["editID"];
     //Display data into the table 
     $sql  = "SELECT * FROM mentor_application WHERE application_id = $editID";
     $result = mysqli_query($link, $sql);

     while ($row = mysqli_fetch_assoc($result)) {
        $motif_update = $row['motif'];
    }
    mysqli_free_result($result);

  }
                        
    #############################################
    // change the timezone from berlin to kenya/nairobi
    date_default_timezone_set("Africa/Nairobi");
    

    # Insert resources into the DB
    $student_id = $_SESSION['student_id'];
    
    if(isset($_POST["apply"])){
        //validate name
        if (empty($_POST['application_reason'])) {
            $application_reason_err = "Please this can not be empty.";
        }else {
            $application_reason = trim($_POST['application_reason']);
        }
        
        #date of creation
        $created_on = date("Y-m-d");

        if (empty($application_reason_err) ) {
            $sql = "SELECT application_id FROM mentor_application WHERE student_id = $student_id";
            $result = mysqli_query($link, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck < 1) {
                #sql
                $sql = "INSERT IGNORE INTO mentor_application(motif, date, student_id, status) VALUES ('$application_reason','$created_on','$student_id', 'processing') LIMIT 1";
                $result = mysqli_query($link, $sql);
                if($result){
                    $_SESSION['insert_msg'] = "Your resquest has been succesfull been sent.";
                    $_SESSION['alert_notification_resources'] = 'success';
                    header("location: ./application.php");
                    
                }else{
                    header("location: ./applymentor.php");
                    $insert_msg = "Failed to send request.";
                    mysqli_error($link);
                }
            }else {
                $_SESSION['insert_msg'] = "Duplicated .. Failed to send request.";
                $_SESSION['alert_notification_resources'] = 'delete';
                // header("location: ./applymentor.php");
                header("location: ./application.php");
            }    
        }
        # =========================================END================================================
    }
    # ===================================================UPDATE=====================================
    if(isset($_POST["update_apply"])){
        $update_id = $_POST["update_apply"];
        //validate name
        if (empty($_POST['application_reason'])) {
            $application_reason_err = "Please this can not be empty.";
        }else {
            $application_reason = $_POST['application_reason'];
        }
        #date of creation
        $created_on = date("Y-m-d");
        
        if (empty($application_reason_err) ){
            $sql = "UPDATE mentor_application SET motif='$application_reason',date='$created_on',student_id='$student_id',status='processing' WHERE application_id='$update_id'";
            $result = mysqli_query($link, $sql);
            if($result){
                $_SESSION['insert_msg'] = "Updated successfully.";
                $_SESSION['alert_notification'] = "update";
                header("location: ./application.php");
            }else{
                echo "Oops! Something went wrong. Please try later";
                die(mysqli_error($link));
            }
            
        }
    }
?>
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
        Mentorship Application 
        </h2>
        <span class="">
            <i class="fa fa-book text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="mt-2 w-full">
        <button class="new-resources">
            <a href='./application.php' type='button' name='upload-resource' value='upload' class='flex items-center px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>
                close
                <i class="fa fa-times text-teal-600 text-xl ml-2" aria-hidden="true"></i>
            </a>
        </button>
    </div>
    <div class="form mt-4 lg:w-[700px] h-auto outline-none overflow-x-hidden overflow-y-auto z-50 "
    id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="relative w-auto pointer-events-none  ">
            <form method="post" enctype="multipart/form-data">
                <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none">
                    <div
                        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-2xl font-medium text-center leading-normal text-gray-600">Application</h5>   
                    </div>
                    <div class="modal-body relative p-4 text-gray-600">
                        <div class="row grid gap-4 ">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Reason</label>
                                <span class="text-sm italic text-teal-700 text-center">In 800 words, tell us why do you wish to become a mentor and your goals in doing so.</span>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <input type="text" value="<?php echo $motif_update;?>" maxlength="800" minlength="300" name="application_reason" cols="30" rows="10"  placeholder="Here ..." class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded resize-none">
                                    </input>
                                </div>
                                <span class="text-xs text-red-500"><?php echo $application_reason_err; ?></span>
                            </div>
                        </div>
                        
                    </div>
                    <!--  -->
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <a href="./application.php" name="cancel" class="px-6 py-2.5 text-teal-700 font-medium
                        -close
                        text-xs
                        leading-tight
                        uppercase
                        border
                        border-teal-600
                        rounded
                        hover:bg-gray-50 hover:shadow-lg
                        focus:bg-gray-50 focus:shadow-lg focus:outline-none focus:ring-0
                        active:bg-gray-50 active:shadow-lg
                        transition
                        duration-150
                        ease-in-out">Cancel</a>
                        <?php
                        if (isset($_GET["editID"])) {
                            echo
                            "
                            <button type='submit' name='update_apply' class='px-6
                            py-2.5
                            border
                            border-teal-600
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
                            ml-1'>Update</button>
                            ";

                        }else{
                            echo
                            "
                            <button type='submit' name='apply' class='px-6
                            py-2.5
                            border
                            border-teal-600
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
                            ml-1'>Apply</button>
                            ";
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
    include './asset/Footer.php'
?>