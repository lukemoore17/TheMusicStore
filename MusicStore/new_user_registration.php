<?php
include_once("./code/config.php"); // Include configuration file
require_once("../MusicStoreDataLayer/UserController.php");
require_once("../MusicStoreDataLayer/User.php");

// Require form validation script
require_once("./code/new_user_validateform.php");

    if ($error !== "")
    {
        $errorResult = $error;
    }
    else
    {
        $userController = new UserController();
        try
        {
            $fname = stripslashes(htmlspecialchars($_POST['firstname']));
            $lname = stripslashes(htmlspecialchars($_POST['lastname']));
            $un = stripslashes(htmlspecialchars($_POST['username']));
            $pw = stripslashes(htmlspecialchars($_POST['password']));
            $email = stripslashes(htmlspecialchars($_POST['email']));

            if ($userController->createNewUser($fname, $lname, $un, $pw, $email) === true)
            {
                header( "Refresh:2; url=../login.php?action=newuser");
?>
                Creating your new account, please wait...
<?php
                exit();
            }
        }
        catch (Exception $ex)
        {
            echo $ex;
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

        <section id="registrationSection">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <br />
                        <br />
                        <form method="post" role="form">
                            <h5 class="form-group">Create a MusicStore Account</h5>
                            <?php if ($errorResult != "") : ?>
                            <div class="alert alert-danger" role="alert"><?php echo $errorResult; ?></div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="John"
                                       value="<?php echo $_POST['firstname'] ?>" />
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Doe"
                                       value="<?php echo $_POST['lastname'] ?>" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="john.doe@example.com"
                                       value="<?php echo $_POST['email'] ?>" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="confirmemail" name="confirmemail" placeholder="Confirm email address" />
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username"
                                       value="<?php echo $_POST['username'] ?>" />
                                <small class="form-text text-muted">Letters, numbers, and underscores only</small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter a secure password" />
                                <small class="form-text text-muted">At least 6 characters</small>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm your password" />
                            </div>
                            <div align="center">
                                <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Register" />
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