<?php
include_once("./code/config.php"); // Include configuration file
require_once("../MusicStoreDataLayer/UserController.php");
require_once("../MusicStoreDataLayer/User.php");
require_once("../MusicStoreDataLayer/Address.php");

if ($logged_in !== true)
{
    echo 'You do not have permission to view this page! Please <a href="./login.php">Log In</a>';
    exit();
}
else
{
    /////////////////////////////// UPDATE PERSONAL INFO //////////////////////////////
    if (isset($_POST['submitPI']))
    {
        $errorPI = "";
        if (!$_POST['firstname'])
        {
            $fnError = "- Please enter your first name.";
            $errorPI .= $fnError;
        }
        if (!$_POST['lastname'])
        {
            $lnError = "- Please enter your last name.";
            $errorPI .= ($errorPI == "") ? $lnError : "<br />" . $lnError;
        }

        if ($errorPI == "")
        {
            $userController = new UserController();
            try
            {
                $fn = stripslashes(htmlspecialchars($_POST['firstname']));
                $ln = stripslashes(htmlspecialchars($_POST['lastname']));
                $userController->updateUserInfo($userID, $fn, $ln );
                $_SESSION[AppData::$FIRSTNAME] = $fn;
                $_SESSION[AppData::$LASTNAME] = $ln;
                header( "Refresh:.5; url=../account_info.php?updated=PI");
                exit();
            }
            catch (Exception $ex)
            {
                echo $ex;
                exit();
            }
        }
        else
        {
            $updatedMsg = AppData::CreateAlert("Please fill out all fields correctly", "danger");
        }
    }

    /////////////////////////////// UPDATE ADDRESS //////////////////////////////////
    if (isset($_POST['updateAD']))
    {

    }

    /////////////////////////////// UPDATE PASSWORD //////////////////////////////////
    if (isset($_POST['submitPW']))
    {
        $errorPW = "";
        if (!$_POST['oldPW'])
        {
            $oldpwError = "- Please enter your current password.";
            $errorPW .= $oldpwError;
        }
        if (!$_POST['newPW'])
        {
            $newpwError = "- Please enter a new password.";
            $errorPW .= ($errorPW == "") ? $newpwError : "<br />" . $newpwError;
        }
        else if ($_POST['newPWconfirm'] !== $_POST['newPW'])
        {
            $confirmError = "- New passwords do not match.";
            $errorPW .= ($errorPW == "") ? $confirmError : "<br />" . $confirmError;
        }

        if ($errorPW == "")
        {
            if (isset($_POST['submitPW']))
            {
                $userController = new UserController();
                try
                {
                    $pw = stripslashes(htmlspecialchars($_POST['newPW']));
                    $userController->updateUserPassword($_SESSION[AppData::$USERID], $_POST['newPW']);
                    header( "Refresh:.5; url=account_info.php?updated=PW");
                    exit();
                }
                catch (Exception $ex)
                {
                    echo $ex;
                    exit();
                }
            }
        }
        else
        {
            $updatedMsg = AppData::CreateAlert("Please fill out all password fields correctly", "danger");
        }
    }

    //////////////////////////////// UPDATE MESSAGE //////////////////////////////////
    if (isset($_GET['updated']))
    {
        $updateMsg = "";
        switch($_GET['updated'])
        {
            case "PI":
                $updateMsg = AppData::CreateAlert("Personal information updated successfully", "success");
                break;
            case "AD":
                $updateMsg = AppData::CreateAlert("Address updated successfully", "success");
                break;
            case "PW":
                $updateMsg = AppData::CreateAlert("Password updated successfully", "success");
                break;
        }
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
            <h6>
                <span style="font-weight:bold">
                    <?php echo $user_firstname; ?>
                </span>, welcome to your custom account page.
            </h6>
            <?php if (isset($_GET['updated'])) echo "<br />" . $updateMsg; ?>
            <?php include_once("./accountnav.html"); ?>
            <br />
            
            <div class="row">
                <div class="col-md-4">
                    <nav class="nav flex-column">
                        <a id="PersonalInfoNav" class="nav-link active" href="#">Personal Info</a>
                        <a id="AddressesNav" class="nav-link" href="#">Addresses</a>
                        <a id="ChangePasswordNav" class="nav-link" href="#">Change Password</a>
                    </nav>
                    <br />
                    <br />
                </div>

                <div class="col-md-8">
                    <div id="PersonalInfo">
                        <h5>Your Personal Information</h5><a id="EditPI" href="#">Edit</a>
                        <br />

                        <form class="col-md-4" method="post" role="form">

                            <?php if ($errorPI != "") : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $errorPI; ?>
                            </div>
                            <?php endif; ?>

                            <div id="piError" role="alert" class="alert alert-danger" style="display:none">
                                <label id="fnEmptyErr" class="err" style="display:none">First name required</label>
                                <label id="lnEmptyErr" class="err" style="display:none">Last name required</label>
                            </div>

                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" disabled
                                    value="<?php echo $user_firstname; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" disabled
                                    value="<?php echo $user_lastname; ?>" />
                            </div>
                            <!--<div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="john.doe@example.com"
                                    value="<?php  ?>" />
                            </div>-->
                            <input type="submit" class="btn btn-outline-success" id="submitPI" name="submitPI" value="Save Changes" style="display:none;" />
                        </form>
                    </div>
                    <div id="Addresses" style="display:none;">
                        <p>test2</p>
                    </div>
                    <div id="ChangePassword" style="display:none;">
                        <h5>Change your password</h5>
                        <br />

                        <form class="col-md-6" method="post" role="form">

                            <?php if ($errorPW != "") : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $errorPW; ?>
                            </div>
                            <?php endif; ?>

                            <div id="pwError" role="alert" class="alert alert-danger" style="display:none">
                                <label id="oldPWemptyErr" class="err" style="display:none">Current password required</label>
                                <label id="newPWemptyErr" class="err" style="display:none">New password required</label>
                                <label id="newPWconfirmEmptyErr" class="err" style="display:none">Confirm new password</label>
                                <label id="newPWmatchErr" class="err" style="display:none">New passwords do not match</label>
                            </div>

                            <div class="form-group">
                                <label for="oldPW">Current Password</label>
                                <input type="password" id="oldPW" name="oldPW" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="newPW">New Password</label>
                                <input type="password" id="newPW" name="newPW" class="form-control" placeholder="Enter new secure password" />
                                <input type="password" id="newPWconfirm" name="newPWconfirm" class="form-control" placeholder="Confirm new password" />
                            </div>
                            <input type="submit" class="btn btn-outline-success" id="submitPW" name="submitPW" value="Update Password" />
                        </form>
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
    <script>
        $(document).ready(function () {
            $('#actInfo').addClass('active');

            $('#PersonalInfoNav').click(function () {
                $('#Addresses').hide();
                $('#ChangePassword').hide();
                $('#PersonalInfo').show();
            });
            $('#AddressesNav').click(function () {
                $('#PersonalInfo').hide();
                $('#ChangePassword').hide();
                $('#Addresses').show();

                $('#PersonalInfo input[type="text"]').prop('disabled', 'disabled');
                $('#submitPI').hide();
            });
            $('#ChangePasswordNav').click(function () {
                $('#PersonalInfo').hide();
                $('#Addresses').hide();
                $('#ChangePassword').show();

                $('#PersonalInfo input[type="text"]').prop('disabled', 'disabled');
                $('#submitPI').hide();
            });

            $('#EditPI').click(function () {
                $('#PersonalInfo input[type="text"]').prop('disabled', function (i, v) { return !v; });
                $('#submitPI').toggle();
            });

            $('#submitPI').click(function () {
                $('.err').hide();

                var fn = $("input#firstname").val();
                if (fn == "") {
                    $('#piError').show();
                    $("label#fnEmptyErr").show();
                    $("input#firstname").focus();
                    return false;
                }
                var ln = $("input#lastname").val();
                if (ln == "") {
                    $('#piError').show();
                    $("label#lnEmptyErr").show();
                    $("input#lastname").focus();
                    return false;
                }
                $('#piError').hide();
            });

            $('#submitPW').click(function () {
                $('.err').hide();

                var oldPW = $("input#oldPW").val();
                if (oldPW == "") {
                    $('#pwError').show();
                    $("label#oldPWemptyErr").show();
                    $("input#oldPW").focus();
                    return false;
                }
                var newPW = $("input#newPW").val();
                if (newPW == "") {
                    $('#pwError').show();
                    $("label#newPWemptyErr").show();
                    $("input#newPW").focus();
                    return false;
                }
                var newPWconfirm = $("input#newPWconfirm").val();
                if (newPWconfirm == "") {
                    $('#pwError').show();
                    $("label#newPWconfirmEmptyErr").show();
                    $("input#newPWconfirm").focus();
                    return false;
                }
                if (newPWconfirm != newPW) {
                    $('#pwError').show();
                    $("label#newPWmatchErr").show();
                    $("input#newPWconfirm").focus();
                    return false;
                }
                $('#pwError').hide();
            });
        });
    </script>
</body>
</html>