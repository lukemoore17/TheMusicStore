<?php
    require_once("config.php"); // Include configuration file

    if ($logged_in === true)
    {
        unset($_SESSION[AppData::$LOGGEDIN]);
        unset($_SESSION[AppData::$USERNAME]);
        unset($_SESSION[AppData::$USERID]);
        unset($_SESSION[AppData::$FIRSTNAME]);
        unset($_SESSION[AppData::$LASTNAME]);
        header( "Refresh:2; url=../index.php");
?>
        Logging you out, please wait...
<?php
        exit();
    }
    else
    {
        header( "Refresh:2; url=../index.php");
?>
        Access Denied! You are being redirected...
<?php
    }
?>