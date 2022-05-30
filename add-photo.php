<?php
session_start();
error_reporting(0);
include('includes/config.php');
$pid = $_GET['wpid'];
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    //Code for Deletion
    if ($_GET['rid']) {
        $id = $_GET['rid'];
        $sql = "SELECT * from photos where photo_id=$id";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        
        foreach ($results as $result2) {
            $z= ($result2->offer_id);

        }
        $sql = "delete from photos where photo_id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Photo Deleted');</script>";
        echo "<script>window.location.href ='manage-locations.php'</script>";
    }

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $pid = $_GET['wpid'];
        if (!empty($_FILES["image"]["name"])) {
            $lid = $_GET['wpid'];
            // Get file info 
            $fileName = basename($_FILES["image"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            // Allow certain file formats 
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['image']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));

                // Insert image content into database 
                $insert = $dbh->query("INSERT into photos (`photo_id`, `photo_location`,`location_id`) VALUES (NULL,'$imgContent', $lid)");

                if ($insert) {
                    $status = 'success';
                    $statusMsg = "File uploaded successfully.";
                } else {
                    $statusMsg = "File upload failed, please try again.";
                }
            } else {
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
            }
        } else {
            $statusMsg = 'Please select an image file to upload.';
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
                        <h1 class="h3 mb-0 text-gray-800">Manage Packages</h1>

                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "SELECT * from photos where location_id = $pid";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) {                ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo '<img src="data:image/png;base64,' . base64_encode($result->photo_location) . '" width="100" height="120"/>'; ?></td>
                                        <td>
                                            <a href="add-photo.php?rid=<?php echo htmlentities($result->photo_id); ?>" style="color:red;" onClick="return confirm('Do you really want to delete');">Delete</a>
                                        </td>
                                    </tr>
                            <?php $cnt = $cnt + 1;
                                }
                            } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <form action="add-photo.php?wpid= <?php echo $pid ?>" method="post" enctype="multipart/form-data">
                                Select image to upload:
                                <input type="file" name="image" id="fileToUpload" class="btn-primary btn">
                                <input type="submit" value="Upload Image" name="submit" class="btn-primary btn">
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