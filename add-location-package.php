<?php
session_start();
error_reporting(0);
include('includes/config.php');
$xpid = $_GET['alpid'];
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    //Code for Deletion
    if ($_GET['rid']) {
        $id = $_GET['rid'];
        $sql = "delete from location_packages where location_id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Location Deleted');</script>";
        echo "<script>window.location.href ='manage-packages.php'</script>";
    }

    if (isset($_POST['submit'])) {
        $xpid = $_GET['alpid'];
        $packagename = $_POST['packagename'];
        // Insert location into package 
        $insert = $dbh->query("INSERT into location_packages(location_package_id, location_id,package_id) VALUES (NULL,$packagename, $xpid)");
        if ($insert) {
            echo "<script>alert('Location uploaded successfully.');</script>";
            echo "<script>window.location.href ='manage-packages.php'</script>";
        } else {
            $statusMsg = "Location upload failed, please try again.";
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
                        <h1 class="h3 mb-0 text-gray-800">Manage Locations for each package</h1>

                    </div>
                    <?php
                    $sql = "SELECT * from `packages` where package_id=$xpid";
                    ?>

                    <?php $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach ($results as $result1)
                    ?>
                    <h1>
                        <p><?php echo ($result1->package_name); ?></p>
                    </h1>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Location Unit </th>
                                <th>Billboard Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $sql = "SELECT * from location_packages where package_id=$xpid";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            foreach ($results as $result2) { ?>
                                <?php $sql = "SELECT * from location where location_ide=($result2->location_id)";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                foreach ($results as $result) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($result->location_unit); ?></td>
                                        <td><?php echo htmlentities($result->location_name); ?></td>
                                        <td>
                                            <a href="add-location-package.php?rid=<?php echo htmlentities($result->location_ide); ?>" style="color:red;" onClick="return confirm('Do you really want to delete');">Delete</a>
                                        </td>
                                    </tr>
                            <?php $cnt = $cnt + 1;
                                }
                            } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <form action="add-location-package.php?alpid= <?php echo $xpid ?>" method="post" enctype="multipart/form-data">
                                Add Location to the package
                                <select name="packagename" required class="form-control">
                                    <option value="">Add location ... </option>
                                    <?php
                                    $sql = "SELECT * from location";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($results as $result9) { ?>
                                        <option value="<?php echo htmlentities($result9->location_ide); ?>"><?php echo htmlentities($result9->location_unit); ?></option>
                                    <?php } ?>
                                </select>
                                <br>

                                <input type="submit" value="upload" name="submit" class="btn-primary btn">
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