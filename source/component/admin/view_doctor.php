<?php
include("../../php/config.php");
include ('./asset/Header.php');


if (isset($_GET['viewId'])  ) {
    $viewId = $_GET['viewId'];

    $sql = "SELECT * FROM doctors WHERE doctor_id = $viewId";
    $result = mysqli_query($link, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $doctor_name = $row['fullname'];
            $doctor_email = $row['email'];
            $doctor_NO = $row['phone_number'];
            $doctor_DOB = $row['date_of_birth'];
            $doctor_address = $row['address'];
            $doctor_speciality = $row['speciality'];
            $doctor_degree = $row['degree'];
            $doctor_image = $row['image'];
            if ($doctor_status = $row['doctor_status']) {
                $doctor_status = "Active";
            }else {
                $doctor_status = "Inactive";
            }
        }
    }
}

?>
<!-- ===========================================VIEW THE DETAIL RESOURCES FROM THE THE DB AND DOWNLOAD==================================================== -->
<div  class="print_container student-container container px-6 w-full h-[calc(100vh-80px)] ">
    <div class="flex items-center border-b bg-white shadow-lg px-4">
        <h2 class="my-6 text-2xl text-center font-semibold text-gray-700 flex-1 ">
           File of:  <?php echo $doctor_name; ?>
        </h2>
        <span class="">
            <i class="fa fa-eye text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="h-full bg-white my-2 shadow-xl px-4">
        <div class="flex items-center border-b bg-white">
           <div class="flex flex-1">
                 <div class="w-48 h-56 bg-teal-600 mr-4 mt-4 mb-4 rounded-lg">
                     <label for="profile">
                        <img id="profile" src="<?php echo "../../images/".$doctor_image; ?>"  class="w-full h-full" alt="profile">
                     </label>
                </div>
               <div class="my-4">
                    <label class="flex text-sm my-2 items-center">
                        <span class="text-gray-700 mr-2">Name: </span>
                        <h1 class="block text-sm"><?php echo $doctor_name; ?></h1>
                    </label>
                    <label class="flex text-sm my-2 items-center">
                        <span class="text-gray-700 mr-2">Email: </span>
                        <h1 class="block text-sm"><?php echo $doctor_email; ?></h1>
                    </label>
                    <label class="flex text-sm my-2 items-center">
                        <span class="text-gray-700 mr-2">Address: </span>
                        <h1 class="block text-sm"><?php echo $doctor_address; ?></h1>
                    </label>
                    <label class="flex text-sm my-2 items-center">
                        <span class="text-gray-700 mr-2">phone: </span>
                        <h1 class="block text-sm"><?php echo $doctor_NO; ?></h1>
                    </label>
                    <label class="flex text-sm my-2 items-center">
                        <span class="text-gray-700 mr-2">Date of birth: </span>
                        <h1 class="block text-sm"><?php echo $doctor_DOB; ?></h1>
                    </label>
                    <label class="flex text-sm my-2 items-center">
                        <span class="text-gray-700 mr-2">Speciality: </span>
                        <h1 class="block text-sm"><?php echo $doctor_speciality; ?></h1>
                    </label>
                    <label class="flex text-sm my-2 items-center">
                        <span class="text-gray-700 mr-2">Study: </span>
                        <h1 class="block text-sm"><?php echo $doctor_degree; ?></h1>
                    </label>
                    <label class="flex text-sm my-2 items-center">
                        <span class="text-gray-700 mr-2">Status: </span>
                        <h1 class="block text-sm font-bold text-sky-500 uppercase"><?php echo $doctor_status; ?></h1>
                    </label>
               </div>
           </div>
           <div class="text-sm font-bold text-gray-700 flex flex-col text-right">
               <span><?php echo date("l");?></span>
               <span class="mt-2"><?php echo date("Y-dd-m");?></span>
           </div>
        </div>
        <!-- view my pdf here -->
        <div class="bg-yellow-500 mt-2 h-auto max-h-80">
            <div class="rounded w-full bg-teal-600 text-white py-2 text-center font-bold">Legal document</div>
        </div>
        <div class="footer flex mt-2 justify-end items-center">
            <button
            onclick="window.print();"
            class="block cursor-pointer w-auto px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-teal-600 border border-transparent rounded-lg active:bg-teal-600 hover:bg-teal-700 focus:outline-none focus:shadow-outline-purple"
            >Print</button>
        </div>
    </div> 
</div>