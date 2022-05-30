<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	//Code for Deletion
	if ($_GET['pid']) {
		$id = $_GET['pid'];
		$sql = "delete from packages where package_id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		echo "<script>alert('Record Deleted');</script>";
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
    <?php include_once('includes/sidebar.php');?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include_once('includes/header.php');?>

                <div class="container-fluid">
                                              <!-- Page Heading -->
                                              <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Manage Packages</h1>
                            <a href="add-packages.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Add new Package</a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Package Name</th>
                                    <th>One Year </th>
                                    <th>6 months</th>
                                    <th>3 months </th>
                                    <th>1 months </th>
                                    <th>1 week</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $sql = "SELECT * from packages";
									$query = $dbh->prepare($sql);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
									if ($query->rowCount() > 0) {
										foreach ($results as $result) {				?>
                                <tr>
												<td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($result->package_name); ?></td>
                                    <td><?php echo htmlentities($result->package_price_1y); ?> JD</td>
                                    <td><?php echo htmlentities($result->package_price_6m); ?> JD</td>
                                    <td><?php echo htmlentities($result->package_price_3m); ?> JD</td>
                                    <td><?php echo htmlentities($result->package_price_1m); ?> JD</td>
                                    <td><?php echo htmlentities($result->package_price_1week); ?> JD</td>
                                    <td>
                                    <a href="manage-packages.php?pid=<?php echo htmlentities($result->package_id); ?>" style="color:lightcoral" onClick="return confirm('Do you really want to delete');">Delete</a> | 
                                    <a href="editpackages.php?eppid=<?php echo htmlentities($result->package_id); ?>">Edit</a>
									</td>
                                    <?php $cnt = $cnt + 1;
                                     } ?>
                                    
                                </tr>
                               <?php
							 } else { ?>
                                <tr>
                                    <td>No Record found</td>

                                </tr>
                                <?php } ?>
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
