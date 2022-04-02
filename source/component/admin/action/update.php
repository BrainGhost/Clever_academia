<?php
    include("../../../php/config.php");


    
    if (isset($_GET["deletedid"])) {
        $deleteId  = $_GET["deletedid"];
        
        #prepare a delete statment
        $sql = "DELETE FROM doctors WHERE doctor_id=$deleteId";
    
        $result = mysqli_query($link, $sql);
        if ($result) {
            $_SESSION['insert_msg'] = "Deleted successfully.";
            $_SESSION['alert_notification'] = "delete";
            header("location: ../doctors.php");
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
                header("location: ../doctors.php");
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

    #image upload
    $photoImageName = time() .'_'. $_FILES["photoImage"]["name"];
    $target_location = '../../../images/' . $photoImageName;

    //statement
    $sql = "UPDATE doctors SET fullname='$fullname',email='$email',password='$password',address='$address',phone_number='$phonenumber',date_of_birth='$dateofbirth',speciality='$speciality',degree='$degree',image='?' WHERE doctor_id= $update_id ";
    $result = mysqli_query($link, $sql);
    if($result){
        $_SESSION['insert_msg'] = "Updated successfully.";
        $_SESSION['alert_notification_resources'] = "update";
        header("location: ../doctors.php");
    }else{
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    }
}
#===========================updating the status for students=============================
if(isset($_POST['update_status_student'])){
    $updateSTATUS_id = trim($_POST['updateSTATUS_id']);
    $updateSTATUS_TEXT = trim($_POST['updateSTATUS_TEXT']);
    
    //input status to be changes to
    if($updateSTATUS_TEXT == 1)
    {
        $next_status = 0;
    }elseif ($updateSTATUS_TEXT == 0) {
        $next_status = 1;
    }
    
    $sql = "UPDATE students SET student_status='$next_status' WHERE student_id= $updateSTATUS_id ";
    $result = mysqli_query($link, $sql);
        if($result){
            $_SESSION['insert_msg'] = "Status change successfully.";
            $_SESSION['alert_notification_resources'] = "success";
            header("location: ../students.php");
        }else{
            echo "Oops! Something went wrong. Please try later";
            die(mysqli_error($link));
        }
}
?>
