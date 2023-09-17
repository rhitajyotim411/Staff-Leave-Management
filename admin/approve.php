<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Redirecting...';
    die(header("refresh:3; URL=../index.php"));
}

require_once '../connect.php';

$sn = $_POST['lv_sn'];
$tbname = "leave_record";

$sql = "UPDATE $tbname SET Status=:status WHERE SN=:sn";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':status' => 'Approved',
    ':sn' => $sn
]);

die(header("Location: {$_SERVER['HTTP_REFERER']}"));