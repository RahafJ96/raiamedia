<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Admin - Dashboard</title>
        <!-- Favicon -->
        <link href="img/Raialogo.png" rel="icon">

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">

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

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                        </div>
                        
                        <?php
                        $a=0;
                         $sql = "SELECT * from offer";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                foreach ($results as $result20) {
                  $a+=1;
                }?>
                        <!-- Content Row -->
                        <div class="row">
                           
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Offers</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo  $a; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        $l=0;
                         $sql = "SELECT * from location";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                foreach ($results as $result20) {
                  $l+=1;
                }?>
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                     Locations</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo  $l; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-map-signs fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        $o=0;
                         $sql = "SELECT * from user_order";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                foreach ($results as $result20) {
                  $o+=1;
                }?>
                        

                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Orders</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo  $o; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-folder fa-2x text-gray-300"></i>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xl-4 col-lg-5"> -->
<hr>
<br/>
                        <!-- Content Row -->

                        <div class="row">
                            
                            <div class="col-xl-4 col-lg-5 scalecard">
                            <div class="card shadow mb-4">
                                <a href="totalcost.php">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                   Cost </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total Cost</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-coins fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            </div>

                            <div class="col-xl-4 col-lg-5 scalecard">
                            <div class="card shadow mb-4">
                                <a href="manage-locations.php">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                  Billboard Locations </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Manage Billboard Locations</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            </div>

                            <div class="col-xl-4 col-lg-5 scalecard">
                            <div class="card shadow mb-4">
                                <a href="manage-packages.php">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                  Special Packages </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Manage Packages</div>
                                                
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-box fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            </div>

                                 <div class="col-xl-4 col-lg-5 scalecard">
                            <div class="card shadow mb-4">
                                <a href="manage-orders.php">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                   Orders </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Manage Orders</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            </div>

                            <div class="col-xl-4 col-lg-5 scalecard">
                            <div class="card shadow mb-4">
                                <a href="add-location.php">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Billboard Locations </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Add Billboard Locations</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            </div>

                            <div class="col-xl-4 col-lg-5 scalecard">
                            <div class="card shadow mb-4">
                                <a href="add-packages.php">
                                <div class="card border-left-secondary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                   Special Packages </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Add Packages</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-box-open fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            </div>
                            
                        </div>

                        <?php include_once('includes/footer.php'); ?>


                    </div>
                    <!-- End of Content Wrapper -->

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