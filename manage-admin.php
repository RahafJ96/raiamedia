<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $kpid = $_GET['ahmad'];

    //Code for Deletion
    if ($_GET['cd']) {
        $id = $_GET['cd'];
        if($id!=1){
        $sql = "delete from `admin` where id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Record Deleted');</script>";
        echo "<script>window.location.href ='manage-admin.php'</script>";
        }else{
            echo "<script>alert('Can't delete this admin ');</script>";
            echo "<script>window.location.href ='manage-admin.php'</script>";
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

        <title>Admin - Manage Admin</title>
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
                    <?php if (($_SESSION['alogin'])=="admin") {?>
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Manage Admin</h1>
                        </div>
                        <!-- WORK HERE -->
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Admin Name</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $sql = "SELECT * from admin";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {                ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt); ?></td>
                                            <td><?php echo htmlentities($result->UserName); ?></td>
                                            


                                            <td>
                                                <a href="manage-admin.php?cd=<?php echo htmlentities($result->id); ?>" style="color:red;" onClick="return confirm('Do you really want to delete');">Delete</a>
                                            </td>
                                        </tr>

                                <?php $cnt = $cnt + 1;
                                    }
                                } ?>
                            </tbody>
                            
                        </table>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <form action="manage-admin.php?alpid= <?php echo $xpid ?>" method="post" enctype="multipart/form-data">
                                    Username
                                    <input type="text" name="username" class="form-control">
                                    Password
                                    <input type="password" name="password" class="form-control">
                                    Confirm password
                                    <input type="password" name="password1" class="form-control">

                                    <br>
                                    <?php if (isset($_POST['submit'])) {
                                        $name = $_POST['username'];
                                        $pass = $_POST['password'];
                                        $pass1 = $_POST['password1'];
                                        $d = 0;
                                        $sql = "SELECT * from admin";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                if ($name == ($result->UserName)) {
                                                    $d = 1;
                                                }
                                            }
                                        }
                                        if ($d == 1) {
                                    ?>
                                            <h6 class="text-danger">*This username in used </h6>
                                        <?php
                                        } elseif ($pass != $pass1) {
                                        ?>
                                            <h6 class="text-danger">*The password dosen't match </h6>
                                    <?php
                                        } else {
                                            $time = date("Y-m-d h:i:s");
                                            echo $time;
                                            $pass = md5($pass);
                                            $sql = "INSERT INTO admin (id,UserName,Password,updationDate) VALUES(NULL,:name,:pass, :time)";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':name', $name, PDO::PARAM_STR);
                                            $query->bindParam(':pass', $pass, PDO::PARAM_STR);
                                            $query->bindParam(':time', $time, PDO::PARAM_STR);


                                            $query->execute();
                                            $lastInsertId = $dbh->lastInsertId();
                                            if ($lastInsertId) {
                                                echo "<script>alert('added successfully');</script>";
                                                echo "<script>window.location.href ='manage-admin.php'</script>";
                                            } else {
                                                echo "<script>alert('Something went wrong. Please try again.');</script>";
                                            }
                                        }
                                    } ?>
                                    <input type="submit" value="upload" name="submit" class="btn-primary btn">
                                </form>
                            </div>
                        </div>
                    </div>
             <?php } ?>

                    <?php include_once('includes/footer.php'); ?>

                    <!-- View Modal -->

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php

                                    $sql = "SELECT * from key_person where client_id=$kpid";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) { ?>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Company Name</th>
                                                    <th> Fax</th>
                                                    <th> Landline</th>
                                                    <th> Key Person</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                    <?php    } else {
                                        echo $kpid;
                                    } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

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