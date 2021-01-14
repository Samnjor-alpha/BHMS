
<?php
include '../../authentication/config.php';
require '../session.php';



$cid=$_GET['client-id'];

$client_details = "SELECT * FROM monthly_clients where mc_id='$cid'";

$result_client_details = mysqli_query($conn, $client_details);
$rowclient = $result_client_details->fetch_assoc();

$msg = "";
$msg_class = "";

if (isset($_POST['update_client'])) {
    // for the database

    $fname = stripslashes($_POST['fname']);
    $lname = stripslashes($_POST['lname']);
    $email = stripslashes($_POST['email']);
    $tel = stripslashes($_POST['mobile']);
    $biz = stripslashes($_POST['biz']);
    $rate = stripslashes($_POST['rate']);




    $sql_e = "SELECT * FROM monthly_clients WHERE tel_phone='$tel'";

    $res_e = mysqli_query($conn, $sql_e);

    if (mysqli_num_rows($res_e) > 0) {
        $msg = "The mobile number  is already associated with an customer";
        $msg_class = "alert-danger";
    }


    if (empty($error)) {

        $sql = "UPDATE monthly_clients SET fname='$fname',lname='$lname',biz_name='$biz',tel_phone='$tel',email='$email',rate_unit='$rate' where mc_id='$cid'";
        if (mysqli_query($conn, $sql)) {
            $msg = "Updated successfully";
            $msg_class = "alert-success";
        } else {
            $msg = "There was an Error in the database";
            $msg_class = "alert-danger";
        }
    }

}
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
    
    <link href="../../dist/css/styles.css" rel="stylesheet" />


    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>



    <!--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css">-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    


    <style>
           body{

            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 100 100'%3E%3Crect x='0' y='0' width='87' height='87' fill-opacity='0.04' fill='%23000000'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="../home.php">Tomai water supplies</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <form class="  form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>

    <ul class="navbar-nav ml-sm-auto ml-md-auto ml-lg-auto ml-auto d-none d-sm-none d-md-inline-block d-lg-inline-block d-xl-inline-block ml-sm-0 ml-lg-0 ml-xl-0 ml-md-0 align-right">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="../home.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard</a>
                    <div class="sb-sidenav-menu-heading">Daily Sales</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
                    ><div class="sb-nav-link-icon"><i class="fas fa-calendar-day"></i></div>Daily sales
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                        ></a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="../daily-sale-record.php">Record today's sale</a>
                            </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutss"
                       aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="far fa-file-excel"></i></div>Generate  Report
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                        ></a>
                    <div class="collapse" id="collapseLayoutss" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                         <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="../previous-dailysales.php">View Previous sales</a>
                            <a class="nav-link" href="../managedailysales.php">Manage daily sales</a>
                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Monthly Sales</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsm" aria-expanded="false" aria-controls="collapseLayouts"
                    ><div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>Monthly sales
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                        ></a>
                    <div class="collapse" id="collapseLayoutsm" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                          <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="../monthly-sale.php">Record  sales</a>
                        </nav>
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="../view-monthlysale.php">Generate  Report</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutssm"
                       aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Monthly Customers
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                        ></a>
                    <div class="collapse" id="collapseLayoutssm" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="../addclient.php">Add new Client</a></nav>
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="../view-customers.php?client-id=null"">View Customers</a></nav>
                    </div>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="text-left">Logged in as:</div>
                <p class="text-left"> <?php echo $_SESSION['bhmsuser']; ?></p>
                <div class="text-left ml-sm-auto   d-sm-inline-block d-md-none d-lg-none d-xl-none ml-sm-0 ml-lg-0 ml-xl-0 ml-md-0"><a class="btn btn-block btn-outline-danger" href="logout.php">Logout</a> </div>
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

        <footer class="py-4 bg-transparent mt-auto">
            <div class="container-fluid">

                <div class="text-info text-center">&copy;Tomai water supplies</div>


            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../dist/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../../dist/assets/demo/chart-area-demo.js"></script>
        <script src="../../dist/assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../../dist/assets/demo/datatables-demo.js"></script>

</body>
</html>
