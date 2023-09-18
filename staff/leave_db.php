<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Redirecting...';
    die(header("refresh:2; URL=../index.php"));
}

require_once '../connect.php';

$tbleave = "staff_leave";
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
    $flag = false;

    $days = 0;
    foreach ($periods as $period) {
        if (!in_array($period->format('N'), $workingDays))
            continue;
        if (in_array($period->format('*-m-d'), $holidayDays))
            continue;

        if ($period->format('N') == 5)
            $flag = true;
        else if ($period->format('N') == 1 and $flag) {
            $flag = false;
            $days++;
        }
        $days++;
    }
    return $days;
}

$lv_types = ['EL', 'CL', 'SL'];

echo "<h2>Leave request summary</h2>";
echo "From: $from<br>";
echo "To: $to<br>";

$d = days($from, $to);

if ($to < $from or $from < date("Y-m-d")) {
    echo "Enter dates correctly";
    die("<br><a href='./leave.php'>Re-apply for leave</a>");
}

try {
    $t = in_array($type, $lv_types);
    if ($t) {
        global $data;
        $stmt = $conn->query("SELECT $type from $tbleave where uid='$uid'");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if ($t and $data[$type] < $d) {
        echo "Requested {$type}s: $d<br>";
        echo "Available {$type}s: $data[$type]<br>";
        echo "Not enough {$type}s available<br>";
        echo "Leave request failed<br>";
    } else {
        // enter leave record
        $sql = "INSERT INTO $tbname (UID, Type, `From`, `To`, Days) ";
        $sql .= "VALUES(:uid, :type, :from, :to, :days)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':uid' => $uid,
            ':type' => $type,
            ':from' => $from,
            ':to' => $to,
            ':days' => $d
        ]);

        // update leave
        if ($t) {
            $sql = "UPDATE $tbleave SET $type=:days WHERE UID=:uid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':days' => $data[$type] - $d,
                ':uid' => $uid
            ]);
        }

        echo "Requested {$type}s: $d<br>";
        if ($t)
            echo "Remaining {$type}s: " . ($data[$type] - $d) . "<br>";
        echo "Leave request successfully registered<br>";
    }
} catch (PDOException $e) {
    echo "Insertion failed: " . $e->getMessage();
    die("<br><a href='./dashboard.php'>Dashboard</a>");
}

echo "<br><a href='./dashboard.php'>Dashboard</a>";