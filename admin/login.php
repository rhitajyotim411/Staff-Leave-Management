<?php

session_start();
$url = $_SERVER['PHP_SELF'];
$vrf = '';
$btn = 'Verify';
$cpch = '<img id="captch" src="../captcha.php">&emsp;
<input type="submit" value="Refresh"><br><br>
<label for="captcha" name="captcha">Captcha: </label>
<input type="text" name="captcha" autocomplete="off" />&emsp;';

// If user has given a captcha!
if (isset($_POST['captcha']) && isset($_POST['submit']) && $_POST['captcha']!='')

    // If the captcha is valid
    if ($_POST['captcha'] == $_SESSION['captcha']) {
        $vrf = '<span style="color:green">CAPTCHA SUCCESSFULLY VERIFIED!!</span>';
        $btn = 'Submit';
        $cpch = '';
        $url = './login_db.php';
    } else {
        $vrf = '<span style="color:red">CAPTCHA FAILED!!!</span>';
    }

$uid = $passwd = "";

if (isset($_POST['uid']))
    $uid = $_POST['uid'];
if (isset($_POST['passwd']))
    $passwd = $_POST['passwd'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($url); ?>" method="post">
        <label for="uid">Admin ID: </label>
        <input name="uid" type="text" length="10" maxlength="10"
        value="<?php echo $uid?>"><br><br>
        <label for="passwd">Password: </label>
        <input name="passwd" type="password" length="100" maxlength="255"
        value="<?php echo $passwd?>"><br><br>
        <?php echo $cpch; ?>
        <?php echo $vrf; ?><br><br>
        <input type="submit" name="submit" value="<?php echo $btn; ?>">
    </form>
</body>

</html>