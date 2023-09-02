<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Record</title>

    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>

<?php
if (!isset($_SESSION['UID'])) {
    echo "Please login to continue<br>";
    echo "Redirecting to login page...";
    die(header("refresh:3; URL=./login.php"));
}
if ($_SESSION['type'] != 'staff') {
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Not a staff, Redirecting to dashboard...';
    die(header("refresh:3; URL=../admin/dashboard.php"));
}

require_once '../connect.php';

$tbname = "leave_record";
$uid = $_SESSION['UID'];
$fields = "UID, Type, `From`, `To`, Days, Status";
$query = "SELECT $fields FROM $tbname WHERE uid='$uid' ORDER BY `From`";
$stmt = $conn->query($query);
?>

<body>
    <H2>Leave Record</H2>
    <table>
        <tr>
            <th>UID</th>
            <th>Type</th>
            <th>From</th>
            <th>To</th>
            <th>Days</th>
            <th>Status</th>
        </tr>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['UID']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['From']}</td>";
            echo "<td>{$row['To']}</td>";
            echo "<td>{$row['Days']}</td>";
            echo "<td>{$row['Status']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br>
    <a href='./dashboard.php'>Dashboard</a>
</body>

</html>