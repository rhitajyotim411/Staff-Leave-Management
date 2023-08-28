<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Redirecting...';
    die(header("refresh:3; URL=../index.php"));
}

require_once '../connect.php';

$tbname = "leave_record";
$type = $_POST['leave_type'];
$from = $_POST['from'];
$to = $_POST['to'];
$uid = $_SESSION['UID'];

function days($from, $to)
{
    $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
    $holidayDays = ['*-12-25', '*-08-15', '*-01-26', '*-10-02']; # fixed holidays

    $from = new DateTime($from);
    $to = new DateTime($to);
    $to->modify('+1 day');
    $interval = new DateInterval('P1D');
    $periods = new DatePeriod($from, $interval, $to);

    $days = 0;
    foreach ($periods as $period) {
        if (!in_array($period->format('N'), $workingDays)) continue;
        if (in_array($period->format('*-m-d'), $holidayDays)) continue;
        $days++;
    }
    return $days;
}

try {
    echo days($from, $to).'<br>';
    $sql = "INSERT INTO {$tbname} VALUES(:sn, :type, :from, :to, :uid)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':sn' => null,
        ':type' => $type,
        ':from' => $from,
        ':to' => $to,
        ':uid' => $uid
    ]);
} catch (PDOException $e) {
    echo "Insertion failed: " . $e->getMessage();
    die("<br><a href='./dashboard.php'>Dashboard</a>");
}

echo "Leave request successfully registered<br>";
echo "Redirecting to dashboard...";
// header("refresh:3; URL=./dashboard.php");
echo "<br><a href='./dashboard.php'>Dashboard</a>";
