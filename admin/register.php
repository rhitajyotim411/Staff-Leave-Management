<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/form.css" rel="stylesheet">
</head>

<?php
$vrf = '';

// If user has given a captcha!
if (isset($_POST['captcha']) && isset($_POST['submit']) && $_POST['captcha'] != '')
    // If the captcha is valid
    if ($_POST['captcha'] == $_SESSION['captcha']) {
        $_SESSION["post"] = $_POST;
        die(header("Location: ./register_db.php"));
    } else {
        $vrf = '<span style="color:red">CAPTCHA FAILED!!!</span>';
    }

$uid = $name = $passwd = "";

if (isset($_POST['uid']))
    $uid = $_POST['uid'];
if (isset($_POST['name']))
    $name = $_POST['name'];
if (isset($_POST['passwd']))
    $passwd = $_POST['passwd'];
?>

<body>
    <?php require '../inc/header.php' ?>
    <div class="container-fluid text-center">
        <?php
        if (isset($_SESSION['UID'])) {
            echo "{$_SESSION['UID']} already logged in<br>";
            echo "Redirecting to dashboard...";
            die(header("refresh:2; URL=../{$_SESSION['type']}/dashboard.php"));
        }
        ?>
        <div class="row justify-content-center mt-5">
            <div class="col-sm-3 mt-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Admin registration</h5>
                        <p class="card-text">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <table>
                                <tr>
                                    <td><label for="uid">Admin ID: </label></td>
                                    <td><input name="uid" type="text" length="10" maxlength="10" value="<?php echo $uid ?>"></td>
                                </tr>
                                <tr>
                                    <td><label for="name">Full Name: </label></td>
                                    <td><input name="name" type="text" length="100" maxlength="255" value="<?php echo $name ?>"></td>
                                </tr>
                                <tr>
                                    <td><label for="passwd">Password: </label></td>
                                    <td><input name="passwd" type="password" length="100" maxlength="255" value="<?php echo $passwd ?>"></td>
                                </tr>
                                <tr>
                                    <td><img id="captch" src="../inc/captcha.php"></td>
                                    <td><input type="submit" class="btn btn-primary" value="Refresh"></td>
                                </tr>
                                <tr>
                                    <td><label for="captcha" name="captcha">Captcha: </label></td>
                                    <td><input type="text" name="captcha" autocomplete="off" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?php echo $vrf; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input type="submit" name="submit" class="btn btn-primary" value="Verify"></td>
                                </tr>
                            </table>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>