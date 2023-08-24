<?php
require_once '../connect.php';

$tbname = "staff_login";
$uid = $_POST["uid"];
$name = $_POST["name"];
$passwd = $_POST["passwd"];

$stmt = $conn->query("SELECT passwd from {$tbname} where uid='{$uid}'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() > 0) {
    echo "{$uid} already registered";
    echo "<br>";
    echo "<a href='./login.php'>Login here</a>";
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

    echo "{$uid} successfully registered";
    echo "<br>";
    echo "<a href='./dashboard.html'>Go to dashboard</a>";
}
