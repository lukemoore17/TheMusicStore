<?php
    if ($_POST['submitNewAddress'])
    {
        $error = "";

        if (!$_POST['firstname'])
        {
            $fnError = "- Enter your first name.";
            $error .= $fnError;
        }

        if (!$_POST['lastname'])
        {
            $lnError = "- Enter your last name.";
            $error .= ($error == "") ? $lnError : "<br />" . $lnError;
        }

        if (!$_POST['street'])
        {
            $srError = "- Enter your house number and street.";
            $error .= ($error == "") ? $srError : "<br />" . $srError;
        }

        if (!$_POST['city'])
        {
            $cError = "- Enter your city.";
            $error .= ($error == "") ? $cError : "<br />" . $cError;
        }

        if (!$_POST['state'])
        {
            $stError = "- Enter your state.";
            $error .= ($error == "") ? $stError : "<br />" . $stError;
        }

        if (!$_POST['zip'])
        {
            $zError = "- Enter your zip code.";
            $error .= ($error == "") ? $zError : "<br />" . $zError;
        }
    }
?>