<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Redirecting...';
    die(header("refresh:3; URL=../index.php"));
}

require_once '../connect.php';

$tbname = "admin_login";
$uid = $_POST["uid"];
$name = $_POST["name"];
$passwd = $_POST["passwd"];

$stmt = $conn->query("SELECT passwd from {$tbname} where uid='{$uid}'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() > 0) {
    echo "{$uid} already registered<br>";
    echo "Redirecting to login...";
    header("refresh:3; URL=./login.php");
} else {
    try {
        $sql = "INSERT INTO {$tbname} VALUES(:uid, :name, :passwd)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':uid' => $uid,
            ':name' => $name,
            ':passwd' => password_hash($passwd, PASSWORD_DEFAULT)
        ]);
    } catch (PDOException $e) {
        echo "Insertion failed: " . $e->getMessage();
    }

    $_SESSION['UID'] = $uid;
    $_SESSION['type'] = 'admin';

    echo "{$uid} successfully registered<br>";
    echo "Redirecting to dashboard...";
    header("refresh:3; URL=./dashboard.php");
}