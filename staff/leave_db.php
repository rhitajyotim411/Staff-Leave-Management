<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die('<h2 style="color: red">Access Denied!!</h2>');
}

$_SERVER['REQUEST_URI'];
$type = $_POST['leave_type'];
$from = $_POST['from'];
$to = $_POST['to'];

echo "Type: " . $type . "<br>";
echo "From: " . $from . "<br>";
echo "To: " . $to . "<br>";
?>