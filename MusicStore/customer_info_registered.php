<?php
    include_once("./code/config.php"); // Include configuration file
    require_once("../MusicStoreDataLayer/UserController.php");
    require_once("../MusicStoreDataLayer/Address.php");

    if ($logged_in !== true)
    {
        header('Location: ../customer_info.php');
        exit();
    }

    if (isset($_SESSION['shopping_cart'])) // Check that shopping_cart session exists
    {

        $_SESSION['price'] = (isset($_POST['price'])) ? $_POST['price'] : $_SESSION['price'];
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
	    $_SESSION['price'] = 0; // Ensure that $price is set to zero to avoid potential undefined index errors
	    header("Refresh:2; url=../cart.php?action=cartwasempty");
?>
        You cannot checkout with no items in your cart. Redirecting...
<?php
	    exit();
    }

    // Validate that address is selected
    if ($_POST['submitUserAddress'])
    {
        if (isset($_POST['shipaddress']))
        {
            if ($_POST['isBillSame'] == true)
            {
                $_SESSION['shipaddressID'] = $_POST['shipaddress'];
                $_SESSION['billaddressID'] = $_POST['shipaddress'];
                header("Refresh:.5; url=../purchase_summary.php");
                exit();
            }
            else
            {
                if (isset($_POST['billaddress']))
                {
                    $_SESSION['shipaddressID'] = $_POST['shipaddress'];
                    $_SESSION['billaddressID'] = $_POST['billaddress'];
                    header("Refresh:.5; url=../purchase_summary.php");
                    exit();
                }
                else
                {
                    $errorMsg = "<div class='alert alert-danger' role='alert'>You must select a billing address</div><br />";
                }
            }
        }
        else
        {
            $errorMsg = "<div class='alert alert-danger' role='alert'>You must select a shipping address</div><br />";
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
        <section id="savedAddresses">
            <div class="container container-fluid">
                <form method="post" role="form" action="./customer_info_registered.php">
                    <!-- BEGIN: SELECT PREVIOUS ADDRESS -->
                    <div class="form-group">
                        <h5>Please select a shipping address</h5>
                        <br />
                        <?php echo $errorMsg; ?>
                        <div data-toggle="buttons">
                            <?php
                              $userController = new UserController();
                              try
                              {
                                  $userAddresses = $userController->getCustomerAddressesByCustomerID($userID);
                                  $address = new Address();
                                  foreach ($userAddresses as $address) :
                            ?>
                            <!--<div class="col-sm-6">-->
                            <label class="btn btn-outline-primary">
                                <input id="<?php echo $address->AddressID; ?>" name="shipaddress" type="radio" value="<?php echo $address->AddressID; ?>" autocomplete="off" />
                                
                                <?php echo $address->FirstName . " " . $address->LastName; ?>
                                <br />
                                <?php echo $address->AddressLine1; ?>
                                <br />
                                <?php echo $address->City . ", " . $address->State . " " . $address->Zip; ?>
                                <br />
                            </label>
                            <!--</div>-->
                            <?php
                                  endforeach;
                              }
                              catch (Exception $ex)
                              {
                                  echo $ex;
                              }
                            ?>
                        </div>
                    </div>
                    <label>
                        <input type="checkbox" name="isBillSame" id="isBillSame" checked="checked" />
                        Billing address same as shipping
                    </label>
                    <br />
                    <br />
                    <div id="billAddress" class="form-group">
                        <h5>Please select a billing address</h5>
                        <br />
                        <div data-toggle="buttons">
                            <?php
                            $userController = new UserController();
                            try
                            {
                                $userAddresses = $userController->getCustomerAddressesByCustomerID($userID);
                                $address = new Address();
                                foreach ($userAddresses as $address) :
                            ?>
                            <!--<div class="col-sm-6">-->
                            <label class="btn btn-outline-primary">
                                <input id="<?php echo $address->AddressID; ?>" name="billaddress" type="radio" value="<?php echo $address->AddressID; ?>" autocomplete="off" />
                                
                                <?php echo $address->FirstName . " " . $address->LastName; ?>
                                <br />
                                <?php echo $address->AddressLine1; ?>
                                <br />
                                <?php echo $address->City . ", " . $address->State . " " . $address->Zip; ?>
                                <br />
                            </label>
                            <!--</div>-->
                            <?php
                                endforeach;
                            }
                            catch (Exception $ex)
                            {
                                echo $ex;
                            }
                            ?>
                        </div> 
                    </div>
                    <input type="hidden" name="price" value="<?php echo $_SESSION['price']; ?>" />
                    <br />
                    <div align="center">
                        <input type="submit" id="submitUserAddress" name="submitUserAddress" class="btn btn-primary" value="Continue Checkout" />
                    </div>
                    <div align="center">
                        <br />
                        <a href="customer_info_new.php?action=checkout">Or create a new address...</a>
                    </div>
                    <br />   
                </form>
            </div>
            <!-- END: SELECT PREVIOUS ADDRESS -->
        </section>

        <br />
        <br />
        <?php include_once("./footer.html"); ?>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    
    <script>
        $(document).ready(function () {
            $("#billAddress").hide();
            $('#isBillSame').click(function () {
                if ($(this).is(":checked")) {
                    $("#billAddress").hide(200);
                } else {
                    $("#billAddress").show(300);
                }
            });
        });
    </script>
</body>
</html>