<?php
session_start();
error_reporting(0);
include('includes/config.php');
$pid = $_GET['wpid'];
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    //Code for Deletion
    if (($_GET['rid'])) {
        $id = $_GET['rid'];
        $sql = "delete from cost where cost_id=:id";
        $sql2 = "delete from cost_details where cost_id=:id";
        $query = $dbh->prepare($sql);
        $query2 = $dbh->prepare($sql2);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $query2->bindParam(':id', $id, PDO::PARAM_STR);
        $query2->execute();
        echo "<script>alert('Deleted');</script>";
        echo "<script>window.location.href ='manage-locations.php'</script>";
    }

    if (isset($_POST['submit'])) {
        $cost_value1 = $_POST['cost_value1'];
        $cost_value = $_POST['cost_value'];
        $I_date = $_POST['Invoice_date'];
        $newDate = date("Ymd", strtotime($I_date));  
        $Invoice_number = $_POST['Invoice_number'];
        $cost_date = date("Ymd");
        $sql = "SELECT * from `cost` where cost_id= $cost_value1";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $total = 0;
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {

                $total += ($result->cost_total);
            }
        }
        $sum=$total+$cost_value;
        $sql="UPDATE `cost` SET `cost_total` =$sum WHERE `cost`.`cost_id` = $cost_value1;";
        
        $query = $dbh->prepare($sql);
        $query->execute();

        // Insert location into package 
        $insert = $dbh->query("INSERT into `cost_details`(`cost_details_id`, `cost_value`, `cost_date`, invoice_date , `cost_id`, `ref_number`)  VALUES (NULL, $cost_value, $cost_date , $newDate, $cost_value1 , $Invoice_number)");

        if (($insert) ) {
            echo "<script>alert('Updated seccessfully $I_date');</script>";
            echo "<script>window.location.href ='cost.php?wpid=$pid'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
            echo "<script>window.location.href ='cost.php?wpid=$pid'</script>";
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

    <title>Admin - Manage Cost</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Manage Cost</h1>
                        <a href="add-cost.php?cpid= <?php echo $pid; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add new Cost</a>

                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cost Type</th>
                                <th>Cost Value</th>
                                <!-- <th>Total Cost</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "SELECT * from cost where location_ide = $pid";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            $count = 0;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) {                ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($result->cost_name); ?></td>

                                        <td><?php echo htmlentities($result->cost_total); ?> JD's</td>

                                        <?php
                                        $count += $result->cost_total;
                                        ?>
                                        <td>
                                            <a href="cost.php?rid=<?php echo htmlentities($result->cost_id); ?>" style="color:red;" onClick="return confirm('Do you really want to delete');">Delete</a>
                                        </td>
                                    </tr>

                            <?php $cnt=$cnt+1; }
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
						<td><b><?php echo $count; ?> JD's</b></td>

                            </tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <form method="post" enctype="multipart/form-data">
                            Choose the type of invoice Cost
                                <select name="cost_value1" required class="form-control">
                                    <option value="">Add Cost ... </option>
                                    <?php
                                    $sql = "SELECT * from cost where  location_ide=$pid";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($results as $result9) { ?>
                                        <option value="<?php echo htmlentities($result9->cost_id); ?>"><?php echo htmlentities($result9->cost_name); ?></option>
                                    <?php } ?>
                                </select>
                                <br>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label">Invoice Value</label>
                                    <div class="col-sm-8">
                                        <input type="float" name="cost_value" class="form-control" required placeholder="Invoice Value">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label">Invoice Number</label>
                                    <div class="col-sm-8">
                                        <input type="float" name="Invoice_number" class="form-control" required placeholder="Reference Number">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label">Invoice date</label>
                                    <div class="col-sm-8">
                                        <input type="date" name="Invoice_date" id="Invoice_date" class="form-control" required placeholder="Cost date">
                                    </div>
                                </div>
                                

                                <input type="submit" value="upload" name="submit" class="btn-primary btn">

                            </form>
                        </div>
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