<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	//Code for Update
	if ($_GET['pid']) {
		$id = $_GET['pid'];
		$sql = "UPDATE `user_order` SET `notification` = '1' WHERE `user_order`.`order_id` =:id;";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
	}

    
	//Code for Deletion
	if ($_GET['rid']) {
		$id = $_GET['rid'];
		$sql = "delete from user_order where order_id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		echo "<script>alert('Record Deleted');</script>";
		echo "<script>window.location.href ='manage-orders.php'</script>";
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
                            <h1 class="h3 mb-0 text-gray-800">Manage Orders</h1>
                            <!-- <a href="add-packages.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Add new Package</a> -->
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr align="center">
                                    <th>#</th>
                                    <th>Company Name</th>
                                    <th>Company Email </th>
                                    <th>Key person</th>
                                    <th>Phone number </th>
                                    <th>Booking satiuation </th>
                                    <th>Location/Package name </th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php $sql = "SELECT * from user_order";
									$query = $dbh->prepare($sql);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
									if ($query->rowCount() > 0) {
										foreach ($results as $result) {				?>
                                <tr>
												<td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($result->company_name); ?></td>
                                    <td><?php echo htmlentities($result->company_email); ?></td>
                                    <td><?php echo htmlentities($result->key_person); ?></td>
                                    <td><?php echo htmlentities($result->phone_number); ?> </td>
                                    <td><?php echo htmlentities($result->booking_situation); ?></td>
                                 
                                     <?php
                                     $sql="SELECT * FROM `location` where location_ide =($result->location_ide)";
                                     $query = $dbh->prepare($sql);
									$query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($results as $result2) {	
                                     ?>
                                    <td><?php echo htmlentities ($result2->location_unit); ?></td>
                                    <?php } ?>
                                    <td> <a href="manage-orders.php?rid=<?php echo htmlentities($result->order_id); ?>" style="color:indianred;" onClick="return confirm('Do you really want to delete');"><i class="fas fa-trash-alt"></i> </a> |
                                    <?php if($result->notification == '1') {?>
                                    Checked 
                                    <?php } else { ?>
                                    <a href="manage-orders.php?pid=<?php echo htmlentities($result->order_id); ?>" style="color:peru" onClick="return confirm('Do you really Checked');">Check</a> 
<?php }?>
									</td>
                                    <?php $cnt = $cnt + 1;
                                     } ?>
                                    
                                </tr>
                               <?php
							 } else { ?>
                                <tr>
                                    <td colspan="8" align="center">No Record found</td>

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