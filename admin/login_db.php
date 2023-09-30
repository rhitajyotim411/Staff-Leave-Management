<?php
session_start();

if (!isset($_SESSION['post']) && $_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Redirecting...';
    die(header("refresh:2; URL=../index.php"));
}

require_once '../inc/connect.php';
$post = $_SESSION['post'];
unset($_SESSION['post']);

$tbname = "admin_login";
$uid = $post["uid"];
$passwd = $post["passwd"];

$stmt = $conn->query("SELECT name, passwd from {$tbname} where uid='{$uid}'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() < 1) {
    echo "No such user present";
    echo '<br>';
    echo "<a href='../user/register.php'>Register here</a> ";
    echo "or <a href='./login.php'>login again</a>";
} else {
    if (password_verify($passwd, $data['passwd'])) {
        $_SESSION['UID'] = $uid;
        $_SESSION['name'] = $data['name'];
        $_SESSION['type'] = 'admin';
        header("Location: ./dashboard.php");
    } else {
        echo "<span style=\"color:red\">Wrong password</span><br>";
        echo "Redirecting to login...";
        header("refresh:2; URL=./login.php");
    }
}