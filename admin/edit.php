<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Leave</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
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

<body>
    <?php require '../inc/header.php' ?>
    <div class="container-fluid text-center mt-3">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
            header('HTTP/1.0 403 Forbidden', TRUE, 403);
            echo '<h2 style="color: red">Access Denied!!</h2>';
            echo 'Redirecting...';
            die(header("refresh:2; URL=../index.php"));
        }

        require_once '../inc/connect.php';
        $tbname = "staff_leave";

        if (!isset($_SESSION['referer']))
            $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];

        if (isset($_POST['edit_save'])) {
            $sql = "UPDATE $tbname SET EL=:el, CL=:cl, SL=:sl WHERE UID=:uid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':el' => $_POST['EL'],
                ':cl' => $_POST['CL'],
                ':sl' => $_POST['SL'],
                ':uid' => $_POST['edit_id']
            ]);

            $x = $_SESSION['referer'];
            $pg = explode('/', $x);
            $pg = end($pg);

            if ($pg === 'staff.php') {
                $_SESSION["staff_uid"] = $_POST['edit_id'];
            }

            unset($_SESSION['referer']);
            die(header("Location: $x"));
        }

        $id = $_POST['stf_id'];

        $stmt = $conn->query("SELECT * FROM $tbname WHERE uid='$id'");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>

        <h2>Edit for
            <?php echo $id ?>
        </h2>
        <div class="d-flex justify-content-center">
            <hr>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="hidden" name="edit_id" value="<?php echo $id ?>">
            <div class="d-flex justify-content-center mt-3 mb-3">
                <div class="overflow-auto">
                    <table>
                        <tr>
                            <td>
                                <label for="EL">Earned leave (EL): </label>
                                <input type="number" name="EL" value="<?php echo $data["EL"] ?>">
                            </td>
                            <td>
                                <label for="CL">Casual leave (CL): </label>
                                <input type="number" name="CL" value="<?php echo $data["CL"] ?>">
                            </td>
                            <td>
                                <label for="SL">Sick leave (SL): </label>
                                <input type="number" name="SL" value="<?php echo $data["SL"] ?>">
                            </td>
                            <td>
                                <input type="submit" name="edit_save" class="btn btn-primary" value="Save">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
</body>

</html>