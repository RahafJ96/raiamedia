<?php
session_start();
include('includes/config.php');
if (isset($_POST['login'])) {
  $uname = $_POST['username'];
  $password = md5($_POST['password']);
  $sql = "SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
  $query = $dbh->prepare($sql);
  $query->bindParam(':uname', $uname, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    $_SESSION['alogin'] = $_POST['username'];
    echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
  } else {

    echo "<script>alert('Invalid Details');</script>";
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/styles.css" rel="stylesheet">
  <!-- Favicon -->
  <link href="img/Raialogo.png" rel="icon">



</head>

<body>
  <div class="loginform">
    <div class="form">
      <img src="img/RAIAHEADER.png" style="display: block;
  margin-left: auto;
  margin-right: auto;
  width: 70%;margin-top:3rem;margin-bottom:4rem" />
      <form method="post">
        <div class="form-field">
          <label for="login-mail"><i class="fa fa-user"></i></label>
          <input type="text" name="username" class="name" placeholder="Username" required="">
        </div>
        <div class="form-field">
          <label for="login-password"><i class="fa fa-lock"></i></label>
          <input type="password" name="password" class="password" placeholder="Password" required="">
        </div>

        <button type="submit" class="button" name="login">
          <div class="arrow-wrapper">
            <span class="arrow"></span>
          </div>
          <p class="button-text">SIGN IN</p>
        </button>
      </form>
      <!-- <div class="back">
        <a href="../index.php">Back to home</a>
      </div> -->
    </div>
  </div>


  <!-- //--- ## SVG SYMBOLS ############# -->
  <svg style="display:none;">
    <symbol id="svg-check" viewBox="0 0 130.2 130.2">
      <polyline points="100.2,40.2 51.5,88.8 29.8,67.5 " />
    </symbol>
  </svg>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->

</body>

</html>