<?php
    include_once("./code/config.php"); // Include configuration file
    require_once("../MusicStoreDataLayer/UserController.php");
    require_once("../MusicStoreDataLayer/Album.php");
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

        <!-- BEGIN ALBUMS SECTION -->
        <section id="MainContent" class="container-fluid">
            <!-- BEGIN ALBUMS DIV-->
            <div class="row">  
                <?php
                    $userController = new UserController();
                    try
                    {
                        // Fetches array of Album class objects
                        $albumsArray = $userController->getAllAlbums();
                    }
                    catch (Exception $ex)
                    {
                        echo $ex;
                    }

                    $album = new Album();
                    foreach ($albumsArray as $album):
                ?>
                <div class="col-md-4" style="padding:15px;">
                    <form method="post" action="./cart.php?action=add&albumID=<?php echo $album->AlbumID; ?>">
                        <div style="position:relative; border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
                            <img src="<?php echo $album->ImageLink; ?>" class="img-responsive" />
                            <br />
                            <h4 class="text-info">
                                <?php echo $album->AlbumName; ?>
                            </h4>
                            <p class="text-info">
                                <?php echo $album->Artist . " (" . $album->Year . ")"; ?>
                            </p>
                            <h4 class="text-danger">
                                <?php echo $currency . " " . $album->Price; ?>
                            </h4>
                            <p class="text-info">Qty:</p>
                            <input type="text" name="quantity" class="form-control" value="1" style="width:50px;" />
                            <input type="hidden" name="hidden_title" value="<?php echo $album->AlbumName; ?>" />
                            <input type="hidden" name="hidden_price" value="<?php echo $album->Price; ?>" />
                            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
                        </div>
                    </form>
                </div>

                <?php
		            endforeach;
                ?>

                <br />
                <br />
            </div>
            <!-- END ALBUMS DIV -->
        </section>
        <!-- END ALBUMS SECTION -->
        <?php include_once("./footer.html"); ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#navShop').addClass('active');
        });
    </script>
</body>
</html>