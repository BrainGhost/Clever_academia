<?php
include("../../php/config.php");
include('./asset/Header.php');

//define variables and initialize with empty values

$student_id = $_SESSION['student_id'];
// $interest_details =  "";
$interest_details_err = $interest_topics_err = $insert_msg = "";
############################################
$interest_details_update = $interest_topics_update = "";


#############################################
// change the timezone from berlin to kenya/nairobi
date_default_timezone_set("Africa/Nairobi");

#Check if the profile is already there
$in_profile = "";
$sql = "SELECT interest.interest_id,interest.interest_details, interest.interest_topics,students.profile,students.lastname,students.firstname,students.email,students.registration_year,students.phone_number,students.level
                FROM interest
                INNER JOIN students ON interest.student_id=students.student_id
                WHERE students.student_id = $student_id";
$result = mysqli_query($link, $sql);
$resultCheck = mysqli_num_rows($result);
#continue in the table itself

if ($resultCheck > 0) {
    $in_profile = true;
    while ($row = mysqli_fetch_assoc($result)) {
        $interest_id = $row['interest_id'];
        $profile = $row['profile'];
        $name = $row['lastname'] . ' ' . $row['firstname'];
        $email = $row['email'];
        $phone = $row['phone_number'];
        $details = $row['interest_details'];
        $topics = $row['interest_topics'];
        $topics_1 = explode(",", $topics);
        $level = $row['level'];
        $date = date("Y") - $row['registration_year'];
    }
} else {
    $in_profile = false;
}
# Insert resources into the DB

if (isset($_POST["save"])) {


    // //validate name
    if (empty($_POST['interest_details'])) {
        $interest_details_err = "Please this can not be empty.";
    } else {
        $interest_details = trim($_POST['interest_details']);
    }
    //topics
    if (empty($_POST['picked_topic'])) {
        $interest_topics_err = "Please select a topic.";
    } else {
        $interest_topics = $_POST['picked_topic'];
        $chkstr = implode(",", $interest_topics);
    }

    // #date of creation
    $created_on = date("Y-m-d");

    if (empty($interest_details_err) && empty($interest_topics_err)) {
        #sql
        $sql = "INSERT INTO interest(interest_details, interest_topics, student_id) VALUES ('$interest_details','$chkstr', '$student_id')";
        $result = mysqli_query($link, $sql);
        if ($result) {

            $insert_msg = "Profile added succesfull.";
            header("location: ./profile.php");
        } else {
            header("location: ./profile.php");
            $insert_msg = "Failed to send request.";
            mysqli_error($link);
        }
    }
    # =========================================END================================================
}
# ===================================================UPDATE=====================================
if (isset($_POST["update_save"])) {
    $editID = $_POST["interest_update_id"];
    // //validate name
    if (empty($_POST['interest_details'])) {
        $interest_details_err = "Please this can not be empty.";
    } else {
        $interest_details = $_POST['interest_details'];
    }
    //topics
    if (empty($_POST['picked_topic'])) {
        $interest_topics_err = "Please select a topic.";
    } else {
        $interest_topics = $_POST['picked_topic'];
        $chkstr = implode(",", $interest_topics);
    }

    if (empty($interest_details_err)) {
        $sql = "UPDATE interest SET interest_details='$interest_details', interest_topics='$chkstr',student_id='$student_id' WHERE interest_id='$editID'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $insert_msg = "Profile updated succesfull.";
            header("location: ./profile.php");
        } else {
            $insert_msg = "Failed to update.";
            header("location: ./profile.php");
            die(mysqli_error($link));
        }
    }
}


