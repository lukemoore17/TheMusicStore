<?php
    include_once("./code/config.php"); // Include configuration file
    require_once("../MusicStoreDataLayer/UserController.php");
    require_once("../MusicStoreDataLayer/User.php");

    if ($_POST['submit'])
    {
        $error = "";

        if (!$_POST['username'])
        {
            $unError = "- Please enter your username.";
            $error .= $unError;
        }
        if (!$_POST['password'])
        {
            $pwError = "- Please enter your password.";
            $error .= ($error == "") ? $pwError : "<br />" . $pwError;
        }

        if ($error)
        {
            $errorResult = "<div class='alert alert-danger' role='alert'>$error</div>";
        }
        else
        {
            $userController = new UserController();
            try
            {
                $un = stripslashes(htmlspecialchars($_POST['username']));
                $pw = stripslashes(htmlspecialchars($_POST['password']));

                if ($userController->verifyCredentials($un, $pw) === true)
                {
                    $currentUser = new User();
                    $currentUser = $userController->getUserByUsername($un);

                    if ($currentUser != null)
                    {
                        $_SESSION[AppData::$LOGGEDIN] = true;
                        $_SESSION[AppData::$USERNAME] = $currentUser->Username;
                        $_SESSION[AppData::$USERID] = $currentUser->CustomerID;
                        $_SESSION[AppData::$FIRSTNAME] = $currentUser->FirstName;
                        $_SESSION[AppData::$LASTNAME] = $currentUser->LastName;
                        header( "Refresh:2; url=../account.php");
?>
                        Logging you in, please wait...
<?php
                        exit();
                    }
                    else
                    {
                        $error = "- There was an error while logging you in.";
                        $errorResult = "<div class='alert alert-danger' role='alert'>$error</div>";
                    }
                }
                else
                {
                    $error = "- Invalid username and/or password.";
                    $errorResult = "<div class='alert alert-danger' role='alert'>$error</div>";
                }
            }
            catch (Exception $ex)
            {
                echo $ex;
            }
        }
    }
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Welcome to The Music Store</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <div id="PageWrapper" class="container container-fluid">
        <?php include_once("./header.php"); ?>
     
        <?php if ($_GET['action'] == "newuser") : ?>
        <div class="alert alert-success" role="alert">
            Your account has been created successfully. Please log in to continue.
        </div>
        <?php endif; ?>

        <section id="loginSection">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <br />
                        <br />
                        <form method="post" role="form">
                            <h5 class="form-group">Please Log In</h5>
                            <?php echo $errorResult; ?>
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" value="<?php echo $_POST['username'] ?>" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" />
                            </div>
                            <div align="center">
                                <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Log In" />
                            </div>
                            <br />
                            <div class="form-group" style="text-align:center">
                                <a href="./new_user_registration.php">Not registered? Create an account here</a>
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