<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	//Code for Deletion
	if ($_GET['rid']) {
		$id = $_GET['rid'];
		$sql = "delete from offer where offer_id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		echo "<script>alert('Offer Deleted');</script>";
		echo "<script>window.location.href ='add-offer.php'</script>";
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
		<title>Admin - Manage Offers</title>
		<!-- Favicon -->
		<link href="img/Raialogo.png" rel="icon">
		<!-- Custom fonts for this template-->
		<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- Custom styles for this template-->
		<link href="css/sb-admin-2.min.css" rel="stylesheet">
		<link href="css/offer.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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
							<h1 class="h3 mb-0 text-gray-800">Add new Offer</h1>
						</div>
						<div class="secondary">
							<div class="row">
								<div class="col-sm-3">
									<form action="add-offer.php" method="post" enctype="multipart/form-data">
										<select name="companyname" required class="form-control">
											<option value="">Choose company name </option>
											<?php
											$sql = "SELECT * from client";
											$query = $dbh->prepare($sql);
											$query->execute();
											$results = $query->fetchAll(PDO::FETCH_OBJ);
											foreach ($results as $result9) { ?>
												<option value="<?php echo htmlentities($result9->client_id); ?>"><?php echo htmlentities($result9->company_name); ?></option>
											<?php } ?>
										</select>
								</div>
								<div class="col-sm-3">
									<input type="submit" value="Insert" name="submit" class="btn-success btn">
								</div>
								<br>

								<br>

							</div>
							<div class="row">

							</div>
							</form>
						</div>
					</div>
					<br>
					<br>

					<h3 class="text-dark text-center font-weight-bold">Offer Description</h3>

					<br>
					<table class="table table-striped text-center">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Company Name</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>

							<?php $sql = "SELECT * from offer ";
							$query = $dbh->prepare($sql);
							$query->execute();
							$results = $query->fetchAll(PDO::FETCH_OBJ);
							$cnt = 1;
							foreach ($results as $result2) { ?>

								<tr>
									<td><?php echo htmlentities($cnt); ?></td>
									<td>
										<?php $sql = "SELECT * from client where client_id =($result2->client_id) ";
										$query = $dbh->prepare($sql);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_OBJ);
										$cnt = 1;
										foreach ($results as $result3) { ?>
											<?php echo htmlentities($result3->company_name); ?>
										<?php } ?>
									</td>
									<td><a href="add-location-offer.php?alpid=<?php echo htmlentities($result2->offer_id); ?>" class="text-warning">Locations</a> | <a href="add-offer.php?rid=<?php echo htmlentities($result2->offer_id); ?>" onClick="return confirm('Do you really want to delete');"><i class="fas fa-trash-alt text-danger"></i> </a></td>
								</tr>
							<?php $cnt = $cnt + 1;
							}
							?>
						</tbody>
					</table>
					<!-- <div class="row">
						<div class="col text-center">
							<a class="btn btn-primary pl-5 pr-5 text-center m-4">Add Offer </a>
						</div>
					</div> -->

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
		<!-- Bootstrap core JavaScript-->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Core plugin JavaScript-->
		<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

		<!-- Custom scripts for all pages-->
		<script src="js/sb-admin-2.min.js"></script>
		<script src="js/main.js"></script>

		<!-- Page level plugins -->
		<script src="vendor/chart.js/Chart.min.js"></script>

		<!-- Page level custom scripts -->
		<script src="js/demo/chart-area-demo.js"></script>
		<script src="js/demo/chart-pie-demo.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

		<!-- (Optional) Latest compiled and minified JavaScript translation files -->

	</body>

	</html>
<?php } ?>