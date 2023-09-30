<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit All Leaves</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/table.css" rel="stylesheet">
    <style>
        input[type='number'] {
            width: 50px;
        }
    </style>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Redirecting...';
    die(header("refresh:2; URL=../index.php"));
}

require_once '../inc/connect.php';
$tbname = "staff_leave";

if (isset($_POST['edit_save'])) {
    for ($i = 1; $i <= $_POST['rows']; $i++) {
        $sql = "UPDATE $tbname SET EL=:el, CL=:cl, SL=:sl WHERE UID=:uid";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':el' => $_POST["EL_$i"],
            ':cl' => $_POST["CL_$i"],
            ':sl' => $_POST["SL_$i"],
            ':uid' => $_POST["ID_$i"]
        ]);
    }

    die(header("Location: ./leave.php"));
}

$stmt = $conn->query("SELECT * FROM $tbname");
?>

<body>
    <?php require '../inc/header.php' ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <table>
            <tr>
                <th>UID</th>
                <th>Earned leave<br>(EL)</th>
                <th>Casual leave<br>(CL)</th>
                <th>Sick leave<br>(SL)</th>
            </tr>
            <?php
            $cx = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cx += 1;
                echo "<tr>";
                echo "<td>";
                echo "{$row['UID']}";
                echo "<input type=\"hidden\" name=\"ID_$cx\" value={$row['UID']}>";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"number\" name=\"EL_$cx\" value=\"{$row["EL"]}\">";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"number\" name=\"CL_$cx\" value=\"{$row["CL"]}\">";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"number\" name=\"SL_$cx\" value=\"{$row["SL"]}\">";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <input type="hidden" name="rows" value="<?php echo $stmt->rowCount() ?>">
        <input type="submit" name="edit_save" value="Save">
    </form>
</body>

</html>