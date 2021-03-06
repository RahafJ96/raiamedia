<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Code for Booking
    if (isset($_POST['book'])) {
        $lunit = $_POST['lunit'];
        $lname = $_POST['lname'];
        $lsizeh = $_POST['Lsizeh'];
        $lsizew = $_POST['Lsizew'];
        $Lprice = $_POST['Lprice'];
        $Lc = $_POST['Lc'];
        $sql = "INSERT INTO location (location_ide,location_unit,location_name,location_size_height,location_size_width,location_availability, location_price, location_coordinates, location_available_details) VALUES(NULL,:lunit, :lname, :lsizeh,:lsizew, '1', :Lprice, :Lc, NULL)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':lunit', $lunit, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':lsizeh', $lsizeh, PDO::PARAM_STR);
        $query->bindParam(':lsizew', $lsizew, PDO::PARAM_STR);
        $query->bindParam(':Lprice', $Lprice, PDO::PARAM_STR);
        $query->bindParam(':Lc', $Lc, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            echo "<script>alert('added successfully');</script>";
            echo "<script>window.location.href ='add-location.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
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

        <title>Admin - Manage Packages</title>
        <!-- Favicon -->
        <link href="img/Raialogo.png" rel="icon">

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
                            <h1 class="h3 mb-0 text-gray-800">Manage Packages</h1>

                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="horizontal-form">
                                <form class="form-horizontal" name="locationpoint" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Location Unit</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="lunit" class="form-control" required placeholder="The unit Of Billboard Location">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Location Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="lname" class="form-control" required placeholder="The Name Of Billboard Location">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Size</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="Lsizeh" class="form-control" required placeholder="The Height Of Billboard Location">
                                            <input type="text" name="Lsizew" class="form-control" required placeholder="The Width Of Billboard Location">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Price</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="Lprice" class="form-control" required placeholder="The Price in JD currency">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Location coordinates</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="Lc" class="form-control" required placeholder="Location Coordinates">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button type="submit" name="book" class="btn-primary btn">Add</button>

                                            <button type="reset" class="btn-inverse btn">Reset</button>
                                        </div>
                                    </div>



                            </div>

                            </form>





                            <div class="panel-footer">

                            </div>
                            </form>
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
                            <span aria-hidden="true">??</span>
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