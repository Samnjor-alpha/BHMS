
<?php
include '../authentication/config.php';
require 'session.php';



$cid=$_GET['client-id'];

$client_details = "SELECT * FROM monthly_clients where mc_id='$cid'";

$result_client_details = mysqli_query($conn, $client_details);
$rowclient = $result_client_details->fetch_assoc();

$msg = "";
$msg_class = "";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Update Client</title>
    
<? include '../public/stylesheet.php'?>
</head>
<body class="sb-nav-fixed">
<? include 'topbar.php'?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="home.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Edit client</a>
                    <div class="sb-sidenav-menu-heading">Daily Sales</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
                    ><div class="sb-nav-link-icon"><i class="fas fa-calendar-day"></i></div>Daily sales
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                        ></a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="daily-sale-record.php">Record today's sale</a>
                            </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutss"
                       aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="far fa-file-excel"></i></div>Generate  Report
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                        ></a>
                    <div class="collapse" id="collapseLayoutss" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                         <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="previous-dailysales.php">View Previous sales</a>
                            <a class="nav-link" href="managedailysales.php">Manage daily sales</a>
                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Monthly Sales</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsm" aria-expanded="false" aria-controls="collapseLayouts"
                    ><div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>Monthly sales
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                        ></a>
                    <div class="collapse" id="collapseLayoutsm" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                          <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="monthly-sale.php">Record  sales</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="view-monthlysale.php">Generate  Report</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutssm"
                       aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Monthly Customers
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                        ></a>
                    <div class="collapse" id="collapseLayoutssm" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="addclient.php">Add new Client</a></nav>
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="view-customers.php?client-id=null"">View Customers</a></nav>
                    </div>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="text-left">Logged in as:</div>
                <p class="text-left"> <?php echo $_SESSION['bhmsuser']; ?></p>
                <div class="text-left ml-sm-auto   d-sm-inline-block d-md-none d-lg-none d-xl-none ml-sm-0 ml-lg-0 ml-xl-0 ml-md-0"><a class="btn btn-block btn-outline-danger" href="process-data/logout.php">Logout</a> </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h3 class="mt-4">Edit Client</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Update clients details</li>
                 </ol>
                <div class="row">
                    <div class="float-left">
                        <div class="btn-group">
                            <a href="javascript: history.go(-1)" class="btn  btn-lg"><i class="text-secondary fas fa-arrow-left"></i></a>

                        </div>
                    </div>
                    <!-- /.btn-group -->
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div id="login-box" class="col-md-6">
                        <div>
                            <?php if (!empty($msg)): ?>
                                <div class="alert <?php echo $msg_class ?> alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="units">First Name</label>
                                        <input class="form-control" name="fname" id="units" type="text" value="<?php echo $rowclient['fname']?>"  placeholder="First Name" required/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="units">Last Name</label>
                                        <input class="form-control" name="lname" id="units" type="text" value="<?php echo $rowclient['lname']?>" placeholder="Last Name" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="finalAmount">Business Name</label>
                                <input class="form-control" id="finalAmount" type="text" name="biz" value="<?php echo $rowclient['biz_name']?>" placeholder="Business Name" required/>
                            </div>
                            <div class="form-group">

                                <label class="small mb-1" for="rate">Rate per unit</label>

                                <!--                                <input class="form-control" id="phone" name="mobile"  placeholder="Telephone" />-->
                                <input type="number" class="form-control" min="100" name="rate"  maxlength="4" value="<?php echo $rowclient['rate_unit']?>" placeholder="rate per Unit" id="rate-input">


                            </div>
                            <div class="form-group">

                                <label class="small mb-1" for="Amount">Mobile No.</label>

                                <!--                                <input class="form-control" id="phone" name="mobile"  placeholder="Telephone" />-->
                                <input type="text" class="form-control" value="<?php echo $rowclient['tel_phone']?>" name="mobile"  maxlength="12" placeholder="254712345678" id="phone-input">


                            </div>
                            <div class="form-group">

                                <label class="small mb-1" for="Amount">Email (optional)</label>

                                <input class="form-control"  name="email" value="<?php echo $rowclient['email']?>" type="email" placeholder="email" />


                            </div>

                            <div class="form-group">
                                <input class="btn btn-block btn-success" name="update_client"  value="update Client" type="submit"  />
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </main>

        <? include '../public/footer.php'?>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../dist/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../dist/assets/demo/chart-area-demo.js"></script>
        <script src="../dist/assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../dist/assets/demo/datatables-demo.js"></script>

</body>
</html>
<?php
if (isset($_POST['update_client'])) {
    // for the database

    $fname = stripslashes($_POST['fname']);
    $lname = stripslashes($_POST['lname']);
    $email = stripslashes($_POST['email']);
    $tel = stripslashes($_POST['mobile']);
    $biz = stripslashes($_POST['biz']);
    $rate = stripslashes($_POST['rate']);




    $sql_e = "SELECT * FROM monthly_clients WHERE tel_phone='$tel'  and not mc_id='$cid'";

    $res_e = mysqli_query($conn, $sql_e);

    if (mysqli_num_rows($res_e) > 0) {
        echo "<script type='text/javascript'>
  					swal('', 'The phone no  is already associated with an customer!!!', 'error');
</script>";
    }


    if (empty($error)) {

        $sql = "UPDATE monthly_clients SET fname='$fname',lname='$lname',biz_name='$biz',tel_phone='$tel',email='$email',rate_unit='$rate' where mc_id='$cid'";
        if (mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>
  					swal('', 'Client updated successfully!!!', 'success');	
  					
</script>";
        } else {
            echo "<script type='text/javascript'>
  					swal('', 'There was an Error in the database!!!', 'error');
</script>";
        }
    }

}