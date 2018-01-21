<?php
    include_once("./code/config.php"); // Include configuration file

    if ($logged_in !== true)
    {
        echo 'You do not have permission to view this page! Please <a href="./login.php">Log In</a>';
        exit();
    }

    if ($_GET['uploaderror'])
    {
        $errorType = $_GET['uploaderror'];
        $errorMsg = "";

        switch ($errorType)
        {
            case 'size':
                $errorMsg = "<div class='alert alert-danger' role='alert'>- The file is too big. Please select a picture smaller than 2 MB.</div>";
                break;
            case 'general':
                $errorMsg = "<div class='alert alert-danger' role='alert'>- Sorry, there was an error while uploading your file.</div>";
                break;
            case 'type':
                $errorMsg = "<div class='alert alert-danger' role='alert'>- Invalid file type. Please select a JPEG or PNG file.</div>";
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
</head>

<body>
    <div id="PageWrapper" class="container container-fluid">
        <?php include_once("./header.php"); ?>

        <br />

        <div class="container container-fluid">
            <h6><span style="font-weight:bold"><?php echo $user_firstname; ?></span>, welcome to your custom account page.</h6>
            <br />
            <?php include_once("./accountnav.html"); ?>
            <br />
            <p>Here you can upload some pictures of your favorite artists...</p>
            <br />
            <div class="row">
                <div class="col-md-6">
                    <?php
                        if ($_GET['uploaderror'])
                        {
                            echo $errorMsg;
                        }
                    ?>


                    <form action="./code/uploadpicture.php" method="post" enctype="multipart/form-data">
                        <div class="input-group">
                            <label for="photo-selector" class="input-group-btn">
                                <span class="btn btn-outline-primary">
                                    Select a picture...
                                    <input id="photo-selector" type="file" name="file" style="display:none;"
                                        onchange="$('#upload-photo-info').html(this.files[0].name)"
                                        accept=".jpg,.jpeg,.png" />
                                </span>
                            </label>
                            <br />
                            <span id="upload-photo-info" class="form-control" readonly>No file selected</span>
                            <br />
                            <button class="btn btn-outline-success" type="submit" name="submit">UPLOAD</button>
                        </div>
                        <span class="form-text text-muted">Please select only JPEG or PNG files that are no more than 2 MB.</span>
                    </form>
                </div>
            </div>
            <br />
            <br />
            <div class="row">
                <?php
                    $imageDirectory = './uploads/' . $username . '/';
                    $images = glob($imageDirectory.'*.*');

                    if (is_dir($imageDirectory))
                    {
                        foreach ($images as $img)
                        {
                ?>
                        <div class="col-md-6">
                            <img src="<?php echo $img; ?>" class="rounded img-fluid" />
                            <br />
                            <br />
                        </div>
                <?php
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
            $('#actPics').addClass('active');
        });
    </script>
</body>
</html>