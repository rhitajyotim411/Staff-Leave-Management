<?php
$_SERVER['REQUEST_URI'];
$type = $_POST['leave_type'];
$from = $_POST['from'];
$to = $_POST['to'];

echo "Type: " . $type . "<br>";
echo "From: " . $from . "<br>";
echo "To: " . $to . "<br>";
?>