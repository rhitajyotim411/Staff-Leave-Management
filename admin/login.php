<?php

session_start();
$msg = '';
$uid='hello';
var_dump($_POST);
if (isset($_POST['uid']))
$uid = $_POST['uid'];

// If user has given a captcha!
if (isset($_POST['captcha']))

    // If the captcha is valid
    if ($_POST['captcha'] == $_SESSION['captcha'])
        $msg = '<span style="color:green">SUCCESSFUL!!!</span>';
    else {
        $msg = '<span style="color:red">CAPTCHA FAILED!!!</span>';
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="uid">Admin ID: </label>
        <input name="uid" type="text" length="100" maxlength="255"
        value="<?php echo $uid; ?>"><br>
        <label for="passwd">Password: </label>
        <input name="passwd" type="password" length="100" maxlength="255"><br>
        <img id="captch" src="../captcha.php">
        <a onclick="ck_data" href='<?php echo $_SERVER['PHP_SELF']; ?>'>Refresh</a><br>
        <label for="passwd">Captcha: </label>
        <input type="text" name="captcha" autocomplete="off" />
        <?php echo $msg; ?><br>
        <input type="submit">
    </form>
</body>

</html>