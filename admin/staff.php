<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff leave record</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
    <link href="../style/table.css" rel="stylesheet">
</head>

<body>
    <?php require '../inc/header.php' ?>
    <div class="container-fluid text-center mt-3">
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

        if (isset($_SESSION["staff_uid"])) {
            $_POST['staff'] = $_SESSION["staff_uid"];
            unset($_SESSION["staff_uid"]);
        } elseif (isset($_POST['fltr_lv']))
            $_POST['staff'] = $_POST['fltr_id'];
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="staff">Staff UID: </label>
            <input type="text" name="staff">
            <input type="submit" class="btn btn-primary">
        </form>

        <?php
        if (isset($_POST['staff'])) {
            if ($_POST['staff'] == "") {
                die("<p>Enter staff UID to fetch leave record</p>");
            }

            require_once '../inc/connect.php';
            $tbleave = "staff_leave";
            $tbrec = "leave_record";
            $s_uid = $_POST['staff'];
            $fields = "SN, Type, `From`, `To`, Days, Status";

            $stmt = $conn->query("SELECT * FROM $tbleave WHERE uid='$s_uid'");
            if ($stmt->rowCount() < 1) {
                die("<p>Staff UID <b>$s_uid</b> not found<br></p>");
            }
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $fltr = "";
            if (isset($_POST['fltr_lv']) and $_POST['filter'] != 'All') {
                $query = "SELECT $fields FROM $tbrec WHERE uid='$s_uid' and status='{$_POST['filter']}' ORDER BY `From`";
                $fltr = $_POST['filter'];
            } else
                $query = "SELECT $fields FROM $tbrec WHERE uid='$s_uid' ORDER BY `From`";
            $stmt = $conn->query($query);
        ?>
            <div class="d-flex justify-content-center">
                <hr>
            </div>
            <h2>Leave Record of
                <?php echo $s_uid ?>
            </h2>
            <div class="d-flex justify-content-center">
                <hr>
            </div>

            <h3>Leaves available: -</h3>
            <div class="d-flex justify-content-center mt-3 mb-3">
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
                        <td>
                            <form action="./edit.php" method="post">
                                <input type="hidden" name="stf_id" value=<?php echo $s_uid ?>>
                                <input type="submit" name="submit" class="btn btn-primary" value="Edit">
                            </form>
                        </td>
                    </tr>
                </table>
            </div>

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
                <input type="hidden" name="fltr_id" value="<?php echo $_POST['staff'] ?>">
                <input type="submit" name="fltr_lv" class="btn btn-primary" value="Filter">
            </form>
            </p>

            <?php
            if ($stmt->rowCount() < 1) {
                die("<p>No leave record found<br></p>");
            }
            ?>

            <div class="d-flex justify-content-center mt-3 mb-3">
                <table>
                    <tr>
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
                        echo "<td>{$row['Type']}</td>";
                        echo "<td>{$row['From']}</td>";
                        echo "<td>{$row['To']}</td>";
                        echo "<td style=\"text-align: center\">{$row['Days']}</td>";
                        echo "<td style=\"color: $clr\">{$row['Status']}</td>";
                        echo "<td>";
                        if ($row['Status'] === 'Pending') {
                            echo "<form action=\"./approve.php\" method=\"post\">";
                            echo "<input type=\"hidden\" name=\"lv_sn\" value={$row['SN']}>";
                            echo "<input type=\"submit\" name=\"submit\" class=\"btn btn-primary\" value=\"Approve\">";
                            echo "</form>";
                        }
                        echo "</td>";
                        echo "<td>";
                        if ($row['Status'] === 'Pending') {
                            echo "<form action=\"./deny.php\" method=\"post\">";
                            echo "<input type=\"hidden\" name=\"lv_sn\" value={$row['SN']}>";
                            echo "<input type=\"submit\" name=\"submit\" class=\"btn btn-primary\" value=\"Deny\">";
                            echo "</form>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        <?php
        }
        ?>
    </div>
</body>

</html>