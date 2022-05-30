<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
///Code for Updation 
if (isset($_POST['submit'])) {
	$id = $_GET['eppid'];
	$package_name = $_POST['package_name'];
	$package_price_1y = $_POST['package_price_1y'];
	$package_price_6m= $_POST['package_price_6m'];
	$package_price_3m= $_POST['package_price_3m'];
	$package_price_1m = $_POST['package_price_1m'];
	$package_price_1week= $_POST['package_price_1week'];

	$sql = "update packages set package_name=:package_name,package_price_1y=:package_price_1y,package_price_6m=:package_price_6m,package_price_3m=:package_price_3m,package_price_1m=:package_price_1m,package_price_1week=:package_price_1week where package_id=:id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':package_name', $package_name, PDO::PARAM_STR);
	$query->bindParam(':package_price_1y', $package_price_1y, PDO::PARAM_STR);
	$query->bindParam(':package_price_6m', $package_price_6m, PDO::PARAM_STR);
	$query->bindParam(':package_price_3m', $package_price_3m, PDO::PARAM_STR);
	$query->bindParam(':package_price_1m', $package_price_1m, PDO::PARAM_STR);
	$query->bindParam(':package_price_1week', $package_price_1week, PDO::PARAM_STR);
	$query->bindParam(':id', $id, PDO::PARAM_STR);
	$query->execute();

	echo "<script>alert('Package updated successfully');</script>";
	echo "<script>window.location.href ='manage-packages.php'</script>";
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

    <title>Admin - Add new Package</title>
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
    <?php include_once('includes/sidebar.php');?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include_once('includes/header.php');?>

                <div class="container-fluid">

                        <h3>Edit Package</h3>
						<?php
						$id = $_GET['eppid'];
						$sql = "SELECT * from packages where package_id='$id'";
						$query = $dbh->prepare($sql);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);

						foreach ($results as $result) {				?>
						<div class="tab-content">
							<div class="tab-pane active" id="horizontal-form">
								<form class="form-horizontal" name="addnewpackage" method="post" enctype="multipart/form-data">
								<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">Package Name</label>
										<div class="col-sm-8">
											<input type="text" name="package_name" class="form-control" value="<?php echo htmlentities($result->package_name); ?>" required>
										</div>
									</div>
									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">One Year package</label>
										<div class="col-sm-8">
											<input type="text" name="package_price_1y" class="form-control"  value="<?php echo htmlentities($result->package_price_1y); ?>" required placeholder="The price for a package in one year">
										</div>
									</div>
									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">Six months package</label>
										<div class="col-sm-8">
											<input type="text" name="package_price_6m" class="form-control" value="<?php echo htmlentities($result->package_price_6m); ?>" required placeholder="The price for a package in six months">
										</div>
									</div>
									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">Three months package</label>
										<div class="col-sm-8">
											<input type="text" name="package_price_3m" class="form-control" value="<?php echo htmlentities($result->package_price_3m); ?>" required placeholder="The price for a package in three months">
										</div>
									</div>

									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">One month package</label>
										<div class="col-sm-8">
											<input type="text" name="package_price_1m" class="form-control" value="<?php echo htmlentities($result->package_price_1m); ?>" required placeholder="The price for a package in one month">
										</div>
									</div>

									<div class="form-group">
										<label for="focusedinput" class="col-sm-2 control-label">One week package</label>
										<div class="col-sm-8">
											<input type="text" name="package_price_1week" class="form-control" value="<?php echo htmlentities($result->package_price_1week); ?>" required placeholder="The price for a package in one week">
										</div>
									</div>
						

									<div class="row">
											<div class="col-sm-8 col-sm-offset-2">
												<button type="submit" name="submit" class="btn-primary btn">update</button>

											</div>
										</div>
									</form>
						</div>
						
						
					</div>
					<?php } ?>


                </div>
            

                    <?php include_once('includes/footer.php');?>


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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
