<?php
session_start();
error_reporting(0);
include('includes/config.php');
$xpid = $_GET['alpid'];
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $count = 0;
    //Code for Deletion
    if ($_GET['rid']) {
        $id = $_GET['rid'];
        $sql = "SELECT * from location_offers where location_offer_id=$id";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($results as $result2) {
            $z = ($result2->offer_id);
        }
        $sql = "delete from location_offers where location_offer_id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Location Deleted');</script>";
        echo "<script>window.location.href ='add-location-offer.php?alpid=$z'</script>";
    }
    //Code for Deletion
    if ($_GET['cid']) {
        $id = $_GET['cid'];
        $sql = "SELECT * from cost_offer where cost_offer_id=$id";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($results as $result2) {
            $z = ($result2->offer_id);
        }
        $sql = "delete from cost_offer where cost_offer_id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Cost Deleted');</script>";
        echo "<script>window.location.href ='add-location-offer.php?alpid=$z'</script>";
    }

    if (isset($_POST['submit'])) {
        $xpid = $_GET['alpid'];
        $locationname = $_POST['locationname'];
        $sdate = $_POST['startdate'];
        $edate = $_POST['endate'];
        $price = $_POST['price'];
        $sdate = date("Ymd", strtotime($sdate));
        $edate = date("Ymd", strtotime($edate));
        $dis = $_POST['dis'];
        $netprice = ($price - $dis);
        // Insert location into offer 
        $insert = $dbh->query("INSERT into location_offers(location_offer_id, location_id,offer_id,discount,`start_date`,end_date,price,net_price,	offer) VALUES (NULL,$locationname, $xpid,$dis,$sdate,$edate,$price,$netprice,0)");
        if ($insert) {
            echo "<script>alert('Location uploaded successfully.');</script>";
            echo "<script>window.location.href ='add-location-offer.php?alpid=$xpid'</script>";
        } else {
            echo "<script>alert('Falied to upload.');</script>";
        }
    }

    if (isset($_POST['addcost'])) {
        $xpid = $_GET['alpid'];
        $c_offer = $_POST['c_offer'];
        $c_value = $_POST['c_value'];

        // Insert location into offer 
        $insert = $dbh->query("INSERT into `cost_offer`(cost_offer_id, offer_id,c_offer,c_value) VALUES (NULL,16, '$c_offer',$c_value)");
        if ($insert) {
            echo "<script>alert('Cost uploaded successfully.');</script>";
            echo "<script>window.location.href ='add-location-offer.php?alpid=$xpid'</script>";
        } else {
            echo "<script>alert('$xpid $c_offer $c_value.');</script>";
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
        <?php include_once('includes/sidebar.php'); ?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include_once('includes/header.php'); ?>

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manage Locations for each offer</h1>

                    </div>
                    <?php
                    $sql = "SELECT * from `offers` where offer_id=$xpid";
                    ?>

                    <?php $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach ($results as $result1)
                    ?>
                    <h1>
                        <p><?php echo ($result1->offer_name); ?></p>
                    </h1>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Unit </th>
                                <th>Price/month </th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Price</th>
                                <th>Discount </th>
                                <th>Net Price </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $sql = "SELECT * from location_offers where offer_id=$xpid";
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
                                        <td><?php echo number_format($result->location_price); ?> JD's</td>
                                        <td><?php echo htmlentities($result2->start_date); ?> </td>
                                        <td><?php echo htmlentities($result2->end_date); ?></td>
                                        <td><?php echo number_format($result2->price); ?> JD's</td>
                                        <td><?php echo number_format($result2->discount); ?> JD's</td>
                                        <td><?php echo number_format($result2->net_price); ?> JD's</td>
                                        <td><a href="add-location-offer.php?rid=<?php echo htmlentities($result2->location_offer_id); ?>" style="color:red;" onClick="return confirm('Do you really want to delete');"><i class="fas fa-trash-alt text-danger"></i> </a></td>
                                    </tr>

                            <?php
                            $count  += $result2->net_price;
                             $cnt = $cnt + 1;
                                }
                            } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <form action="add-location-offer.php?alpid= <?php echo $xpid ?>" method="post" enctype="multipart/form-data">
                                Add Location to the offer
                                <select name="locationname" required class="form-control">
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
                                Start Date

                                <input type="date" name="startdate" class="form-control">
                                End Date
                                <input type="date" name="endate" class="form-control">
                                Price
                                <input type="number" name="price" class="form-control">
                                Discount
                                <input type="number" name="dis" class="form-control">
                                <br>

                                <input type="submit" value="upload" name="submit" class="btn-primary btn">
                            </form>
                        </div>
                    </div>
                    <br>
                    <h2> Offer Cost </h2>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>

                                <th>Cost </th>
                                <th>Value </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $sql = "SELECT * from cost_offer where offer_id=$xpid";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            
                            foreach ($results as $result2) { ?>

                                <tr>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($result2->c_offer); ?></td>
                                    <td><?php echo number_format($result2->c_value); ?> JD's</td>
                                    <?php
                                    $count += $result2->c_value;
                                    ?>
                                    <td><a href="add-location-offer.php?cid=<?php echo htmlentities($result2->cost_offer_id); ?>" style="color:red;" onClick="return confirm('Do you really want to delete');"><i class="fas fa-trash-alt text-danger"></i> </a></td>
                                </tr>

                            <?php $cnt = $cnt + 1;
                            } ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td > <b>Total</b></td>
                                <td><?php echo number_format($count);?> JD's</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <form action="add-location-offer.php?alpid= <?php echo $xpid ?>" method="post" enctype="multipart/form-data">
                                Add Cost to the offer
                                <br>
                                <br>
                                Cost name
                                <input type="text" name="c_offer" class="form-control">
                                Cost value
                                <input type="number" name="c_value" class="form-control">
                                <br>
                                <input type="submit" value="Add" name="addcost" class="btn-primary btn">
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