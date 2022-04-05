<?php
    include("../../php/config.php");


    
    if (isset($_GET["deletedid"])) {
        $deleteId  = $_GET["deletedid"];
        $deleteEmail  = $_GET["deletedemail"];
        #prepare a delete statment
        $sql = "DELETE FROM student WHERE student_id=$deleteId";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $sql = "SELECT has_account FROM students WHERE student_id = $deleteId";
            $result = mysqli_query($link, $sql);
            if($result){
                $row = mysqli_fetch_assoc($result);
                if ($row['has_account'] == 1 ) {
                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['student_id'].",".$status.");' type='button' name='change_status' value='Active' class='px-4 py-1 border border-teal-500 bg-teal-50 rounded  hover:bg-teal-100 text-teal-500 font-medium'>Active</a>";
                }else{
                    $status_insert = "<a href='javascript:displayModal_inactive(".$row['student_id'].",".$status.");' type='button' name='change_status' value='Inactive' class='px-4 py-1 border border-red-500 bg-red-50 rounded  hover:bg-red-100 text-red-500 font-medium'>Inactive</a>"; 
                }
            }

            $sql =  "DELETE FROM credentials WHERE email = $deleteEmail";
            if(mysqli_query($link, $sql)){
                $_SESSION['insert_msg'] = "Deleted successfully.";
                $_SESSION['alert_notification'] = "delete";
                header("location: ./doctors.php");
            }
        }else {
            echo "Oops! Something went wrong. Please try later";
            die(mysqli_error($link));
        }
    }

?>