<?php
ob_start();
//Initialize the session
session_start();

//check if the user is logged in, if not the redirect him to the login page
if (!isset($_SESSION["loggedin_student"]) || $_SESSION["loggedin_student"] !== true) {
  header("location: ../../pages/index.php");
}
$student_id = $_SESSION['student_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet" />

  <!-- Icon Font Stylesheet -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="../../css/main.css">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/table.css">
  <style>
    @media print {

      /* Hide every other element */
      body *:not(.print_container):not(.print_container *) {
        visibility: hidden;
      }

      /* The display print conatiner element */
      .print_container {
        visibility: visible;
        position: absolute;
        top: 0;
      }

      .print_container * {
        box-shadow: none !important;
      }
    }
  </style>
  <title>Clever academia | Learning platform</title>
</head>

<body>
  <div class="flex h-screen bg-gray-50" :class="{'overflow-hidden': isSideMenuOpen}">
    <!-- feedback hot toast -->
    <!-- top-7 -->

    <div class="absolute -top-10  left-1/2 -translate-x-1/2 text-gray-600 flex items-center justify-center w-80 bg-red-100 transition duration-150 ease-in-out p-1 z-50 shadow-md border  border-red-200 rounded ">
      <span class="bg-red-400 grid place-items-center rounded-full mx-2 w-6 h-6">
        <i class="fa fa-times  cursor-pointer text-white text-xs" aria-hidden="true"></i>
      </span>
      Deleted successfully !!
    </div>
    <!-- Desktop sidebar -->
    <aside class="z-20 hidden w-64 overflow-y-auto bg-white md:block flex-shrink-0">
      <div class="py-4 text-gray-500">
        <div class="">
          <a class="ml-3 text-lg font-bold text-gray-800 " href="#">
            Clever academia </a>|
          <span class="italic text-sm text-teal-600">Student</span>
          <span class="flex justify-center">
            <?php
            $sql  = "SELECT level FROM students WHERE student_id = $student_id;";
            $result = mysqli_query($link, $sql);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $levelDisplay =  $row['level'];
                if ($levelDisplay === "mentor") {
                  echo '<img src="../../images/badge-2.jpg" class="h-6 w-6" alt="">';
                }
                echo '';
              }
              mysqli_free_result($result);
            }
            ?>
          </span>
        </div>
        <ul class="mt-6">
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="./index.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              <span class="ml-4">Home</span>
            </a>
          </li>
        </ul>
        <ul>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="groups.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">Groups</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="resources.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">Resources</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="people.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">People</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="counselling.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">Counselling</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="profile.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">Profile</span>
            </a>
          </li>
        </ul>
        <?php
        //Display data into the table 
        if ($levelDisplay === "mentor") {
          echo
          "
              <div class='px-6 my-6'>
              <li class='relative list-none'>
                  <a
                    class='inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 text-white'
                    href='create_group.php'
                  >
                  <button
                    class='flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-teal-600 border border-transparent rounded-lg active:bg-teal-600 hover:bg-teal-700 focus:outline-none focus:shadow-outline-teal'
                    >
                    
                        <span class='ml-4'>Create Groups</span>
                      
                    <span class='ml-2' aria-hidden='true'>+</span>
                  </button>
                </a>
              </li>
            </div>
            ";
        } else {
          echo
          "
              <div class='px-6 my-6'>
              <li class='relative list-none'>
                  <a
                    class='inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 text-white'
                    href='application.php'
                  >
                  <button
                    class='flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-teal-600 border border-transparent rounded-lg active:bg-teal-600 hover:bg-teal-700 focus:outline-none focus:shadow-outline-teal'
                    >
                    
                        <span class='ml-4'>Become a mentor</span>
                      
                    <span class='ml-2' aria-hidden='true'>+</span>
                  </button>
                </a>
              </li>
            </div>
            ";
        }
        ?>
      </div>
    </aside>
    <!-- Mobile sidebar -->
    <!-- Backdrop -->
    <div id="isSideMenuOpen" class="hidden fixed inset-0 z-10 bg-black bg-opacity-30"></div>
    <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white md:hidden transition-all ease-in-out duration-500 delay-100 transform -translate-x-[16rem]" id="closeSideMenu">
      <div class="py-4 text-gray-500">
        <div class="">
          <a class="ml-3 text-lg font-bold text-gray-800" href="#">
            Clever academia </a>|
          <span class="italic text-sm text-teal-600">Admin</span>
        </div>

        <ul class="mt-6">
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="./index.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              <span class="ml-4">Home</span>
            </a>
          </li>
        </ul>
        <ul>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="groups.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">Groups</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="resources.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">Resources</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="people.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">People</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="counselling.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">Counselling</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 active:text-red-500" href="profile.php">
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
              </svg>
              <span class="ml-4">Profile</span>
            </a>
          </li>
        </ul>
        <div class="px-6 my-6">
          <li class="relative list-none">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 text-white" href="application.php">
              <button class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-teal-600 border border-transparent rounded-lg active:bg-teal-600 hover:bg-teal-700 focus:outline-none focus:shadow-outline-teal">

                <span class="ml-4">Become a mentor</span>

                <span class="ml-2" aria-hidden="true">+</span>
              </button>
            </a>
          </li>
        </div>
      </div>
    </aside>
    <div class="flex flex-col flex-1">
      <header class="z-10 py-4 shadow-md bg-white">
        <div class="container flex items-center justify-between h-full px-6 mx-auto text-teal-600">
          <!-- Mobile hamburger -->
          <button class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none flex items-center" id="toggleSideMenu" aria-label="Menu">
            <i class="text-2xl fa fa-bars pointer-events-none" aria-hidden="true"></i>
            <i class="text-2xl fa fa-times pointer-events-none hidden" aria-hidden="true"></i>
            <!-- <svg
                class="w-6 h-6"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"
                ></path>
              </svg> -->
          </button>
          <!-- Search input -->
          <div class="flex justify-center flex-1 lg:mr-32 ">
            <div class=" relative w-full max-w-xl mr-6 focus-within:text-teal-500">
              <div class="absolute inset-y-0 flex items-center pl-2">
                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
              </div>
              <input class="w-full px-4 py-2 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white outline-none focus:outline-2 focus:outline-teal-500" type="text" placeholder="Search" aria-label="Search" />
            </div>
          </div>
          <ul class="flex items-center flex-shrink-0 space-x-6">
            <!-- Date display -->
            <!-- Notifications menu -->
            <li class="relative">
              <button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-teal" @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu" aria-label="Notifications" aria-haspopup="true">
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                </svg>
                <!-- Notification badge -->
                <span aria-hidden="true" class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full"></span>
              </button>
              <template x-if="isNotificationsMenuOpen">
                <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeNotificationsMenu" @keydown.escape="closeNotificationsMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md" aria-label="submenu">
                  <li class="flex">
                    <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800" href="#">
                      <span>Messages</span>
                      <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full">
                        13
                      </span>
                    </a>
                  </li>
                  <li class="flex">
                    <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800" href="#">
                      <span>Sales</span>
                      <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full">
                        2
                      </span>
                    </a>
                  </li>
                  <li class="flex">
                    <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800" href="#">
                      <span>Alerts</span>
                    </a>
                  </li>
                </ul>
              </template>
            </li>
            <!-- Profile menu -->
            <li class="relative dropdown">
              <div onclick="dropdown_menu(this);" class="dropdown_button cursor-pointer text-sm font-medium text-gray-600">
                <span class="pr-2"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                <button class="user_icon align-middle rounded-full border-2 border-white outline-1 outline-teal-600 focus:outline-none">
                  <img class="object-cover w-8 h-8 rounded-full" src="<?php echo "../../images/" . $_SESSION['profile']; ?>" alt="" aria-hidden="true" />
                </button>
              </div>

              <div class="dropdown_menu text-gray-700 text-sm  bg-white absolute right-0 top-9 pt-2 rounded shadow-lg drop-shadow-xl hidden">
                <div class="py-1 px-6 hover:cursor-pointer hover:bg-gray-100">Profile</div>
                <div class="py-1 px-6 hover:cursor-pointer hover:bg-gray-100">Settings</div>
                <div class="flex border-t-[1px] font-medium hover:cursor-pointer text-teal-500 hover:bg-teal-500 hover:text-white">
                  <a class="py-2 px-6" href="../../php/logout.php">Logout</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </header>
      <main class="h-full overflow-y-auto">