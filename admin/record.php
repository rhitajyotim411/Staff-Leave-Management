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
    die(header("refresh:2; URL=./login.php"));
}
if ($_SESSION['type'] != 'admin') {
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Not an admin, Redirecting to dashboard...';
    die(header("refresh:2; URL=../staff/dashboard.php"));
}

require_once '../connect.php';

$tbname = "leave_record";
$fields = "SN, UID, Type, `From`, `To`, Days, Status";

if (isset($_POST['fltr_lv']) and $_POST['filter'] != 'All')
    $query = "SELECT $fields FROM $tbname WHERE status='{$_POST['filter']}' ORDER BY `From`";
else
    $query = "SELECT $fields FROM $tbname ORDER BY `From`";
$stmt = $conn->query($query);
?>

<body>
    <h2>Leaves Record</h2>

    <p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="filter">Filter:</label>
        <select name="filter">
            <option value="All">All</option>
            <option value="Approved">Approved</option>
            <option value="Denied">Denied</option>
            <option value="Pending">Pending</option>
        </select>
        <input type="submit" name="fltr_lv" value="Filter">
    </form>
    </p>

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
            if ($row['Status'] === 'Approved')
                $clr = 'green';
            elseif ($row['Status'] === 'Denied')
                $clr = 'red';
            else
                $clr = 'black';

            echo "<tr>";
            echo "<td>{$row['UID']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['From']}</td>";
            echo "<td>{$row['To']}</td>";
            echo "<td style=\"text-align: center\">{$row['Days']}</td>";
            echo "<td style=\"color: $clr\">{$row['Status']}</td>";
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