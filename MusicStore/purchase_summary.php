<?php
    include_once("./code/config.php"); // Include configuration file
    require_once("../MusicStoreDataLayer/UserController.php");
    require_once("../MusicStoreDataLayer/Address.php");

    if (isset($_SESSION['shopping_cart'])) // Check that shopping_cart session exists
    {
	    $price = $_SESSION['purchase_summary']['price'];
	    if (count($_SESSION['shopping_cart']) == 0) // Make sure user cannot checkout without a price value
	    {
		    header("Refresh:2; url=../cart.php?action=cartwasempty");
?>
            You cannot checkout with no items in your cart. Redirecting...
<?php
            exit();
	    }
    }
    else
    {
	    // Session is not set
	    $price = 0; // Ensure that $price is set to zero to avoid potential undefined index errors
	    header("Refresh:2; url=../cart.php?action=cartwasempty");
?>
        You cannot checkout with no items in your cart. Redirecting...
<?php
	    exit();
    }

    if (isset($_POST['submit']) && !empty($_SESSION['shopping_cart']))
    {
        $userController = new UserController();
        try
        {
            $shipAddressID = $_SESSION['shipaddressID'];
            $billAddressID = $_SESSION['billaddressID'];
            $date = date('Y-m-d');
            if ($logged_in == true)
            {
                $orderID = $userController->createNewCustomerOrder_ReturnOrderID($userID, $shipAddressID, $billAddressID, $date);

                foreach($_SESSION['shopping_cart'] as $keys => $values)
                {
                    $albumID = $values['album_id'];
                    $quantity = $values['album_quantity'];
                    $userController->createNewCustomerOrderItem($orderID, $albumID, $quantity);
                }
            }
            else
            {
                $customerID = $userController->createNewGuest_ReturnGuestCustomerID($shipAddressID, $billAddressID);
                $orderID = $userController->createNewGuestOrder_ReturnOrderID($customerID, $date);

                foreach($_SESSION['shopping_cart'] as $keys => $values)
                {
                    $albumID = $values['album_id'];
                    $quantity = $values['album_quantity'];
                    $userController->createNewGuestOrderItem($orderID, $albumID, $quantity);
                }
            }
        }
        catch (Exception $ex)
        {
            echo $ex;
            exit();
        }

        unset($_SESSION['shopping_cart']);
        unset($_SESSION['shipaddressID']);
        unset($_SESSION['billaddressID']);
        $_SESSION['orderID'] = $orderID;
        $_SESSION['date'] = $date;
        header("Refresh:2; url=../order_confirmation.php");
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

        <h2>Purchase Summary</h2>

        <!-- PURCHASE SUMMARY -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th width="40%">Item Name</th>
                    <th width="10%">Quantity</th>
                    <th width="20%">Price</th>
                    <th width="15%">Total</th>
                </tr>
                <?php
                if (!empty($_SESSION['shopping_cart'])):
                    $total = 0; // Reset total value
                    foreach($_SESSION['shopping_cart'] as $keys => $values):
                ?>
                <tr>
                    <td>
                        <?php echo $values['album_title']; ?>
                    </td>
                    <td>
                        <?php echo $values['album_quantity']; ?>
                    </td>
                    <td>
                        $ <?php echo $values['album_price']; ?>
                    </td>
                    <td>
                        <?php echo number_format($values['album_quantity'] * $values['album_price'], 2); ?>
                    </td>
                </tr>
                <?php
                        $total = $total + ($values['album_quantity'] * $values['album_price']);
                    endforeach;
                ?>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right">
                        $ <?php echo number_format($total, 2); ?>
                    </td>
                </tr>
                <?php
                endif;
                ?>
            </table>
        </div>
        <!-- DETAILS -->
        <?php
        // Get post values from a logged_in previous address selection
        if (isset($_SESSION['shipaddressID']) && isset($_SESSION['billaddressID']))
        {
            $shipAddressID = $_SESSION['shipaddressID'];
            $billAddressID = $_SESSION['billaddressID'];
            $userController = new UserController();
            try
            {
                $shipAddress = new Address();
                $shipAddress = $userController->getAddressByAddressID($shipAddressID);

                if ($shipAddress != null)
                {
                    $ship_fname = $shipAddress->FirstName;
                    $ship_lname = $shipAddress->LastName;
                    $ship_street = $shipAddress->AddressLine1;
                    $ship_city = $shipAddress->City;
                    $ship_state = $shipAddress->State;
                    $ship_zip = $shipAddress->Zip;
                }

                $billAddress = new Address();
                $billAddress = $userController->getAddressByAddressID($billAddressID);

                if ($billAddress != null)
                {
                    $bill_fname = $billAddress->FirstName;
                    $bill_lname = $billAddress->LastName;
                    $bill_street = $billAddress->AddressLine1;
                    $bill_city = $billAddress->City;
                    $bill_state = $billAddress->State;
                    $bill_zip = $billAddress->Zip;
                }

            }
            catch (Exception $ex)
            {
                echo $ex;
            }
        }
        else
        {
            echo "<script>alert('You have not entered a shipping or billing address!')</script>";
            $url = ($logged_in == true) ? "./customer_info_registered.php" : "./customer_info.php";
            header("Refresh:0; url=$url");
            exit();
        }
        ?>
        <div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Shipping Address</h4>
                        </div>
                        <div class="card-block">
                            <p class="card-text">
                                <?php echo $ship_fname . " " . $ship_lname; ?>
                                <br />
                                <?php echo $ship_street; ?>
                                <br />
                                <?php echo $ship_city . ", " . $ship_state . " " . $ship_zip; ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <?php $changeUrl = ($logged_in == true) ? "./customer_info_registered.php" : "./customer_info.php"; ?>
                            <a href="<?php echo $changeUrl; ?>" class="float-right">change</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <p>
                        <b>
                            <?php echo $bill_fname; ?>
                        </b>, you are about to purchase the items listed above. The total cost of the order to be charged is
                        <b>
                            $<?php echo number_format($total, 2); ?>
                        </b>. If you would like to confirm this transaction, please click 'Complete Purchase'.
                    </p>
                    <form method="post" role="form" action="#">
                        <div align="center">
                            <button class="btn btn-outline-success" type="submit" name="submit">Complete Purchase</button>
                        </div>
                        <input type="hidden" name="first_name" value="<?php echo $fname ?>" />
                        <input type="hidden" name="price" value="<?php echo $price ?>" />
                    </form>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Billing Address</h4>
                        </div>
                        <div class="card-block">
                            <p class="card-text">
                                <?php echo $bill_fname . " " . $bill_lname; ?>
                                <br /><?php echo $bill_street; ?>
                                <br /><?php echo $bill_city . ", " . $bill_state . " " . $bill_zip; ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <?php $changeBillUrl = ($logged_in == true) ? "./customer_info_registered.php" : "./customer_bill_info.php"; ?>
                            <a href="<?php echo $changeBillUrl; ?>" class="float-right">change</a>
                        </div>
                    </div>
                </div>
            </div>
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