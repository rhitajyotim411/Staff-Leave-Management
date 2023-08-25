<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die('<h2 style="color: red">Access Denied!!</h2>');
}

require_once '../connect.php';

$tbname = "staff_login";
$uid = $_POST["uid"];
$passwd = $_POST["passwd"];

$stmt = $conn->query("SELECT passwd from {$tbname} where uid='{$uid}'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() < 1) {
    echo "No such user present";
    echo '<br>';
    echo "<a href='./register.php'>Register here</a> ";
    echo "or <a href='./login.php'>login again</a>";
} else {
    if (password_verify($passwd, $data['passwd'])) {
        echo "{$uid} succesfully logged in";
        echo "<br>";
        echo "<a href='./dashboard.php'>Go to dashboard</a>";
    } else {
        echo "Wrong password";
        echo '<br>';
        echo "<a href='./login.php'>Re-Login</a>";
    }
}