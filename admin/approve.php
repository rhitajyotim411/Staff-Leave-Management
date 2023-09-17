<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Redirecting...';
    die(header("refresh:2; URL=../index.php"));
}

require_once '../connect.php';

$sn = $_POST['lv_sn'];
$tbname = "leave_record";

$sql = "UPDATE $tbname SET Status=:status, Admin=:uid WHERE SN=:sn";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':status' => 'Approved',
    ':uid' => $_SESSION['UID'],
    ':sn' => $sn
]);

$x = $_SERVER['HTTP_REFERER'];
$pg = explode('/', $x);
$pg = end($pg);

if ($pg === 'staff.php') {
    $stmt = $conn->query("SELECT UID FROM $tbname WHERE SN='$sn'");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["staff_uid"] = $data['UID'];
}

die(header("Location: $x"));