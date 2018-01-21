<?php
    include_once("./code/config.php"); // Include configuration file

    if (isset($_POST['add_to_cart'])) // Check that data has been posted
    {
        if (isset($_SESSION['shopping_cart'])) // Check that shopping_cart session exists
        {
            // Assign album_id column from session data to a variable
            $item_array_id = array_column($_SESSION['shopping_cart'], 'album_id');

            // Check that item_id is not already in the array
            if (!in_array($_GET['albumID'], $item_array_id))
            {
                // Count number of elements in session array 'shopping_cart'
                $count = count($_SESSION['shopping_cart']);
                // Assign session array data with keys that can be called in future script
                $item_array = array(
                                        'album_id'       => $_GET['albumID'],
                                        'album_title'     => $_POST['hidden_title'],
                                        'album_price'    => $_POST['hidden_price'],
                                        'album_quantity' => $_POST['quantity']
                                    );
                $_SESSION['shopping_cart'][$count] = $item_array;
                /*
                 * Sets array index as next numeric value
                 * ($count will always be one number greater than last index number b/c shopping cart is zero-indexed)
                 */
            }
            else // Executes following script if album_id is already found is already in cart
            {
                echo '<script>alert("Item Already Added!")</script>'; // Notify user that item is already in cart
                echo '<script>window.location="shop.php"</script>'; // Make sure user stays on products page
            }
        }
        else // If shopping_cart session is not set
        {
            $item_array = array(
                'album_id'       => $_GET['albumID'],
                'album_title'     => $_POST['hidden_title'],
                'album_price'    => $_POST['hidden_price'],
                'album_quantity' => $_POST['quantity']
            );
            /*
             * Assign session array data with keys that can be called in future script.
             * (Still needed even though there are no items in cart, so that the shopping cart page will still display with no items in cart.)
             *
             */
            $_SESSION['shopping_cart'][0] = $item_array; // Shopping cart is empty... set to first index

        }
    }

    if (isset($_GET['action'])) // Check that the action attribute is set
    {
        switch ($_GET['action'])
        {
            case "delete" :
                foreach ($_SESSION['shopping_cart'] as $keys => $values) // For each item from shopping cart
                {
                    if ($values['album_id'] == $_GET['id']) // Check that item_id equals id retrieved from DELETE href link
                    {
                        unset ($_SESSION['shopping_cart'][$keys]); // Deletes item from shopping cart array
                        $message = "<div class='alert alert-warning' role='alert'>Item removed!</div>";
                    }
                }
                break;
            case "cartemptied" :
                $message = "<div class='alert alert-warning' role='alert'>Cart emptied!</div>";
                break;
            case "cartwasempty" :
                $message = "<div class='alert alert-danger' role='alert'>There is nothing in your cart!</div>";
                break;
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
    <link href="styles/styles.css" rel="stylesheet" />
</head>

<body>
    <div id="PageWrapper" class="container container-fluid">
        <?php include_once("./header.php"); ?>
        <br />
        <h2>Items in Cart</h2>
        <?php echo $message; ?>
        <div class="table-responsive">
	        <table class="table table-bordered">
		        <tr>
			        <th width="40%">Album Title</th>
			        <th width="10%">Quantity</th>
			        <th width="20%">Price</th>
			        <th width="15%">Total</th>
			        <th width="5%">Action</th>
		        </tr>
		        <?php
		        if (!empty($_SESSION['shopping_cart'])):
			        $total = 0;
			        foreach($_SESSION['shopping_cart'] as $keys => $values):
                ?>
		        <tr>
			        <td><?php echo $values['album_title']; ?></td>
			        <td><?php echo $values['album_quantity']; ?></td>
			        <td>$ <?php echo $values['album_price']; ?></td>
			        <td><?php echo number_format($values['album_quantity'] * $values['album_price'], 2); ?></td>
			        <td>
                        <form method="post" action="./cart.php?action=delete&id=<?php echo $values['album_id']; ?>">
                            <button class="btn btn-outline-danger">Remove</button>
                        </form>
                    </td>
		        </tr>
		        <?php
                        $total = $total + ($values['album_quantity'] * $values['album_price']);
			        endforeach;
                ?>
		        <tr>
			        <td colspan="3" align="right">Total</td>
			        <td align="right">$ <?php echo number_format($total, 2); ?></td>
			        <td></td>
		        </tr>
		        <?php
		        endif;
                ?>
	        </table>
        </div>

		<table class="options">
		<tr>                      
            <?php
                if (isset($total))
                {
                    $price = $total;
                    $link = ($logged_in == true) ? './customer_info_registered.php' : './customer_info.php';
                    // Display checkout and clear cart buttons if cart has items
            ?>
                <td><form action="./code/clearcart.php"><button class="btn btn-outline-danger">Clear Cart</button></form></td>
			    <td><form action="./shop.php"><button class="btn btn-outline-primary" type="submit">Continue Shopping</button></form></td> 
                <td>
                    <form method="post" action="<?php echo $link; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; // Total price will be passed thru POST method ?>">
                        <button class="btn btn-outline-success" type="submit">Checkout</button>
                    </form>
                </td>
                <?php
                }
                else // If not, set $price equal to 0 so that the value can be checked when submitting shop cart to customer_info.php
                {
                    $price = 0;
                ?>
                <td><form action="./shop.php"><button class="btn btn-outline-primary" type="submit">Continue Shopping</button></form></td>
                <?php
                }
                ?>            	
		</tr>
		</table>

        <br />
        <br />
        <?php include_once("./footer.html"); ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>