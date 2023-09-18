<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Leave</title>

    <style>
        table,
        th,
        td {
            border: 2px solid black;
            border-collapse: collapse;
            padding: 5px 10px;
        }

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

require_once '../connect.php';
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
        ':uid' => $_SESSION["staff_uid"]
    ]);

    $x = $_SESSION['referer'];
    $pg = explode('/', $x);
    $pg = end($pg);

    if ($pg != 'staff.php') {
        unset($_SESSION["staff_uid"]);
    }

    unset($_SESSION['referer']);
    die(header("Location: $x"));
}

$id = $_POST['stf_id'];
$_SESSION["staff_uid"] = $id;
$stmt = $conn->query("SELECT * FROM $tbname WHERE uid='$id'");
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
                    <input type="submit" name="edit_save" value="Save">
                </td>
            </tr>
        </table>
    </form>
</body>

</html>