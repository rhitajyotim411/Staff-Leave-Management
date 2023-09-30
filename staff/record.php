<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Record</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/table.css" rel="stylesheet">
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

require_once '../inc/connect.php';

$tbleave = "staff_leave";
$tbname = "leave_record";
$uid = $_SESSION['UID'];
$fields = "SN, Type, `From`, `To`, Days, Status";

$stmt = $conn->query("SELECT * FROM $tbleave WHERE uid='$uid'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$fltr = "";
if (isset($_POST['fltr_lv']) and $_POST['filter'] != 'All') {
    $query = "SELECT $fields FROM $tbname WHERE uid='$uid' and status='{$_POST['filter']}' ORDER BY `From`";
    $fltr = $_POST['filter'];
} else
    $query = "SELECT $fields FROM $tbname WHERE uid='$uid' ORDER BY `From`";
$stmt = $conn->query($query);
?>

<body>
    <?php require '../inc/header.php' ?>
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

    <p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="filter">Filter:</label>
        <select name="filter">
            <option value="All" <?php if ($fltr === "")
                echo "selected" ?>>All</option>
                <option value="Approved" <?php if ($fltr === "Approved")
                echo "selected" ?>>Approved</option>
                <option value="Denied" <?php if ($fltr === "Denied")
                echo "selected" ?>>Denied</option>
                <option value="Pending" <?php if ($fltr === "Pending")
                echo "selected" ?>>Pending</option>
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