<?php
if ($_POST['submit'])
{
    $error = "";

    if (!$_POST['firstname'])
    {
        $fnError = "- Please enter your first name.";
        $error .= $fnError;
    }
    if (!$_POST['lastname'])
    {
        $lnError = "- Please enter your last name.";
        $error .= ($error == "") ? $lnError : "<br />" . $lnError;
    }
    if (!$_POST['email'])
    {
        $emError = "- Please enter your email.";
        $error .= ($error == "") ? $emError : "<br />" . $emError;
    }
    else
    {
        $em = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $emError = (!filter_var($em, FILTER_VALIDATE_EMAIL)) ? "- Invalid email format" : "";
        if ($emError != "" && $error == "")
        {
            $error .= $emError;
        }
        else if ($emError != "")
        {
            $error .= "<br />" . $emError;
        }

        if (!$_POST['confirmemail'])
        {
            $ceError = "- Please confirm your email.";
            $error .= ($error == "") ? $ceError : "<br />" . $ceError;
        }
        else
        {
            $ce = filter_var($_POST['confirmemail'], FILTER_SANITIZE_EMAIL);
            $emError = ($em != $ce) ? "- Emails do not match" : "";
            if ($emError != "" && $error == "")
            {
                $error .= $emError;
            }
            else if ($emError != "")
            {
                $error .= "<br />" . $emError;
            }
        }
    }
    if (!$_POST['username'])
    {
        $unError = "- Please enter your username.";
        $error .= ($error == "") ? $unError : "<br />" . $unError;
    }
    else
    {
        $uname = $_POST['username'];
        $checkUsername = new UserController();
        if ($checkUsername->checkIfUsernameExists($uname) === true)
        {
            $unError = "- Username already exists! Please choose another one.";
            $error .= ($error == "") ? $unError : "<br />" . $unError;
        }
    }
    if (!$_POST['password'])
    {
        $pwError = "- Please enter your password.";
        $error .= ($error == "") ? $pwError : "<br />" . $pwError;
    }
    else
    {
        if (!$_POST['confirmpassword'])
        {
            $cpError = "- Please confirm your password.";
            $error .= ($error == "") ? $cpError : "<br />" . $cpError;
        }
        else
        {
            if ($_POST['confirmpassword'] != $_POST['password'])
            {
                $cpError = "- Passwords do not match.";
                $error .= ($error == "") ? $cpError : "<br />" . $cpError;
            }
            else if (strlen($_POST['password']) < 6)
            {
                $plError = "- Password not long enough.";
                $error .= ($error == "") ? $plError : "<br />" . $plError;
            }
        }
    }
}
?>