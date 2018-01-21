<?php

class AppData
{
    public static $USERID = "USERID";
    public static $USERNAME = "USERNAME";
    public static $FIRSTNAME = "FIRSTNAME";
    public static $LASTNAME = "LASTNAME";

    public static $LOGGEDIN = "LOGGEDIN";


    /**
     * Creates a Bootstrap alert div
     * @param string $message Message to be displayed
     * @param string $type Type of bootstrap alert
     * @return string Returns a string with HTML
     */
    public static function CreateAlert(string $message, string $type)
    {
        $alert = "";

        switch ($type)
        {
            case "danger":
                $alert = "<div role='alert' class='alert alert-danger'>$message</div>";
                break;
            case "success":
                $alert = "<div role='alert' class='alert alert-success'>$message</div>";
                break;
            case "warning":
                $alert = "<div role='alert' class='alert alert-warning'>$message</div>";
                break;
            default:
                $alert = "<div role='alert' class='alert alert-info'>$message</div>";
                break;
        }

        return $alert;
    }
}

?>