// <!-- NOTIFICATION ALERTS -->
if ($insert_msg !== "") {

?>
    <div id="notification" class=" p-4 rounded px-4 py-3 flex absolute <?php echo $insert_msg ? "top-7" : "top-16  "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 bg-emerald-100 border-emerald-500 text-emerald-700 " role="alert">
        <strong class="font-bold">Be warned! &nbsp;</strong>
        <span class="block sm:inline mr-12"><?php echo $insert_msg; ?></span>
        <span onclick="closeNFT(this); " class="absolute top-0 bottom-0 right-0 px-3 py-3 bg-emerald-200 text-emerald-700 cursor-pointer">
            <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
        </span>
    </div>
<?php
}
?>
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Profile
        </h2>
        <span class="">
            <i class="fa fa-user text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>

    <div class="form mt-4 w-full h-auto outline-none overflow-x-hidden overflow-y-auto z-50 flex pt-10" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="relative  pointer-events-none  w-1/2">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="modal-content border-none relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none">
                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-2xl font-medium text-center leading-normal text-gray-600">Customize your profile based on you interests</h5>
                    </div>
                    <div class="modal-body relative p-4 text-gray-600">
                        <div class="row grid md:grid-cols-2 gap-4">
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Interests</label>
                                <span class="text-sm italic text-teal-700 text-center">Tell us about about what you interested in.</span>
                                <div class="input-group flex text-gray-600 w-full rounded py-2">
                                    <textarea name="interest_details" maxlength="800" minlength="50" cols="30" rows="10" placeholder="Here ..." class="text-gray-600 w-full px-4 py-2 text-sm focus:border-teal-400 focus:outline-none border border-gray-200 rounded resize-none"><?php echo $details; ?></textarea>
                                </div>
                                <input type="hidden" name="interest_update_id" value="<?php echo $interest_id; ?>">
                                <span class="text-xs text-red-500"><?php echo $interest_details_err; ?></span>
                            </div>
                            <div class="form-group w-full">
                                <label class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium">Topics</label>
                                <span class="text-sm italic text-teal-700 text-center">Select the topics you are most interested in.</span>
                                <div class="input-group grid gap-2 text-gray-600 w-full py-3">
                                    <?php
                                    $sql = "SELECT * FROM topics";
                                    $result = mysqli_query($link, $sql);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $topicDisplay = $row['name'];
                                            // if (in_array("French", $topics)) {
                                            //     echo "checked";
                                            // };
                                    ?>
                                            <div>
                                                <input type="checkbox" class="mx-2" name="picked_topic[]" value="<?php echo $topicDisplay; ?>"><?php echo $topicDisplay; ?>
                                            </div>
                                    <?php

                                        }
                                        mysqli_free_result($result);
                                    }

                                    ?>
                                </div>
                                <span class="text-xs text-red-500"><?php echo $interest_topics_err; ?></span>
                            </div>
                        </div>

                    </div>
                    <!--  -->
                    <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <a href="./profile.php" name="cancel" class="px-6 py-2.5 text-teal-700 font-medium
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
                        if ($in_profile === true) {
                            echo
                            "
                            <button type='submit' name='update_save' class='px-6
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
                        } else {
                            echo
                            "
                            <button type='submit' name='save' class='px-6
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
                            ml-1'>Save</button>
                            ";
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="w-1/2 lg:px-[8rem]">
            <?php
            if ($in_profile === true) {
            ?>
                <div class="bg-white card border-2 border-gray-100 rounded-xl  hover:shadow-lg cursor-default transition-all duration-300">
                    <div class="banner relative h-24 border-b">
                        <div class="absolute bottom-4 pl-[8rem] px-4 py-2 text-gray-600 uppercase  w-full flex justify-evenly font-bold">
                            <h1><?php echo $name; ?></h1>
                            <span class="text-teal-400"> - </span>
                            <h1><?php echo $date; ?> year</h1>
                        </div>
                        <div class="profile absolute -bottom-10 left-6 transform ">
                            <img src="../../images/<?php echo $profile; ?>" class="bg-white profile w-24 h-24 rounded-full outline outline-gray-200 border-2 border-white">
                        </div>
                    </div>
                    <div class="down p-2 mt-2 px-10">
                        <div class="down_content ">
                            <p class="uppercase  text-center text-gray-500 text-sm mb-2 pl-[7rem]">
                                <span><?php echo $level; ?> .</span>
                                <span class="lowercase italic text-base"><?php echo $email; ?></span><br />
                                <span class="tracking-widest"><?php echo $phone; ?></span>
                            </p>

                            <p class="text-center text-gray-700 text-base">
                                <?php echo $details; ?>
                            </p>
                            <div class="pl-10 ">
                                <ul class="list-disc list-inside grid grid-cols-3 gap-2 pt-3">
                                    <?php
                                    foreach ($topics_1 as $item) {
                                        echo
                                        "
                                                <li class='text-teal-500'>
                                                    <span class='text-gray-700'>$item</span>
                                                </li>
                                                ";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                echo
                "
                    <div class='flex items-center cursor-default justify-center px-4 py-2 border border-teal-500 bg-teal-50 rounded text-teal-500 font-medium'>
                        No profile Yet
                    </div>
                    ";
            }
            ?>
        </div>
    </div>
</div>



<?php
include './asset/Footer.php'
?>