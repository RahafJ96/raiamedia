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
		$sql = "delete from location where location_ide=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		echo "<script>alert('Record Deleted');</script>";
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

    <title>Admin - Manage Offers</title>
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
                                              <!-- Page Heading -->
                                              <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Manage Offers</h1>
                            <a href="add-offer.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Add new Offer</a>
                        </div>
                        <table class="table table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Location Name</th>
										<th>Location Size</th>
										<th>Location availability</th>
										<th>Location price</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $sql = "SELECT * from location";
									$query = $dbh->prepare($sql);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt = 1;
									if ($query->rowCount() > 0) {
										foreach ($results as $result) {				?>
											<tr>
												<td><?php echo htmlentities($cnt); ?></td>
												<td><?php echo htmlentities($result->location_name); ?></td>
												<td><?php echo htmlentities($result->location_size); ?></td>
												<td><?php echo htmlentities($result->location_availability); ?></td>
												<td><?php echo htmlentities($result->location_price); ?></td>
												<td>
												<a href="add-photo.php?wpid=<?php echo htmlentities($result->location_ide); ?>">Edit photo</a> |<a href="editlocation.php?wpid=<?php echo htmlentities($result->location_ide); ?>">Edit</a> | <a href="manage-locations.php?rid=<?php echo htmlentities($result->location_ide); ?>" style="color:red;" onClick="return confirm('Do you really want to delete');">Delete</a>
												</td>
											</tr>
									<?php $cnt = $cnt + 1;
										}
									} ?>
								</tbody>
							</table>


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
