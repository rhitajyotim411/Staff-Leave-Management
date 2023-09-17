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
    die(header("refresh:2; URL=./login.php"));
}
if ($_SESSION['type'] != 'staff') {
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Not a staff, Redirecting to dashboard...';
    die(header("refresh:2; URL=../admin/dashboard.php"));
}

require_once '../connect.php';

$tbleave = "staff_leave";
$tbname = "leave_record";
$uid = $_SESSION['UID'];
$fields = "SN, Type, `From`, `To`, Days, Status";

$stmt = $conn->query("SELECT * FROM $tbleave WHERE uid='$uid'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT $fields FROM $tbname WHERE uid='$uid' ORDER BY `From`";
$stmt = $conn->query($query);
?>

<body>
    <h2>Leave Record</h2>

    <h3>Leaves available: -</h3>
    <table>
        <tr>
            <td>Earned leave (EL):
                <?php echo $data["EL"] ?>
            </td>
            <td>Casual leave (CL):
                <?php echo $data["CL"] ?>
            </td>
            <td>Sick leave (SL):
                <?php echo $data["SL"] ?>
            </td>
        </tr>
    </table>

    <h3>Leaves recorded: -</h3>

    <?php
    if ($stmt->rowCount() < 1) {
        echo "<p>No leave record found<br></p>";
        die("<a href='./dashboard.php'>Dashboard</a>");
    }
    ?>

    <table>
        <tr>
            <th>Type</th>
            <th>From</th>
            <th>To</th>
            <th>Days</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Status'] === 'Approved')
                $clr = 'green';
            elseif ($row['Status'] === 'Denied')
                $clr = 'red';
            else
                $clr = 'black';

            echo "<tr>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['From']}</td>";
            echo "<td>{$row['To']}</td>";
            echo "<td style=\"text-align: center\">{$row['Days']}</td>";
            echo "<td style=\"color: $clr\">{$row['Status']}</td>";
            echo "<td>";
            if ($row['Status'] === 'Pending') {
                echo "<form action=\"./withdraw.php\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"lv_sn\" value={$row['SN']}>";
                echo "<input type=\"submit\" name=\"submit\" value=\"Withdraw\">";
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