<?php
include_once("./code/config.php"); // Include configuration file
require_once("../MusicStoreDataLayer/UserController.php");
require_once("../MusicStoreDataLayer/Order.php");
require_once("../MusicStoreDataLayer/Address.php");

if ($logged_in !== true)
{
    echo 'You do not have permission to view this page! Please <a href="./login.php">Log In</a>';
    exit();
}
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
            <h6>
                <span style="font-weight:bold">
                    <?php echo $user_firstname; ?>
                </span>, welcome to your custom account page.
            </h6>
            <?php if (isset($_GET['updated'])) echo "<br />" . $updateMsg; ?>
            <?php include_once("./accountnav.html"); ?>
            <br />
            <div class="row">
                <?php
                $userController = new UserController();
                try
                {
                    // Fetches array of Order class objects
                    $ordersArray = $userController->getCustomerOrdersByCustomerID($_SESSION[AppData::$USERID]);
                }
                catch (Exception $ex)
                {
                    echo $ex;
                }

                // Pull each order's items and add them to order-items array
                $order = new Order();
                foreach ($ordersArray as $order)
                {
                    $datetime = strtotime($order->Date);
                    $date = date('F j, Y', $datetime);
                ?>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <strong><?php echo $date; ?></strong>
                                </h4>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    Order ID: <?php echo $order->OrderID?>
                                </h6>
                            </div>
                            <div class="card-block row">
                                <?php
                                try
                                {
                                    $shipAddress = $userController->getAddressByAddressID($order->ShipAddressID);
                                    $billAddress = $userController->getAddressByAddressID($order->BillAddressID);
                                }
                                catch (Exception $ex)
                                {
                                    echo $ex;
                                }
                                ?>
                                <p class="card-text col-md-6">
                                    <strong>Shipped to:</strong>
                                    <br /><?php echo $shipAddress->FirstName . " " . $shipAddress->LastName; ?>
                                    <br /><?php echo $shipAddress->AddressLine1; ?>
                                    <br /><?php echo $shipAddress->City . ", " . $shipAddress->State . " " . $shipAddress->Zip ?>
                                </p>
                                <p class="card-text col-md-6">
                                    <strong>Billed to:</strong>
                                    <br /><?php echo $billAddress->FirstName . " " . $billAddress->LastName; ?>
                                    <br /><?php echo $billAddress->AddressLine1; ?>
                                    <br /><?php echo $billAddress->City . ", " . $billAddress->State . " " . $billAddress->Zip ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <form role="form" method="post" action="./account_orderitems.php">
                                    <input type="submit" id="submit" name="submit" class="btn btn-outline-primary" value="View Items Purchased" />
                                    <input type="hidden" id="orderID" name="orderID" value="<?php echo $order->OrderID; ?>" />
                                    <input type="hidden" id="orderDate" name="orderDate" value="<?php echo $date; ?>" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php

                }

                ?>
            </div>
        </div>


        <br />
        <br />
        <?php include_once("./footer.html"); ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#actOrders').addClass('active');
        });
    </script>
</body>
</html>