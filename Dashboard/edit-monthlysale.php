
<?php
include '../authentication/config.php';
require  'session.php';
$mrid=$_GET['mrecordno'];

$date2 = new DateTime('Y');
$dt2=$date2->format('Y');
$value = date('n', $time);

$mrecords="select *  from mcustomer_sales where year(end_date)='$dt2'  and mr_id='$mrid'";
$result_mrecords=mysqli_query($conn,$mrecords);
$s_mrow = $result_mrecords->fetch_assoc();
require 'query.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Monthly sales</title>
    
    <link href="../dist/css/styles.css" rel="stylesheet" />


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
    <script type="text/javascript">
        function updateDue() {

            var total = parseInt(document.getElementById("iunits").value);
            var val2 = parseInt(document.getElementById("funits").value);

            // to make sure that they are numbers
            if (!total) { total = 0; }
            if (!val2) { val2 = 0; }

            var ansD = document.getElementById("units");
            ansD.value = val2 - total;
            var rate= parseInt(document.getElementById("rate").value)

            if (!rate){rate=0}
            var amount =document.getElementById("Amount");
            amount.value= (val2-total) *rate;
        }
    </script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="home.php">Tomai water supplies</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <form class="form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>

    <ul class="navbar-nav ml-sm-auto ml-md-auto ml-lg-auto ml-auto d-none d-sm-none d-md-inline-block d-lg-inline-block d-xl-inline-block ml-sm-0 ml-lg-0 ml-xl-0 ml-md-0 align-right">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="process-data/logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php require 'navbar.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h3 class="mt-4">Update Monthly Record : <? echo date('D, M,Y'); ?></h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Update this  monthly Bill</li>
                </ol>
            </div>
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div id="login-box" class="col-md-10" >
                        <div>
                            <?php if (!empty($_SESSION['msg'] )): ?>
                                <div class="alert <?php echo $_SESSION['msg_class']  ?> alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?php echo $_SESSION['msg'] ; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <form action="" method="post" >

                            <div class="form-group">
                                <label class="small mb-1" for="client">Client</label>

                                <?php
                                $clid=$s_mrow['client_id'];
                                $mc_results = mysqli_query($conn, "SELECT * FROM monthly_clients where mc_id='$clid'");
                                $cs_row = $mc_results->fetch_assoc();
                                if (mysqli_num_rows($mc_results) <1){


                                    ?>
                                    <div class="form-group">
                                        <p> The client associated with the record cannot be found in the database</p>
                                    <a class="btn btn-info btn-block" href="addclient.php">Add Client</a>
                                    </div>
                                <?php }else{ ?>
                                <select id="client"  name="mc" class="form-control form-control-user">

                                        <option value="<?php echo $s_mrow['client_id'] ?>" ><?php  echo $cs_row['biz_name']?></option>


                                </select>
                                <??>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="units">Initial Reading</label>
                                        <input class="form-control" name="uiR" id="iunits" onchange="updateDue()" value="<?php echo $s_mrow['i_reading'] ?>" type="number" step="0.01" min="10.0" required placeholder="Initial Reading" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="units">Final Reading</label>
                                        <input class="form-control" name="ufR" onchange="updateDue()" id="funits" type="number" value="<?php echo $s_mrow['f_reading'] ?>" step="0.01" min="10.0" required placeholder="Final Reading" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="units">Units consumed</label>
                                        <input class="form-control" name="mnits" id="units" type="number" step="0.01" min="0.0" value="<?php echo $s_mrow['units'] ?>" placeholder="Enter units consumed" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="rate">Rate</label>
                                        <input class="form-control" min="100" onchange="updateDue()" value="<?php echo $s_mrow['rate_per_unit'] ?>" name=rate id="rate" type="number" placeholder="Rate per unit" />
                                    </div>
                                </div>
                            <div class="form-group">

                                <label class="small mb-1" for="Amount">Amount Collected</label>

                                <input class="form-control" id="Amount" min="300"  value="<?php echo $s_mrow['Amount'] ?>" name="camount" type="number" placeholder="Amount Collected" required/>


                            </div>
                            </div>




                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="dater">Date from:</label> <br>
                                        <span class="text text-danger small">**Initial units reading date recorded**</span>

                                        <input class="form-control" value="<?php echo $s_mrow['start_date'] ?>" id="dater"  type="date" name="sdater"  required/>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">

                                        <label class="small mb-1" for="dater">Date to:</label><br>
                                        <span class="text text-danger small">**Final units reading date recorded**</span>
                                        <input class="form-control" id="dater" value="<?php echo $s_mrow['end_date'] ?>" type="date" name="endater"  required/>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-block btn-success" name="uMR"  value="Update Record" type="submit"  />
                            </div>
                            <?php } ?>
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
        <script src="../dist/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>


</body>
</html>
