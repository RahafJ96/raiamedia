<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $kpid = $_GET['Ecid'];
    if ($_GET['kpd']) {
        $id = $_GET['kpd'];
        $sql = "delete from `key_person` where keyperson_id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Record Deleted');</script>";
        echo "<script>window.location.href ='manage-clients.php'</script>";
    }
    if (isset($_POST['book'])) {

        $kp = $_POST['kp'];
        $Email = $_POST['Email'];
        $Mobile = $_POST['Mobile'];
        $kpid = $_GET['Ecid'];


        $sql = "INSERT INTO key_person (keyperson_id , keyperson_name , keyperson_email , keyperson_mobile , client_id) VALUES(NULL, :kp , :Email , :Mobile ,:kpid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':kp', $kp, PDO::PARAM_STR);
        $query->bindParam(':Email', $Email, PDO::PARAM_STR);
        $query->bindParam(':Mobile', $Mobile, PDO::PARAM_STR);
        $query->bindParam(':kpid', $kpid, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            echo "<script>alert('added successfully');</script>";
            echo "<script>window.location.href ='kp.php?Ecid= $kpid'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
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

        <title>Admin - Key Person</title>
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
                            <h3>Key Person</h3>


                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Key Person </th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $kpid = $_GET['Ecid'];
                                    $sql = "SELECT * from key_person where client_id= $kpid";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {                ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt); ?></td>
                                                <td><?php echo htmlentities($result->keyperson_name); ?></td>
                                                <td><?php echo htmlentities($result->keyperson_email); ?></td>
                                                <td><?php echo htmlentities($result->keyperson_mobile); ?></td>
                                                <td>
                                                   <a href="kp.php?kpd=<?php echo htmlentities($result->keyperson_id); ?>" style="color:red;" onClick="return confirm('Do you really want to delete');">Delete</a>
                                                </td>
                                            </tr>
                                    <?php $cnt = $cnt + 1;
                                        }
                                    } ?>
                                </tbody>
                            </table>


                            <div class="panel-footer">

                            </div>
                            </form>
                        </div>

								<form class="form-horizontal" name="kp" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label"> key person</label>
                            <div class="col-sm-8">
                                <input type="text" name="kp" class="form-control" required placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label"> Email</label>
                            <div class="col-sm-8">
                                <input type="text" name="Email" class="form-control" required placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label"> Mobile</label>
                            <div class="col-sm-8">
                                <input type="text" name="Mobile" class="form-control" required placeholder="Mobile">
                            </div>
                        </div>
                        <!-- <a type="submit" name="book" href="kp.php?Ecid= <?php echo $kpid ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add new Key Person</a> -->
                        <div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button href="kp.php?Ecid= <?php echo $kpid ?>" type="submit" name="book" class="btn-primary btn">Add</button>

											<button type="reset" class="btn-inverse btn">Reset</button>
										</div>
									</div>            
                    </form>
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