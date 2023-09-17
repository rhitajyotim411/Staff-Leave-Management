<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaves Record</title>

    <style>
        table,
        th,
        td {
            border: 2px solid black;
            border-collapse: collapse;
            padding: 5px 10px;
        }
    </style>
</head>

<?php
if (!isset($_SESSION['UID'])) {
    echo "Please login to continue<br>";
    echo "Redirecting to login page...";
    die(header("refresh:3; URL=./login.php"));
}
if ($_SESSION['type'] != 'admin') {
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Not an admin, Redirecting to dashboard...';
    die(header("refresh:3; URL=../staff/dashboard.php"));
}

require_once '../connect.php';

$tbname = "leave_record";
$uid = $_SESSION['UID'];
$fields = "SN, UID, Type, `From`, `To`, Days, Status";

$query = "SELECT $fields FROM $tbname ORDER BY `From`";
$stmt = $conn->query($query);
?>

<body>
    <h2>Leaves Record</h2>

    <?php
    if ($stmt->rowCount() < 1) {
        echo "<p>No leave record found<br></p>";
        die("<a href='./dashboard.php'>Dashboard</a>");
    }
    ?>

    <table>
        <tr>
            <th>UID</th>
            <th>Type</th>
            <th>From</th>
            <th>To</th>
            <th>Days</th>
            <th>Status</th>
            <th colspan=2>Actions</th>
        </tr>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['UID']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['From']}</td>";
            echo "<td>{$row['To']}</td>";
            echo "<td style=\"text-align: center\">{$row['Days']}</td>";
            echo "<td>{$row['Status']}</td>";
            echo "<td>";
            if ($row['Status'] === 'Pending') {
                echo "<form action=\"./approve.php\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"lv_sn\" value={$row['SN']}>";
                echo "<input type=\"submit\" name=\"submit\" value=\"Approve\">";
                echo "</form>";
            }
            echo "</td>";
            echo "<td>";
            if ($row['Status'] === 'Pending') {
                echo "<form action=\"./deny.php\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"lv_sn\" value={$row['SN']}>";
                echo "<input type=\"submit\" name=\"submit\" value=\"Deny\">";
                echo "</form>";
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br>
    <a href='./dashboard.php'>Dashboard</a>
</body>

</html>