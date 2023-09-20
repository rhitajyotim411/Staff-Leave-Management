<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Homepage</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    .half {
      background-color: #EBFFFE;
      border-radius: 5px;
    }

    .half:hover {
      background-color: #ffffff;
      border-radius: 5px;
    }

    h1,
    h5,
    p {
      color: #08314A !important;
    }
  </style>
</head>

<?php
if (isset($_SESSION['UID'])) {
  echo "{$_SESSION['UID']} already logged in<br>";
  echo "Redirecting to dashboard...";
  die(header("refresh:2; URL=./{$_SESSION['type']}/dashboard.php"));
}
?>

<body style="background-color: #7FEDDF">
  <div class="container-fluid text-center" style="height: 100vh;">
    <div class="row justify-content-md-center mt-5">
      <h1>Log in to: - </h1>
      <div class="col-10 col-md-4 mt-5 mb-4">
        <div class="card">
          <div class="card-body half">
            <h5 class="card-title">Admin</h5>
            <p class="card-text">Login to view staff leaves</p>
            <a href="admin/login.php" class="btn btn-primary">Admin Login</a>
          </div>
        </div>
      </div>
      <div class="col-10 col-md-4 mt-5 mb-4">
        <div class="card">
          <div class="card-body half">
            <h5 class="card-title">Staff</h5>
            <p class="card-text">Login to apply for leave</p>
            <a href="staff/login.php" class="btn btn-primary">Staff Login</a>
          </div>
        </div>
      </div>
      <p>Not an user? Register <a href="register.php">here</a></p>
    </div>
  </div>
</body>

</html>