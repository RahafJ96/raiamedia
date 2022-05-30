<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_POST['submit'])) {
		$id = $_GET['Ecid'];
		$Cn = $_POST['Cn'];
		$Cf = $_POST['Cf'];
		$Cl = $_POST['Cl'];

		$sql = "update  client set company_name=:Cn,client_fax=:Cf,client_landline=:Cl where client_id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':Cn', $Cn, PDO::PARAM_STR);
		$query->bindParam(':Cf', $Cf, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->bindParam(':Cl', $Cl, PDO::PARAM_STR);
		$query->execute();

		echo "<script>alert('Location updated successfully');</script>";
		echo "<script>window.location.href ='manage-clients.php'</script>";
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

    <title>Admin - Edit Client</title>
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
				<div class="grid-form1">
						<h3>Edit Client</h3>
						<?php
						$id = $_GET['Ecid'];
						$sql = "SELECT * from client where client_id=$id";
						$query = $dbh->prepare($sql);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
                     
						foreach ($results as $result) {
                            				?>
                                            
							<div class="tab-content">
								<div class="tab-pane active" id="horizontal-form">
									<form class="form-horizontal" name="Clientedit" method="post" enctype="multipart/form-data">
										<div class="form-group">
											<label for="focusedinput" class="col-sm-2 control-label">Company Name</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="Cn" id="Cn" value="<?php echo htmlentities($result->company_name); ?>" required>
											</div>
										</div>
									
									
										
										<div class="form-group">
											<label for="focusedinput" class="col-sm-2 control-label">Fax </label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="Cf" id="Cf" value="<?php echo htmlentities($result->client_fax); ?>" required>
											</div>
										</div>
										<div class="form-group">
											<label for="focusedinput" class="col-sm-2 control-label">Landline </label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="Cl" id="Cl" value="<?php echo htmlentities($result->client_landline); ?>" required>
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
