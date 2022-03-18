<?php
# include config file
require_once "../../../php/config.php";
//Process delete operation after confirmation
if (isset($_GET["deletedid"]) && !empty($_GET["deletedid"])) {
    $deleteId  = $_GET["deletedid"];
    
    #prepare a delete statment
    $sql = "DELETE FROM doctors WHERE doctor_id=$deleteId";

    $result = mysqli_query($link, $sql);
    if ($result) {
        echo "Deleted sucess";
        header("location: ../doctors.php");
    }else {
        echo "Oops! Something went wrong. Please try later";
        die(mysqli_error($link));
    } 
    

//     if (isset($_GET[])) {
//         # Bind variables ti the prepared statement as parameters
//         mysqli_stmt_bind_param($stmt, "i", $param_doctor_id);
//         #set parameters
//         $param_doctor_id = trim($_POST["doctor_id"]);
//         #attempt to execute the prepared statement
//         if (mysqli_stmt_execute($stmt)) {
//             # Record deleted successfully. redirect to intial page create
//             header("location: ../index.php");
//         }else {
//             echo "Oops! Something went wrong. Please try later";
//         }
//     }
//     // Close statement
//     mysqli_stmt_close($stmt);
    
//     // Close connection
//     mysqli_close($link);
// }else {
//     if (empty(trim($_GET["doctor_id"]))) {
//         header("location: error.php");
//     }
  }
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clever academia || Delete</title>
</head>
<body>
    <a href="../index.php">BACK HOME</a>
</body>
</html> -->