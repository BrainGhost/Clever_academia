<?php
include("../../php/config.php");
include ('./asset/Header.php');


if (isset($_GET['viewId']) && isset($_GET['viewName']) ) {
    $viewId = $_GET['viewId'];
    $viewName = $_GET['viewName'];

    $sql = "SELECT * FROM resources WHERE resource_id = $viewId";
    $result = mysqli_query($link, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fileName = $row['resource_name'];
            $fileYear = $row['ofyear'];
            $fileAuthor = $row['author'];
            $fileStatus = $row['resource_status'];
            $file = $row['resource_file'];
        }
    }
}

?>

<!-- ===========================================VIEW THE DETAIL RESOURCES FROM THE THE DB AND DOWNLOAD==================================================== -->
<div class="student-container container px-6 w-full h-auto  overflow-hidden">
    <div class="flex items-center border-b bg-white shadow-lg px-4">
        <h2 class="my-6 text-2xl text-center font-semibold text-gray-700 flex-1 ">
            <?php echo $viewName; ?>
        </h2>
        <span class="">
            <i class="fa fa-eye text-teal-600 hover:text-teal-700 cursor-pointer text-2xl transition duration-150 ease-in-out" aria-hidden="true"></i>
        </span>
    </div>
    <div class="h-full bg-white my-2 shadow-lg px-4">
        <div class="flex items-center border-b bg-white">
           <div class="flex-1">
                <label class="flex text-sm my-2 items-center">
                  <span class="text-gray-700 mr-2">Name: </span>
                  <h1 class="block text-sm"><?php echo $fileName; ?></h1>
                </label>
                <label class="flex text-sm my-2 items-center">
                  <span class="text-gray-700 mr-2">Year: </span>
                  <h1 class="block text-sm"><?php echo $fileYear; ?></h1>
                </label>
                <label class="flex text-sm my-2 items-center">
                  <span class="text-gray-700 mr-2">Upload by: </span>
                  <h1 class="block text-sm"><?php echo $fileAuthor; ?></h1>
                </label>
                <label class="flex text-sm my-2 items-center">
                  <span class="text-gray-700 mr-2">Status: </span>
                  <h1 class="block text-sm font-bold text-sky-500 uppercase"><?php echo $fileStatus; ?></h1>
                </label>
           </div>
           <div class="text-sm font-bold text-gray-700 flex flex-col text-right">
               <span><?php echo date("l")?></span>
               <span class="mt-2"><?php echo date("Y-dd-m")?></span>
           </div>
        </div>
        <div class="footer flex mt-2 justify-end items-center">
            <button
            onclick=""
            type="submit"
            class="block cursor-pointer w-auto px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-teal-600 border border-transparent rounded-lg active:bg-teal-600 hover:bg-teal-700 focus:outline-none focus:shadow-outline-purple"
            value="Download"
            >Download</button>
        </div>
        <!-- view my pdf here -->
        <div class="mt-2 grid place-items-center">
            <iframe class="bg-white object-contain w-full border-none" src="<?php echo "../../resources/".$file."#toolbar=0"; ?>" type="application/pdf" min-width="60%" height="800px" loading="lazy" seamless name="<?php echo $viewName; ?>">
        </div>
        
    </div>
</div>