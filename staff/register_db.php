<?php
session_start();

if (!isset($_SESSION['post']) && $_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Redirecting...';
    die(header("refresh:2; URL=../index.php"));
}

require_once '../util/connect.php';
$post = $_SESSION['post'];
unset($_SESSION['post']);

$tbname = "staff_login";
$uid = $post["uid"];
$name = $post["name"];
$passwd = $post["passwd"];

$stmt = $conn->query("SELECT passwd from {$tbname} where uid='{$uid}'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() > 0) {
    echo "{$uid} already registered<br>";
    echo '<br>';
    echo "<a href='../user/login.php'>Login here</a> ";
    echo "or <a href='./register.php'>register again</a> with different ID";
} else {
    try {
        // staff registration
        $sql = "INSERT INTO {$tbname} VALUES(:uid, :name, :passwd)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':uid' => $uid,
            ':name' => $name,
            ':passwd' => password_hash($passwd, PASSWORD_DEFAULT)
        ]);

        // staff default leave
        $leavetb = "staff_leave";
        $sql = "INSERT INTO {$leavetb} VALUES(:uid, :el, :cl, :sl)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':uid' => $uid,
            ':el' => 5,
            ':cl' => 12,
            ':sl' => 30
        ]);
    } catch (PDOException $e) {
        echo "Insertion failed: " . $e->getMessage();
        die("<br><a href='../index.php'>Homepage</a>");
    }

    $_SESSION['UID'] = $uid;
    $_SESSION['name'] = $name;
    $_SESSION['type'] = 'staff';
    header("Location: ./dashboard.php");
}