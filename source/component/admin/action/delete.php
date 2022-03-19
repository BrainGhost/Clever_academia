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
}
  //DELETING DOCTOR FROM THE DATABASE
//   if (isset($_POST["doctor_id"]) && !empty($_POST["doctor_id"]))   {

//     $sql = "DELETE FROM doctors WHERE doctor_id= ?";

//     if ($stmt = mysqli_prepare($link, $sql)) {
//         # Bind variables ti the prepared statement as parameters
//         mysqli_stmt_bind_param($stmt, "i", $param_doctor_id);
//         #set parameters
//         $param_doctor_id = trim($_POST["doctor_id"]);
//         #attempt to execute the prepared statement
//         if (mysqli_stmt_execute($stmt)) {
//             # Record deleted successfully. redirect to intial page create
//             // header("location: ../doctors.php");
//             // exit();
//         }else {
//             echo "Oops! Something went wrong. Please try later";
//         }
//     }
//     // Close statement
//     mysqli_stmt_close($stmt);
//     // Close connection
//     mysqli_close($link);   
// }else{
//     // Check existence of id parameter
//     if(empty(trim($_GET["deletedid"]))){
//         // // URL doesn't contain id parameter. Redirect to error page
//         // header("location: error.php");
//         // exit();
//         echo "NO DATA";
//     }
// }  

    
    
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clever academia | Delete</title>
    <link rel="stylesheet" href="../../../css/main.css">
</head>
<body> -->
    <!-- CONFIRMATION DELETE ACCOUNT-->
    <!-- <div id="confirm-delete-modal" class="fixed z-20 inset-0 overflow-y-auto " aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div id="confirm-delete-modal-close" class="fixed inset-0 bg-gray-600 bg-opacity-60 transition-opacity" aria-hidden="true"></div> -->

            <!-- This element is to trick the browser into centering the modal contents. -->
            <!-- <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span> -->
            
                <!-- <div class="inline-block relative align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-red-500">
                   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 ">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full sm:mx-0 bg-red-100  sm:h-16 sm:w-16"> -->
                                    <!-- Heroicon name: outline/exclamation -->
                                    <!-- <svg class="h-12 w-12 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <input type="hidden" name="doctor_id" value="<?php echo trim($_GET["deletedid"]); ?>">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete user</h3>
                                    <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to delete this data.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" name="delete_doctor" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">Delete</button>
                            <a href="../doctors.php" class="mt-3 w-full inline-flex justify-center rounded-md border border-red-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">  
                                Cancel
                            </a>    
                        </div>
                    </form>
                </div>  
        </div>
    </div>
</body>
</html> -->