<?php
    include_once("./code/config.php"); // Include configuration file
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <div id="PageWrapper" class="container container-fluid">
        <?php include_once("./header.php"); ?>
        <br />

        <div class="container container-fluid">
            <h4>Order Confirmed</h4>
            <?php
            if ($logged_in == true)
                echo "<h5>$user_firstname</h5>";
            ?>
            <p>Your order, placed on <strong><?php echo $_SESSION['date']?></strong>, has been processed, and it will ship soon.</p>
            <p>Your order id is <strong><?php echo $_SESSION['orderID']; ?></strong>.</p>
            <br />
            <?php
            if ($logged_in == true)
            {
            ?>
            <p>You can view your order history at any time on <a href="account_orders.php">your account</a>.</p>
            <?php
            }
            else
            {
            ?>
            <p>Next time, if you <a href="new_user_registration.php">create an account</a>, your order will be saved in your order history.</p>
            <?php 
            } 
            ?>
        </div>


        <br />
        <br />
        <?php include_once("./footer.html"); ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>
<?php
unset($_SESSION['orderID']);
unset($_SESSION['date']);
?>