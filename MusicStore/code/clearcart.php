<?php
    session_start();

    if (isset($_SESSION['shopping_cart']))
    {
        unset($_SESSION['shopping_cart']);
        header("Refresh:.5; url=../cart.php?action=cartemptied");
    }
    else // If shopping cart session is empty
    {
        header("Refresh:.5; url=../cart.php?action=cartwasempty");
    }
?>