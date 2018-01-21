<?php
    include_once("./code/config.php"); // Include configuration file
    require_once("../MusicStoreDataLayer/UserController.php");
    require_once("../MusicStoreDataLayer/Address.php");

    if (isset($_SESSION['shopping_cart'])) // Check that shopping_cart session exists
    {
	    $_SESSION['price'] = $_POST['price'];
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
	    $_SESSION['price'] = 0; // Ensure that price is set to zero to avoid potential undefined index errors
	    header("Refresh:2; url=../cart.php?action=cartwasempty");
?>
        You cannot checkout with no items in your cart. Redirecting...
<?php
	    exit();
    }

    // Require form validation script
    require_once("./code/customer_info_validate.php");

    if ($error !== "")
    {
        $errorResult = $error;
    }
    else if (isset($_POST['submitNewAddress']))
    {
        $userController = new UserController();
        try
        {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $addressline1 = $_POST['street'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $zip = $_POST['zip'];

            $output = "";

            // Create a new address in the database
            $addressID = $userController->createNewAddress_ReturnAddressID($firstname, $lastname, $addressline1, "" , $city, $state, $zip);

            // If logged-in add the address to customer address history
            if ($logged_in == true)
            {
                $userController->createNewCustomerAddress($userID, $addressID);
            }
        }
        catch (Exception $ex)
        {
            echo $ex;
            exit();
        }

        $_SESSION['shipaddressID'] = $addressID;
        if ($_POST['billIsSame'] == true)
        {
            $_SESSION['billaddressID'] = $addressID;
            header("Refresh:.5; url=../purchase_summary.php");
            exit();
        }
        else
        {
            header("Refresh:.5; url=../customer_bill_info.php");
            exit();
        }
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
        <section id="customerInfoSection">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <br />

                        <form method="post" role="form">
                            <h5 class="form-group">Customer Shipping Information</h5>
                            <?php if ($errorResult != "") : ?>
                            <div class="alert alert-danger" role="alert">
                                <span style="font-weight:bold">Please fix the following:</span>
                                <br />
                                <?php echo $errorResult; ?>
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" name="firstname" placeholder="Enter first name"
                                    value="<?php echo $_POST['firstname']; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" name="lastname" placeholder="Enter last name"
                                    value="<?php echo $_POST['lastname']; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="street" placeholder="Street"
                                    value="<?php echo $_POST['street']; ?>" />
                                <input type="text" class="form-control" name="city" placeholder="City"
                                    value="<?php echo $_POST['city']; ?>" />
                                <input type="text" class="form-control" name="state" placeholder="State"
                                    value="<?php echo $_POST['state']; ?>" />
                                <input type="text" class="form-control" name="zip" placeholder="Zip Code"
                                    value="<?php echo $_POST['zip']; ?>" />

                                <input type="hidden" name="price" value="<?php echo $_SESSION['price']; ?>" />
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="billIsSame" id="billIsSame" checked="checked" />
                                    Billing address same as shipping
                                </label>
                            </div>
                            <br />
                            <div align="center">
                                <input type="submit" id="submitNewAddress" name="submitNewAddress" class="btn btn-primary" value="Continue Checkout" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <br />
        <br />
        <?php include_once("./footer.html"); ?>
    </div>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

</body>
</html>