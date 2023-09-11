<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff leave record</title>

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
?>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="staff">Staff UID: </label>
        <input type="text" name="staff">
        <input type="submit">
    </form>

    <?php
    if (isset($_POST['staff'])) {
        require_once '../connect.php';
        $tbleave = "staff_leave";
        $tbrec = "leave_record";
        $s_uid = $_POST['staff'];
        $fields = "Type, `From`, `To`, Days, Status";

        $stmt = $conn->query("SELECT * FROM $tbleave WHERE uid='$s_uid'");
        if ($stmt->rowCount() < 1) {
            echo "<p>Staff UID <b>$s_uid</b> not found<br></p>";
            die("<a href='./dashboard.php'>Dashboard</a>");
        }
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $query = "SELECT $fields FROM $tbrec WHERE uid='$s_uid' ORDER BY `From`";
        $stmt = $conn->query($query);
    ?>
        <h2><?php echo $s_uid ?> Leave Record</h2>

        <h3>Leave available: -</h3>
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

        <h3>Leave recorded: -</h3>

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
                echo "<tr>";
                echo "<td>{$row['Type']}</td>";
                echo "<td>{$row['From']}</td>";
                echo "<td>{$row['To']}</td>";
                echo "<td style=\"text-align: center\">{$row['Days']}</td>";
                echo "<td>{$row['Status']}</td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php
    }
    ?>
    <br>
    <a href='./dashboard.php'>Dashboard</a>
</body>

</html>