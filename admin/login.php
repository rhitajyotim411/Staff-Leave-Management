<?php
require_once '../connect.php';

$tbname = "admin_login";
$uid = $_POST["uid"];
$passwd = $_POST["passwd"];

$stmt = $conn->query("SELECT passwd from {$tbname} where uid='{$uid}'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() < 1) {
    echo "No such user present";
    echo '<br>';
    echo "<a href='./register.html'>Register here</a>";
} else {
    if (password_verify($passwd, $data['passwd'])) {
        echo "UID {$uid} succesfully logged in";
        echo "<br>";
        echo "<a href='./dashboard.html'>Go to dashboard</a>";
    } else {
        echo "Wrong password";
        echo '<br>';
        echo "<a href='./login.html'>Re-Login</a>";
    }
}
