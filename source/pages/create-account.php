<?php
  //include config file
  require_once("../php/config.php");

  //Define variables and initialize with empty values
  $username = $password = $confirm_password = $email = "";
  $username_err = $password_err = $confirm_password_err = $email_err = "";

  //Procssing form data when is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validation of inputs
    if (empty(trim($_POST['username']))) {
      $username_err = "Please enter a username.";
    }elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
      $username_err = "Username can only contain letters, numbers, and underscores.";
    }else{
      //prepare a select statement
      $sql = "SELECT cred_id FROM credentials WHERE username = ?";
      if ($stmt = mysqli_prepare($link, $sql)) {
        # Bind variales to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        # Set parameters
        $param_username = trim($_POST["username"]);

        #Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          # Store result
          mysqli_stmt_store_result($stmt);

          
            if(mysqli_stmt_num_rows($stmt) == 1){
              $username_err = "This username is already taken.";
            } else{
              $username = trim($_POST["username"]);
            }   
        }else {
          echo "Oops! Something went wrong. please try later.";
        }
        //close statement
        mysqli_stmt_close($stmt);
      } 
    }
    //validate email
    if (empty(trim($_POST["email"]))) {
      $email_err = "Please enter an email.";
    }else {
      $email = trim($_POST["email"]);
    }
    //Validate password
    if(empty(trim($_POST["password"]))){
      $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
      $password_err = "Password must have atleast 6 characters.";
    } else{
      $password = trim($_POST["password"]);
    }
    //validate re_password
    if (empty(trim($_POST["confirm_password"]))) {
      # code...
      $confirm_password_err = "Please confirm password.";
    }else{
      $confirm_password = trim($_POST["confirm_password"]);
      if (empty($password_err) && ($password != $confirm_password)) {
        $confirm_password_err = "Password does not match.";
      }
    }
    //Check inout errors before insetering in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
      # Prepare insert data in the database table
      $default_level = 'student';
      $sql = "INSERT INTO credentials(username, email, password, level) VALUES ( ?, ?, ?, '$default_level')";

      if ($stmt = mysqli_prepare($link, $sql)) {
        # Bind variale to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);

        //set parameters
        $param_username = $username;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);//creates a password hash

        //Atempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
          # Redirect to login
          header("location: login.php");
        }else{
          echo "Oops! Something went wrong. Please try again later.";
        }
        //Close statment
        mysqli_stmt_close($stmt);
      }
    }
    //Close connection
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
      <div
        class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2 md:flex md:justify-center">
            <img
              aria-hidden="true"
              class="object-contain w-full md:w-2/3 h-full"
              src="../img/man-jumping.png"
              alt="Office"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h1 class="mb-4 text-2xl font-semibold text-gray-700">
                  Create account
                </h1>
                <label class="block text-sm">
                  <span class="text-gray-700">Name</span>
                  <input
                    name="username"
                    class="<?php echo (!empty($username_err)) ? "border-red-400 focus:border-red-500" : "focus:border-teal-400 border-gray-200"; ?> block tracking-wider w-full mt-1 text-sm  focus:outline-none focus:shadow-outline-teal border rounded px-4 py-2"
                    placeholder="Balibonera_Junior"
                    value="<?php echo $username; ?>"
                  />
                  <span class="text-xs text-red-500"><?php echo $username_err; ?></span>
                </label>
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700">Email</span>
                  <input
                    name="email"
                    class="<?php echo (!empty($email_err)) ? "border-red-400 focus:border-red-500" : "focus:border-teal-400 border-gray-200"; ?> block tracking-wider w-full mt-1 text-sm focus:outline-none focus:shadow-outline-teal border rounded px-4 py-2"
                    placeholder="clevercampus@example.com"
                    type="email"
                    value="<?php echo $email; ?>"
                  />
                  <span class="text-xs text-red-500"><?php echo $email_err; ?></span>
                </label>
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700">Password</span>
                  <input
                    name="password"
                    class="<?php echo (!empty($password_err)) ? "border-red-400 focus:border-red-500" : "focus:border-teal-400 border-gray-200"; ?> block tracking-wider w-full mt-1 text-sm focus:outline-none focus:shadow-outline-teal border rounded px-4 py-2"
                    placeholder="***************"
                    type="password"
                    value="<?php echo $password; ?>"
                  />
                  <span class="text-xs text-red-500"><?php echo $password_err; ?></span>
                </label>
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700"> Confirm password </span>
                  <input
                    name="confirm_password"
                    class="<?php echo (!empty($confirm_password_err)) ? "border-red-400 focus:border-red-500" : "focus:border-teal-400 border-gray-200"; ?> block tracking-wider w-full mt-1 text-sm focus:outline-none focus:shadow-outline-teal border rounded px-4 py-2"
                    placeholder="***************"
                    type="password"
                    value="<?php echo $confirm_password; ?>"
                  />
                  <span class="text-xs text-red-500"><?php echo $confirm_password_err; ?></span>
                </label>

                <div class="flex mt-6 text-sm">
                  <label class="flex items-center">
                    <input
                      type="checkbox"
                      class="text-teal-600 form-checkbox focus:border-teal-400 focus:outline-none focus:shadow-outline-teal border border-gray-200 rounded px-4 py-2"
                    />
                    <span class="ml-2">
                      I agree to the
                      <span class="underline">privacy policy</span>
                    </span>
                  </label>
                </div>

                <!-- You should use a button here, as the anchor is only used for the example  -->
                <input
                  type="submit"
                  class="block cursor-pointer w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-teal-600 border border-transparent rounded-lg active:bg-teal-600 hover:bg-teal-700 focus:outline-none focus:shadow-outline-teal"
                  value="Create account"
                >
                  

                <hr class="my-8" />

                <button
                  class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >
                  <svg
                    class="w-4 h-4 mr-2"
                    aria-hidden="true"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                  >
                    <path
                      d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"
                    />
                  </svg>
                  Github
                </button>
                <button
                  class="flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >
                  <svg
                    class="w-4 h-4 mr-2"
                    aria-hidden="true"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                  >
                    <path
                      d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"
                    />
                  </svg>
                  Twitter
                </button>

                <p class="mt-4">
                  <a
                    class="text-sm font-medium text-teal-600 hover:underline"
                    href="./login.php"
                  >
                    Already have an account? Login
                  </a>
                </p>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
