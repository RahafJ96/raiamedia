<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    //Code for Deletion

    if (isset($_POST['submit'])) {
        $location = $_POST['location'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        if ($location != -1) {
            $sql = "SELECT * from location_offers where location_id=$location";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            foreach ($results as $result9) {
                $d = ($result9->start_date);
                $new_date = date('Y', $d);
                // echo $new_date;
            }
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

        <title>Admin - Available Locations</title>
        <!-- Favicon -->
        <link href="img/Raialogo.png" rel="icon">

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">

    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            <?php include_once('includes/sidebar.php'); ?>


            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <?php include_once('includes/header.php'); ?>

                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800"> Locations Availability</h1>

                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <form action="available.php" method="post" enctype="multipart/form-data">
                                    <select name="location" required class="form-control">
                                        <option value="">Choose Location </option>
                                        <option value="-1">All Locations</option>
                                        <?php
                                        $sql = "SELECT * from location";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($results as $result9) { ?>
                                            <option value="<?php echo htmlentities($result9->location_ide); ?>"><?php echo htmlentities($result9->location_unit); ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                            <br>
                            <div class="col-sm-3">

                                <select name="month" required class="form-control">
                                    <option value="">Choose Month </option>

                                    <option value="1">January </option>
                                    <option value="2">February </option>
                                    <option value="3">March </option>
                                    <option value="4">April </option>
                                    <option value="5">May </option>
                                    <option value="6">June </option>
                                    <option value="7">July </option>
                                    <option value="8">August </option>
                                    <option value="9">September </option>
                                    <option value="10">October </option>
                                    <option value="11">November </option>
                                    <option value="12">December </option>


                                </select>
                            </div>

                            <br>
                            <div class="col-sm-3">
                                <select name="year" required class="form-control">
                                    <option value="">Choose year </option>
                                    <?php $d = date('Y'); ?>
                                    <option value="1"><?php echo date('Y') ?> </option>
                                    <option value="2"><?php echo (date('Y') + 1) ?> </option>
                                    <option value="3"><?php echo (date('Y') + 2) ?> </option>
                                    <option value="4"><?php echo (date('Y') + 3) ?> </option>
                                    <option value="5"><?php echo (date('Y') + 4) ?></option>



                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" value="Search" name="submit" class="btn-success btn">
                            </div>
                            <br>

                            <br>
                            <br>

                        </div>
                        <?php if (isset($_POST['submit'])) {
                            $location = $_POST['location'];
                            $month = $_POST['month'];
                            $years = $_POST['year'];
                            $years = date('Y') + $years - 1;
                            $unavailable = 0;
                            if ($location != -1) {
                                $monthNum  = $month;
                                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                $monthName = $dateObj->format('F');

                                for ($s = 1; $s <= 31; $s++) {
                                    $sql = "UPDATE `months` SET `available` =0 WHERE `months`.`month_id` = $s;";

                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                }
                                $sql = "SELECT * from location_offers where location_id=$location";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                foreach ($results as $result9) {

                                    $y = ($result9->start_date);
                                    $m = ($result9->start_date);
                                    $y1 = ($result9->end_date);
                                    $m2 = ($result9->end_date);
                                    $day = date('d', strtotime($m));
                                    $day1 = date('d', strtotime($m2));
                                    $mo2 = date('m', strtotime($m2));
                                    $year2 = date('Y', strtotime($y2));
                                    $mo = date('m', strtotime($m));
                                    $year = date('Y', strtotime($y));
                                    if ((($month > $mo) && ($month < $mo2)) && ($unavailable == 0) && ($year == $years)) {

                                        $unavailable = 1;
                                        for ($z = 1; $z <= 31; $z++) {
                                            $sql = "UPDATE `months` SET `available` =1 WHERE `months`.`month_id` = $z;";

                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                        }
                                    } else if (($month == $mo) || ($month == $mo2) && ($unavailable == 0)) {
                                        if (($month == $mo) && ($month == $mo2) && ($year == $years)) {
                                            for ($z = $day; $z <= $day1; $z++) {
                                                $sql = "UPDATE `months` SET `available` =1 WHERE `months`.`month_id` = $z;";

                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                            }
                                        } elseif (($month == $mo) && ($year == $years)) {

                                            for ($z = $day; $z <= 31; $z++) {
                                                $sql = "UPDATE `months` SET `available` =1 WHERE `months`.`month_id` = $z;";

                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                            }
                                        } elseif (($month == $mo2) && ($year == $years)) {

                                            for ($z = 1; $z <= $day1; $z++) {
                                                $sql = "UPDATE `months` SET `available` =1 WHERE `months`.`month_id` = $z;";

                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                            }
                                        }
                                    }
                                }
                                $sql = "SELECT * from location where location_ide=$location";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                foreach ($results as $result1) {
                        ?>

                                    <h4><?php echo htmlentities($result1->location_unit) ?></h4>
                                <?php } ?>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-8" id="displaySeats">
                                            <h4 class="text-center"><?php echo "$monthName - $years" ?></h4>

                                            <?php
                                            $sql = "SELECT * from months";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($results as $result1) {
                                                if ($result1->available == true) {
                                            ?>
                                                    <div class="calender" style="background-color: #E81C2E; color:white"><?php echo htmlentities($result1->month_id) ?></div>
                                                <?php } else if ($result1->available == false) { ?>
                                                    <div class="calender" style="background-color: #39B972; color:white"><?php echo htmlentities($result1->month_id) ?></div>
                                            <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } else {
                                $monthNum  = $month;
                                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                $monthName = $dateObj->format('F');
                            ?>


                                <h4><?php echo htmlentities($result1->location_unit) ?></h4>
                                <?php
                                $sql = "SELECT * from location ";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                foreach ($results as $result2) {
                                    for ($s = 1; $s <= 31; $s++) {
                                        $sql = "UPDATE `months` SET `available` =0 WHERE `months`.`month_id` = $s;";

                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                    }
                                    $sql = "SELECT * from location_offers where location_id=($result2->location_ide)";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($results as $result9) {

                                        $y = ($result9->start_date);
                                        $m = ($result9->start_date);
                                        $y1 = ($result9->end_date);
                                        $m2 = ($result9->end_date);
                                        $day = date('d', strtotime($m));
                                        $day1 = date('d', strtotime($m2));
                                        $mo2 = date('m', strtotime($m2));
                                        $year2 = date('Y', strtotime($y2));
                                        $mo = date('m', strtotime($m));
                                        $year = date('Y', strtotime($y));
                                        if ((($month > $mo) && ($month < $mo2)) && ($unavailable == 0) && ($year == $years)) {

                                            $unavailable = 1;
                                            for ($z = 1; $z <= 31; $z++) {
                                                $sql = "UPDATE `months` SET `available` =1 WHERE `months`.`month_id` = $z;";

                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                            }
                                        } else if (($month == $mo) || ($month == $mo2) && ($unavailable == 0)) {
                                            if (($month == $mo) && ($month == $mo2) && ($year == $years)) {
                                                for ($z = $day; $z <= $day1; $z++) {
                                                    $sql = "UPDATE `months` SET `available` =1 WHERE `months`.`month_id` = $z;";

                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                }
                                            } elseif (($month == $mo) && ($year == $years)) {

                                                for ($z = $day; $z <= 31; $z++) {
                                                    $sql = "UPDATE `months` SET `available` =1 WHERE `months`.`month_id` = $z;";

                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                }
                                            } elseif (($month == $mo2) && ($year == $years)) {

                                                for ($z = 1; $z <= $day1; $z++) {
                                                    $sql = "UPDATE `months` SET `available` =1 WHERE `months`.`month_id` = $z;";

                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                }
                                            }
                                        }
                                    }

                                ?>
                                <h4><?php echo htmlentities($result2->location_unit) ?></h4>
                                    <?php
                                    ?>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-8" id="displaySeats">
                                                <h4 class="text-center"><?php echo "$monthName - $years" ?></h4>

                                                <?php
                                                $sql = "SELECT * from months";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($results as $result1) {
                                                    if ($result1->available == true) {
                                                ?>
                                                        <div class="calender" style="background-color: #E81C2E; color:white"><?php echo htmlentities($result1->month_id) ?></div>
                                                    <?php } else if ($result1->available == false) { ?>
                                                        <div class="calender" style="background-color: #39B972; color:white"><?php echo htmlentities($result1->month_id) ?></div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        } ?>



                    </div>


                    <?php include_once('includes/footer.php'); ?>


                </div>
                <!-- End of Content Wrapper -->

            </div>
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>

    </body>

    </html>
<?php } ?>