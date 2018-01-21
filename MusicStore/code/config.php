<?php
    //error_reporting(E_ERROR | E_WARNING | E_PARSE);
    session_start();
    require_once("AppData.php");

    // START APPDATA OBJECT
    //$AppData = new AppData();

    if (isset($_SESSION[AppData::$LOGGEDIN]))
    {
    // && isset($_SESSION[$AppData::USERNAME]) && isset($_SESSION[$AppData::USERID])
        if ($_SESSION[AppData::$LOGGEDIN] == true)
        {
            $logged_in = true;
            $username = $_SESSION[AppData::$USERNAME];
            $userID = $_SESSION[AppData::$USERID];
            $user_firstname = $_SESSION[AppData::$FIRSTNAME];
            $user_lastname = $_SESSION[AppData::$LASTNAME];
        }
        else
        {
            $logged_in = false;
            $username = null;
            $userID = null;
            $user_firstname = null;
            $user_lastname = null;
        }
    }
    else
    {
        $logged_in = false;
        $username = null;
        $userID = null;
        $user_firstname = null;
        $user_lastname = null;
    }

    $currency = '&#36;'; // currency character usd
?>