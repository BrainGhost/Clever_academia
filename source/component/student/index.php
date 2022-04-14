<?php
    include("../../php/config.php");
    include ('./asset/Header.php');

// <!-- NOTIFICATION ALERTS -->
$insert_msg = "";
$student_id = $_SESSION['student_id'];

if ($_SESSION['insert_msg'] !== "") {
        $action = "";

        $action = $_SESSION['alert_notification_resources'];
        switch ($action) {
            case 'success':
                $alert_msg = "Success";
                $alert_div_color = 'bg-emerald-100 border-emerald-500 text-emerald-700';
                $alert_btn_color = 'bg-emerald-200 text-emerald-700';
                break;
                
            case 'update':
                $alert_msg = "Update";
                $alert_div_color = 'bg-sky-100 border-sky-500 text-sky-700';
                $alert_btn_color = 'bg-sky-200 text-sky-700';
                break;

            case 'delete':
                $alert_msg = "Delete";
                $alert_div_color = 'bg-red-100 border-red-500 text-red-700';
                $alert_btn_color = 'bg-red-200 text-red-700';
                break;
                
            default:
                $alert_msg = "Be Warned";
                $alert_div_color = 'bg-orange-100 border-orange-500 text-orange-700';
                $alert_btn_color = 'bg-orange-200 text-orange-700';
                break;
        }

?>
    <div class="p-4 rounded px-4 py-3 absolute <?php echo ($insert_msg || $_SESSION['insert_msg']) ? "top-7 flex" : "-top-16 "; ?> left-1/2 -translate-x-1/2 shadow-md max-w-lg z-50 border-l-4 <?php echo $alert_div_color;?> " role="alert">
        <strong class="font-bold"><?php echo $alert_msg; ?>! &nbsp;</strong>
        <span class="block sm:inline mr-12"><?php echo  $insert_msg ? $insert_msg : $_SESSION['insert_msg'] ; ?></span>
        <span onclick="closeNFT(this); <?php $_SESSION['insert_msg'] = null; ?>" class="absolute top-0 bottom-0 right-0 px-3 py-3 <?php echo $alert_btn_color;?> cursor-pointer">
            <i class="fa fa-times text-xl pointer-events-none" aria-hidden="true"></i>
        </span>
    </div>
<?php     
    }
    //Display data into the table 
    $sql  = "SELECT * FROM mentor";
    $result = mysqli_query($link, $sql);
    $resultCheck = mysqli_num_rows($result);
    #continue in the table itself
    
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // $profile = ;
            // $name = ;
            // $topic = ;
        }
        mysqli_free_result($result);
    }
?>
<div
	class="absolute hidden inset-0 bg-gray-600 bg-opacity-60 overflow-y-auto h-full w-full z-20"
	id="my-modal"
