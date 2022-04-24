<?php
    include("../../php/config.php");


    
    if (isset($_GET["deletedid"])) {
        $deleteId  = $_GET["deletedid"];
        $deleteEmail  = $_GET["deletedemail"];
        #prepare a delete statment
        $sql = "DELETE FROM doctors WHERE doctor_id=$deleteId";
    
        $result = mysqli_query($link, $sql);
        if ($result) {
            // $sql =  "DELETE FROM credentials WHERE email = $deleteEmail";
            // if(mysqli_query($link, $sql)){
                $_SESSION['insert_msg'] = "Deleted successfully.";
                $_SESSION['alert_notification'] = "delete";
                header("location: ./doctors.php");
            // }
        }else {
            echo "Oops! Something went wrong. Please try later";
            die(mysqli_error($link));
        }
    }
#===========================updating the status=============================

    if(isset($_POST['update_status'])){
        $updateSTATUS_id = trim($_POST['updateSTATUS_id']);
        $updateSTATUS_TEXT = trim($_POST['updateSTATUS_TEXT']);
        
        //input status to be changes to
        if($updateSTATUS_TEXT == 1)
        {
            $next_status = 0;
        }elseif ($updateSTATUS_TEXT == 0) {
            $next_status = 1;
        }
        
        $sql = "UPDATE doctors SET doctor_status='$next_status' WHERE doctor_id= $updateSTATUS_id ";
        $result = mysqli_query($link, $sql);
            if($result){
                $_SESSION['insert_msg'] = "Status change successfully.";
                $_SESSION['alert_notification'] = "success";
                header("location: ./doctors.php");
            }else{
                echo "Oops! Something went wrong. Please try later";
                die(mysqli_error($link));
            }
    }

#===========================the working code for updating=============================
if(isset($_POST["update_doctor"]))
{
    $update_id = trim($_POST['update_id']);
    //variable
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $phonenumber = trim($_POST['phonenumber']);
    $dateofbirth = date("Y-m-d", strtotime(trim($_POST['dateofbirth']))) ;
    $speciality= trim($_POST['speciality']);
    $degree = trim($_POST['degree']);
    #

    #image upload
    $photo = $_FILES["photoImager"];
    echo print_r($photo);
    $photoImageName = time() .'_'. $_FILES["photoImager"]["name"];
    $photo_tmp_name = $_FILES["photoImager"]["tmp_name"];
    $target_location = '../../images/'.$photoImageName;

    //statement
    $sql = "UPDATE doctors SET fullname='$fullname',email='$email',password='$password',address='$address',phone_number='$phonenumber',date_of_birth='$dateofbirth',speciality='$speciality',degree='$degree',image=' $photoImageName' WHERE doctor_id= $update_id ";
    $result = mysqli_query($link, $sql);
    if($result){
        move_uploaded_file($photo_tmp_name, $target_location);
        $_SESSION['insert_msg'] = "Updated successfully.";
        $_SESSION['alert_notification'] = "update";
        // header("location: ./doctors.php");
    }else{
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }

}
#===========================Deleting resources=============================
if (isset($_GET["resourceid"])) {
    $resourceId  = $_GET["resourceid"];
    #prepare a delete statment
    $sql = "DELETE FROM resources WHERE resource_id=$resourceId";

    $result = mysqli_query($link, $sql);
    if ($result) {
        $_SESSION['insert_msg'] = "Deleted successfully.";
        $_SESSION['alert_notification'] = "delete";
        header("location: ./resources.php");
    }else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}
#===========================Deleting mentor=============================
if (isset($_GET["mentordeletedid"])) {
    $mentorId  = $_GET["mentordeletedid"];
    #prepare a delete statment
    $sql = "DELETE FROM mentor WHERE mentor_id=$mentorId";

    $result = mysqli_query($link, $sql);
    if ($result) {
        $sql = "UPDATE students SET level ='standard'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            header("location: ./mentors.php");
        }
    }else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}
