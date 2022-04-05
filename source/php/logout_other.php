<?php 
    //Initialize the session
    session_start();
    #
    session_unset();
  
    //unset all of the session variables
    $_SESSION = array();

    //Destroy the session
    session_destroy();

    //Redirect to login page
    header("location: ../component/index.php");