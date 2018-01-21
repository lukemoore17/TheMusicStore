<?php
include_once("./code/config.php"); // Include configuration file
require_once("../MusicStoreDataLayer/UserController.php");
require_once("../MusicStoreDataLayer/OrderItem.php");
require_once("../MusicStoreDataLayer/Album.php");

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
            <?php include_once("./accountnav.html"); ?>
            <br />
                <?php
                if (isset($_POST['submit']) and isset($_POST['orderID']))
                {
                ?>
            <h5>Items in your order place on <?php echo $_POST['orderDate'];?> <span class="text-muted">(Order ID: <?php echo $_POST['orderID'];?>)</span></h5>
            <br />
            <div class="row">


                <?php
                    $userController = new UserController();
                    try
                    {
                        // Fetches array of OrderItem class objects
                        $ordersItemsArray = $userController->getCustomerOrderItemsByOrderID($_POST['orderID']);

                        // Pull each order's items and add them to order-items array
                        $orderItem = new OrderItem();
                        foreach ($ordersItemsArray as $orderItem)
                        {
                            $album = $userController->getAlbumByAlbumID($orderItem->AlbumID);
                ?>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card">
                            <img class="card-img-top" src="<?php echo $album->ImageLink; ?>" />
                            <div class="card-block">
                                <h4 class="card-title"><?php echo $album->AlbumName; ?></h4>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo $album->Artist; ?> (<?php echo $album->Year; ?>)</h6>
                                <p class="card-text">
                                    <strong><?php echo $currency . $album->Price; ?></strong>
                                </p>
                            </div>
                            <div class="card-footer">
                                Quantity purchased: <strong><?php echo $orderItem->Quantity ?></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                        } // END FOREACH
                    } // END TRY
                    catch (Exception $ex)
                    {
                        echo $ex;
                    }
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