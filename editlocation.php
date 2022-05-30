<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_POST['submit'])) {
		$id = $_GET['wpid'];
		$ln = $_POST['locationname'];
		$lsh = $_POST['locationsizeh'];
		$lsw = $_POST['locationsizew'];
		$lp = $_POST['locationprice'];
		$la = $_POST['locationavailability'];
		$lc = $_POST['locationcoor'];
		$lad = $_POST['locationAD'];

		$sql = "update  location set location_name=:ln,location_size_height=:lsh,location_size_width=:lsw,location_price=:lp,location_availability=:la,location_coordinates=:lc,location_available_details=:lad where location_ide=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':ln', $ln, PDO::PARAM_STR);
		$query->bindParam(':lsh', $lsh, PDO::PARAM_STR);
		$query->bindParam(':lsw', $lsw, PDO::PARAM_STR);
		$query->bindParam(':lp', $lp, PDO::PARAM_STR);
		$query->bindParam(':la', $la, PDO::PARAM_STR);
		$query->bindParam(':lc', $lc, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->bindParam(':lad', $lad, PDO::PARAM_STR);
		$query->execute();

		echo "<script>alert('Location updated successfully');</script>";
		echo "<script>window.location.href ='manage-locations.php'</script>";
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
			<?php include_once('includes/sidebar.php'); ?>


			<!-- Content Wrapper -->
			<div id="content-wrapper" class="d-flex flex-column">

				<!-- Main Content -->
				<div id="content">

					<?php include_once('includes/header.php'); ?>

					<div class="container-fluid">
						<div class="grid-form1">
							<h3>Edit Billboard location</h3>
							<?php
							$id = $_GET['wpid'];
							$sql = "SELECT * from location where location_ide='$id'";
							$query = $dbh->prepare($sql);
							$query->execute();
							$results = $query->fetchAll(PDO::FETCH_OBJ);

							foreach ($results as $result) {				?>
								<div class="tab-content">
									<div class="tab-pane active" id="horizontal-form">
										<form class="form-horizontal" name="locationpoint" method="post" enctype="multipart/form-data">
											<div class="form-group">
												<label for="focusedinput" class="col-sm-2 control-label">Location Name</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="locationname" id="locationname" value="<?php echo htmlentities($result->location_name); ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label for="focusedinput" class="col-sm-2 control-label">Location size </label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="locationsizeh" id="locationsizeh" value="<?php echo htmlentities($result->location_size_height); ?>" required>
												</div>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="locationsizew" id="locationsizew" value="<?php echo htmlentities($result->location_size_width); ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label for="focusedinput" class="col-sm-2 control-label">Location price </label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="locationprice" id="locationprice" value="<?php echo htmlentities($result->location_price); ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label for="focusedinput" class="col-sm-2 control-label">Location availability </label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="locationavailability" id="locationavailability" value="<?php echo htmlentities($result->location_availability); ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label for="focusedinput" class="col-sm-2 control-label">Location coordinates </label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="locationcoor" id="locationcoor" value="<?php echo htmlentities($result->location_coordinates); ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label for="focusedinput" class="col-sm-2 control-label">location Available Details </label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="locationAD" id="locationAD" value="<?php echo htmlentities($result->location_available_details); ?>">
												</div>
											</div>






											<div class="row">
												<div class="col-sm-8 col-sm-offset-2">
													<button type="submit" name="submit" class="btn-primary btn">update</button>

												</div>
											</div>





									</div>

									</form>
								<?php } ?>




								<div class="panel-footer">

								</div>
								</form>
								</div>
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