<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('export_excel.php');

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
                                <form action="alloffer.php" method="post" enctype="multipart/form-data">
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
                                <input type="date" name="start_date" class="form-control" required placeholder="Start Date">
                            </div>
                            <br>
                            <div class="col-sm-3">
                                <input type="date" name="end_date" class="form-control" required placeholder="End Date">
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" value="Search" name="submit" class="btn-success btn">
                            </div>
                            <!-- <div class="btn-group pull-right">
                                    <form method="post" action="search-offer.php">
                                        <input type="submit" name="submit" class="btn btn-warning" value="Export" />
                                    </form>
                            </div> -->
                            <br>
                            <div class="btn-group pull-right">
                                    <form method="post" action="alloffer.php">
                                        <input type="submit" name="export" class="btn btn-warning" value="Export" />
                                    </form>
                            </div>
                            <br>
                            <br>
                            </form>
                        </div>
                        <div>
                            <?php if (isset($_POST['submit'])) {
                                $location = $_POST['location'];
                                $start = $_POST['start_date'];
                                $end = $_POST['end_date'];
                                $cnt1 = 1;
                            ?>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unit </th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Price/month </th>
                                            <th>Discount </th>
                                            <th>Net Price </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($location != -1) {
                                            $sql = "SELECT * from location_offers where location_id=$location";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($results as $result9) {
                                                $y = ($result9->start_date);
                                                $y1 = ($result9->end_date);
                                                if ((($start < $y) && ($end > $y1)) || ($start == $y) && ($end > $y1) || ($start < $y) && ($end == $y1) || ($start == $y) && ($end == $y1)) {
                                        ?>

                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php $sql = "SELECT * from location where location_ide=($result9->location_id)";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            foreach ($results as $result1) {
                                                                echo htmlentities($result1->location_unit);
                                                            } ?></td>
                                                        <td><?php echo htmlentities($result9->start_date); ?></td>
                                                        <td><?php echo htmlentities($result9->end_date); ?></td>
                                                        <td><?php echo number_format($result9->price); ?> JD's</td>
                                                        <td><?php echo number_format($result9->discount); ?> JD's</td>
                                                        <td><?php echo number_format($result9->net_price); ?> JD's</td>

                                                    </tr>
                                                    <?php
                                                    $count += $result9->net_price;
                                                    ?>
                                            <?php }
                                            }

                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><b><?php echo $count; ?> JD's</b></td>

                                            </tr>
                                            <?php
                                        } else {
                                            $sql = "SELECT * from location_offers";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($results as $result9) {

                                                $y = ($result9->start_date);
                                                $y1 = ($result9->end_date);
                                                if ((($start < $y) && ($end > $y1)) || ($start == $y) && ($end > $y1) || ($start < $y) && ($end == $y1) || ($start == $y) && ($end == $y1)) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt1); ?></td>
                                                        <td><?php $sql = "SELECT * from location where location_ide=($result9->location_id)";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            foreach ($results as $result1) {
                                                                echo htmlentities($result1->location_unit);
                                                            } ?></td>

                                                        <td><?php echo htmlentities($result9->start_date); ?> </td>
                                                        <td><?php echo htmlentities($result9->end_date); ?></td>
                                                        <td><?php echo number_format($result9->price); ?> JD's</td>
                                                        <td><?php echo number_format($result9->discount); ?> JD's</td>
                                                        <td><?php echo number_format($result9->net_price); ?> JD's</td>
                                                        <?php
                                                        $count += $result9->net_price;
                                                        ?>
                                                    </tr>
                                            <?php
                                                    $cnt1 = $cnt1 + 1;
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><b><?php echo $count; ?> JD's</b></td>

                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                               

                        </div>


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