></div>
<!-- Remove everything INSIDE this div to a really blank page -->
<div class="student-container container px-6 mx-auto grid relative">
    <div class="flex items-center border-b">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 flex-1">
            Dashboard
        </h2>
        <span class="openModalBtn">
            <i class="fa fa-home text-teal-600 hover:text-teal-700 text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="bg-white shadow-lg">
        <div class="w-[calc(100vw-20rem)] xl:w-[1000px] p-2 flex gap-4 mx-auto overflow-x-scroll scrollbar-hide">
            <?php
            //PIE CHARTS
            $sql = "SELECT mentor.mentor_id, mentor_application.topics,students.student_id, students.firstname, students.lastname, students.profile
                    FROM mentor
                    INNER JOIN mentor_application ON mentor.application_id=mentor_application.application_id
                    INNER JOIN students ON mentor_application.student_id=students.student_id
                    WHERE mentor_application.student_id != $student_id
                    ";

            $result = mysqli_query($link, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['firstname'].' '.$row['lastname'];
                $topic = $row['topics'];
                $profile = $row['profile'];
            ?>
                <div class="w-40 p-2">
                    <a href="view_mentor.php?<?php echo $row['mentor_id']; ?>" class=" relative w-30 text-center cursor-pointer">
                        <div class="bg-gradient-to-r from-teal-500 via-gray-500 to-red-500 p-1 rounded-full mb-2 mx-auto">
                            <img
                                src="../../images/<?php echo $profile; ?>"
                                class="rounded-full shadow-lg p-1 bg-white opacity-100 hover:opacity-90 transition duration-300 ease-in-out"
                                alt="Avatar"
                            /> 
                        </div>
                        <div>
                            <h5 class="text-xl text-teal-800 font-medium leading-tight mb-2"><?php echo $name; ?></h5>
                            <p class="text-gray-500"><?php echo $topic; ?></p>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>       
              
        </div>
    </div>
    
    <div class="table mt-4">
        <div class="search flex justify-center">
            <div class=" w-96 my-2">
                <div class="flex items-center justify-center">
                    <label for="" class="block text-teal-700 text-sm px-2"> View all the latest update Here (courses). </label>
                </div>
            </div> 
        </div>
        <!-- style="width:100%; padding-top: 1em;  padding-bottom: 1em; -->
        <div id='recipients' class=" max-w-full rounded shadow bg-white ">
            <div class="display_card p-2 grid grid-cols-4 auto-rows-auto">
                <div class="card w-80 border-2 border-gray-100 rounded-xl overflow-hidden hover:shadow-lg cursor-pointer transition-all duration-300">
                    <div class="banner relative h-40 shadow-lg">
                        <img src="../../images/banner.png" class="background h-full w-full object-container">
                        <div class="profile absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                            <img src="../../images/1648479559_0 (8).png" class="profile w-24 h-24 rounded-full outline outline-white">
                        </div>
                    </div>
                    <div class="down p-2 mt-10">
                        <div class="down_content">
                            <p class="uppercase text-center text-gray-500 text-xs mb-2">Balibonera . React js</p>
                            <p class="text-center text-gray-700">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Officiis, consequuntur repellat quos autem voluptas corporis 
                                inventore dolores deleniti in temporibus saepe sapiente iste a
                                liquid reiciendis quisquam obcaecati? Aliquam, unde odio.
                            </p>
                            <div class="mt-2 border-t-2 border-gray-100 flex justify-center">
                                <button class="my-2 px-6 py-2 border border-teal-500 bg-teal-50 rounded-full  hover:bg-teal-100 text-teal-500 font-medium">Join group</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w-80 border-2 border-gray-100 rounded-xl overflow-hidden hover:shadow-lg cursor-pointer transition-all duration-300">
                    <div class="banner relative h-40 shadow-lg">
                        <img src="../../images/banner.png" class="background h-full w-full object-container">
                        <div class="profile absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                            <img src="../../images/1648479559_0 (8).png" class="profile w-24 h-24 rounded-full outline outline-white">
                        </div>
                    </div>
                    <div class="down p-2 mt-10">
                        <div class="down_content">
                            <p class="uppercase text-center text-gray-500 text-xs mb-2">Balibonera . React js</p>
                            <p class="text-center text-gray-700">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Officiis, consequuntur repellat quos autem voluptas corporis 
                                inventore dolores deleniti in temporibus saepe sapiente iste a
                                liquid reiciendis quisquam obcaecati? Aliquam, unde odio.
                            </p>
                            <div class="mt-2 border-t-2 border-gray-100 flex justify-center">
                                <button class="my-2 px-6 py-2 border border-teal-500 bg-teal-50 rounded-full  hover:bg-teal-100 text-teal-500 font-medium">Join group</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w-80 border-2 border-gray-100 rounded-xl overflow-hidden hover:shadow-lg cursor-pointer transition-all duration-300">
                    <div class="banner relative h-40 shadow-lg">
                        <img src="../../images/banner.png" class="background h-full w-full object-container">
                        <div class="profile absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                            <img src="../../images/1648479559_0 (8).png" class="profile w-24 h-24 rounded-full outline outline-white">
                        </div>
                    </div>
                    <div class="down p-2 mt-10">
                        <div class="down_content">
                            <p class="uppercase text-center text-gray-500 text-xs mb-2">Balibonera . React js</p>
                            <p class="text-center text-gray-700">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Officiis, consequuntur repellat quos autem voluptas corporis 
                                inventore dolores deleniti in temporibus saepe sapiente iste a
                                liquid reiciendis quisquam obcaecati? Aliquam, unde odio.
                            </p>
                            <div class="mt-2 border-t-2 border-gray-100 flex justify-center">
                                <button class="my-2 px-6 py-2 border border-teal-500 bg-teal-50 rounded-full  hover:bg-teal-100 text-teal-500 font-medium">Join group</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w-80 border-2 border-gray-100 rounded-xl overflow-hidden hover:shadow-lg cursor-pointer transition-all duration-300">
                    <div class="banner relative h-40 shadow-lg">
                        <img src="../../images/banner.png" class="background h-full w-full object-container">
                        <div class="profile absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                            <img src="../../images/1648479559_0 (8).png" class="profile w-24 h-24 rounded-full outline outline-white">
                        </div>
                    </div>
                    <div class="down p-2 mt-10">
                        <div class="down_content">
                            <p class="uppercase text-center text-gray-500 text-xs mb-2">Balibonera . React js</p>
                            <p class="text-center text-gray-700">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Officiis, consequuntur repellat quos autem voluptas corporis 
                                inventore dolores deleniti in temporibus saepe sapiente iste a
                                liquid reiciendis quisquam obcaecati? Aliquam, unde odio.
                            </p>
                            <div class="mt-2 border-t-2 border-gray-100 flex justify-center">
                                <button class="my-2 px-6 py-2 border border-teal-500 bg-teal-50 rounded-full  hover:bg-teal-100 text-teal-500 font-medium">Join group</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
    </div>
</div>

<?php
    include './asset/Footer.php'
?>