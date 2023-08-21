
<?php
 
session_start();
$msg = '';
 
// If user has given a captcha!
if (isset($_POST['input']))
 
    // If the captcha is valid
    if ($_POST['input'] == $_SESSION['captcha'])
        $msg = '<span style="color:green">SUCCESSFUL!!!</span>';
    else
        $msg = '<span style="color:red">CAPTCHA FAILED!!!</span>';
?>
  
<style>
    body{
        display:flex;
        flex-direction:column;
        align-items: center;
        justify-content: center;
    }
</style>
  
<body>
    <h2>PROVE THAT YOU ARE NOT A ROBOT!!</h2>
     
    <strong>
        Type the text in the image to prove
        you are not a robot
    </strong>
  
    <div style='margin:15px'>
        <img src="captcha.php">
    </div>
     
    <form method="POST" action=
            " <?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="input" autocomplete="off"/>
        <input type="hidden" name="flag" value="1"/>
        <input type="submit" value="Submit" name="submit"/>
    </form>
     
    <div style='margin-bottom:5px'>
        <?php echo $msg; ?>
    </div>
     
    <div>
        Can't read the image? Click
        <a href='<?php echo $_SERVER['PHP_SELF']; ?>'>
            here
        </a>
        to refresh!
    </div>
</body>