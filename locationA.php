<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
   
   ?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seats</title>
        <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d8cfbe84b9.js" crossorigin="anonymous"></script>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Manage Locations</title>
  <!-- Favicon -->
        <link href="img/Raialogo.png" rel="icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
  

</head>

<body id="page-top">
<?php
                $locSql = "Select * from location";
                $resultlocSql = mysqli_query($conn, $locSql);
                $arr = array();
                while($row = mysqli_fetch_assoc($resultlocSql))
                    $arr[] = $row;
                $locJson = json_encode($arr);
            ?>w
    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php include_once('includes/sidebar.php');?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include_once('includes/header.php');?>
            <h4>Location Status</h4>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                        <div class="searchLoc">
                            <input type="text" id="location-no" name="location-no" placeholder="Location name"
                            class="busnoInput">
                            <div class="sugg">
                            </div>
                        </div>
                       
      
                        <!-- Sending busJson -->
                        <input type="hidden" id="locJson" name="locJson" value='<?php echo $locJson; ?>'>
                        <button type="submit" name="submit">Search</button>
                    </form>

</html>
<?php } ?>