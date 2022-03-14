<?php
  
  //Display server error
  $error = $_SERVER["REDIRECT_STATUS"];

  $error_title = "";
  $error_message = "";
  
  if ($error == 404) {
    $error_title = "Oops!! Page not found";
    $error_message = "Sorry we couldn't find this page.";
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
    <!-- <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/style.css" /> -->
    <!-- <link rel="stylesheet" href="./clever_campus/source/css/main.css">
    <link rel="stylesheet" href="./clever_campus/source/css/style.css"> -->

    <title>Clever academia | Learning platform</title>
    <style>
      *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
      }
      .container{
        background-color: white;
        width: 100%;
        height: 100vh;
        display: grid;
        place-items: center;
      }
      .container > div.notfound{
        padding: 0.2rem;
      }
      div.notfound  h1{
        font-weight: 500;
        color: rgb(55 65 81);
        font-size: 1.25rem;
        line-height: 1.75rem;
        text-align: center;
      }
      div.notfound  span{
        font-weight: 800;
        color: rgb(13 148 136);
        letter-spacing: 0.1em;
        font-size: 10rem;
        text-align: center;
      }
      .div_btn{
        display: flex;
        justify-content: center;
      }
      .div_btn button{
        padding: 0.5rem 1rem;
        margin-top: 1rem;
        background-color: rgb(13 148 136);
        border-radius: 9999px;
        border: none;
      }
      .div_btn button > a{
        text-decoration: none;
        color: white;
        text-transform: uppercase;
        font-size: 0.875rem;
        line-height: 1.25rem;
      }
      .div_btn button:hover{
        background-color: rgb(15 118 110);
        cursor: pointer;
      }
      @media (min-width: 768px) {
        div.notfound  span {
          font-size: 20rem;
        }
      }
    </style>
  </head>
  <body>
    <div class="container bg-white w-full h-screen grid place-items-center">
      <div class="notfound p-2">
        <h1 class="font-medium text-gray-700 text-xl text-center">
          <?php echo $error_title; ?>
        </h1>
        <span
          class="text-teal-600 text-[10rem] md:text-[20rem] font-extrabold tracking-widest"
          ><?php echo $error; ?></span
        >
        <h1 class="font-medium text-gray-700 text-xl text-center">
          <?php echo $error_message; ?>
        </h1>
        <div class="div_btn flex justify-center">
          <button
            class="px-4 py-2 mt-4 text-sm text-white uppercase rounded-full bg-teal-600 hover:bg-teal-700"
          >
            <a href="../../index.php"> Go back home </a>
          </button>
        </div>
      </div>
    </div>
    <script src="./js/app.js"></script>
  </body>
</html>
