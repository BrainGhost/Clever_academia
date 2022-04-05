<?php
  //Initialize the session
  session_start();

  //check if the user is already logged in, if yes then redirect him or her to the welcome page
    //check if the user is already logged in, if yes then redirect him or her to the welcome page
    if(isset($_SESSION['loggedin_admin']) && $_SESSION['loggedin_admin'] === true){
      header("location: ./admin/index.php");
      exit;
    }elseif (isset($_SESSION['loggedin_counselor']) && $_SESSION['loggedin_counselor'] === true) {
      header("location: ./counselor/index.php");
      exit;
    }
  
  //include config file
  require_once("../php/config.php");

  //Define variables and initialize with empty values
  $email = $password = "";
  $email_err = $password_err = "" ;

  //Procssing form data when is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # check if email field is empty
    if (empty(trim($_POST["email"]))) {
      $email_err = "Please enter Email. ";
    }else{
      //to prevent mysqli injection i need to add stricslashes()
      $email = stripcslashes(trim($_POST["email"])) ;
    }

    //check if the password id empty
    if (empty(trim($_POST["password"]))) {
      $password_err = "Please enter password. ";
    }else{
      $password = stripcslashes(trim($_POST["password"]));
    }

    //validate credentials 
    if (empty($email_err) && empty($password_err)) {
      # Prepare a select statement
      $sql = "SELECT doctor_id, fullname, email, password, image,  level, doctor_status FROM doctors WHERE email = ? LIMIT 1";

      if ($stmt = mysqli_prepare($link, $sql)) {
        # Bind variable to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_email);

        // Set paremeters
        $param_email = $email;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          # store result
          mysqli_stmt_store_result($stmt);

          # check if the email exits, if yes the verify password
          if (mysqli_stmt_num_rows($stmt) == 1) {
            # bind result variale
            mysqli_stmt_bind_result($stmt, $id, $fullname, $email, $hashed_password, $profile, $level, $doctor_status);
            if (mysqli_stmt_fetch($stmt)) {
              if ($doctor_status == 1) {
                if ((password_verify($password, $hashed_password)) && ($level === "counselor")) {
                  # Password is correct, so start a new session
                  session_start();
  
                  # store data in session variales
                  // Store data in session variables
                  $_SESSION["loggedin_counselor"] = true;
                  $_SESSION["id"] = $id;
                  $_SESSION["username"] = $fullname;
                  $_SESSION["email"] = $email;
                   #check if the user has an image or not
                  if ($profile !== "") {
                    $_SESSION["profile"] = $profile;
                  }else{
                    $_SESSION["profile"] = "placeholder.png";
                  }
                  $_SESSION["level"] = "counselor";
                  $_SESSION["insert_msg"] = "";
  
                  //passing primary color as session
                  $_SESSION['primary_color'] = "sky";
  
                  // Redirect user to welcome page
                  header("location: ./counselor/index.php");
                }elseif ((password_verify($password, $hashed_password)) && ($level === "admin")) {
                  # Password is correct, so start a new session
                  session_start();
  
                  # store data in session variales
                  // Store data in session variables
                  $_SESSION["loggedin_admin"] = true;
                  $_SESSION["id"] = $id;
                  $_SESSION["username"] = $fullname;
                  $_SESSION["email"] = $email;
                   #check if the user has an image or not
                  if ($profile !== "") {
                    $_SESSION["profile"] = $profile;
                  }else{
                    $_SESSION["profile"] = "placeholder.png";
                  }
                  $_SESSION["level"] = "admin";
                  $_SESSION["insert_msg"] = "";
                  //passing primary color as session
                  $_SESSION['primary_color'] = "red";
  
                  // Redirect user to welcome page
                  header("location: ./admin/index.php");
                }else {
                  # Password not valid, display a generic error
                  $login_err[] = "Invalid email or password.";
                }
              }else{
                $login_err[] = "Your account has been desactivated! Please contact the admin .";
              }
              
            }
          }else {
            # username doesn't exist, display an error message
            $login_err[] = "Invalid email or password.";
          }
        }else{
          echo "Oops! Something went wrong. Please try again later";
        }
        //close statement
        mysqli_stmt_close($stmt);
      }
    }
    // Close connection
    mysqli_close($link);
  }

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
    <link
      href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/style.css" />

    <script src="../js/app.js"></script>
    <title>Clever academia | Learning platform</title>
  </head>
  <body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50">
      <!-- feedback hot toast -->
      <?php
        if (isset($login_err)) {
          foreach($login_err as $login_err) {
            echo 
            '
            <div onclick="this.remove();" class="absolute top-7 cursor-pointer  left-1/2 -translate-x-1/2 text-gray-600 flex items-center justify-center w-80 bg-red-100 transition duration-150 ease-in-out p-1 z-50 shadow-md border border-red-200 rounded ">
              <span class="bg-red-400 grid place-items-center rounded-full mx-2 w-6 h-6">
                  <i class="fa fa-times text-white text-xs" aria-hidden="true"></i>
              </span>
              '.$login_err.'
            </div>
            ';
          }
        }
      ?>
      
      <!-- begining code -->
      <div
        class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:flex md:justify-center md:w-1/2">
            <img
              aria-hidden="true"
              class="object-contain w-full md:w-2/3 h-full"
              src="../images/businessman-looking-aside.png"
              alt="Office"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ; ?>" method="post">
                <h1 class="mb-4 text-2xl font-semibold text-gray-700">Login</h1>
                <label class="block text-sm">
                  <span class="text-gray-700">Email</span>
                  <input
                    name="email"
                    class="<?php echo (!empty($email_err)) ? "border-red-400 focus:border-red-500" : "focus:border-sky-400 border-gray-200"; ?> block w-full mt-1 px-4 py-2 text-sm focus:outline-none border  rounded"
                    placeholder="clevercampus@example.com"
                  />
                  <span class="text-xs text-red-500"><?php echo $email_err; ?></span>
                </label>
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700">Password</span>
                  <input
                    name="password"
                    class="<?php echo (!empty($password_err)) ? "border-red-400 focus:border-red-500" : "focus:border-sky-400 border-gray-200"; ?> block w-full mt-1 px-4 py-2 text-sm focus:outline-none border  rounded"
                    placeholder="**************"
                    type="password"
                  />
                  <span class="text-xs text-red-500"><?php echo $password_err; ?></span>
                </label>

                <input
                  type="submit"
                  class="block cursor-pointer w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-sky-600 border border-transparent rounded-lg active:bg-sky-600 hover:bg-sky-700 focus:outline-none focus:shadow-outline-purple"
                  value="Log in"
                >
                  

                <hr class="my-8" />

                <button
                  class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >
                  <i class="fa fa-github w-4 h-4 mr-2" aria-hidden="true"></i>
                  Github
                </button>
                <button
                  class="flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >
                  <i class="fa fa-google w-4 h-4 mr-2" aria-hidden="true"></i>
                  Google
                </button>

                <p class="mt-4">
                  <a
                    class="text-sm font-medium text-sky-600 hover:underline"
                    href="../pages/forgot-password.php"
                  >
                    Forgot your password?
                  </a>
                </p>
                
                <p class="mt-1">
                  <a
                    class="text-sm font-medium text-red-500 hover:underline"
                    href="../index.php"
                  >
                    back home
                  </a>
                </p>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://use.fontawesome.com/85775ea1ce.js"></script>
  </body>
</html>
