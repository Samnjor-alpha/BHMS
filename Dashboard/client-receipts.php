<?php
require  'session.php';
include  '../authentication/config.php';
include 'query.php';

$cid=$_GET['no'];
$sql = mysqli_query($conn, "SELECT * FROM mcustomer_sales WHERE client_id='$cid' order by end_date DESC ");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    
    <link href="../dist/css/styles.css" rel="stylesheet" />
    <link href="../dist/css/invoice.css" rel="stylesheet" />


    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>



    <!--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css">-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">
        function PrintDiv() {
            var disp_setting="toolbar=yes,location=no,";
            disp_setting+="directories=yes,menubar=yes,";
            disp_setting+="scrollbars=yes,width=1000, height=600, left=1000, top=25";
            var content_vlue = document.getElementById("divToPrint").innerHTML;
            var docprint=window.open("","",disp_setting);
            docprint.document.open();
            docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
            docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
            docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
            docprint.document.write('<head><title>Receipt</title>');
            docprint.document.write('<link href="../dist/css/invoice.css" rel="stylesheet" />');
            docprint.document.write('<link href="../dist/css/styles.css" rel="stylesheet" />');
            docprint.document.write('<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />');
            docprint.document.write('<style type="text/css">body{ margin:0px;');
            docprint.document.write('font-family:verdana,Arial;color:#000;');
            docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
            docprint.document.write('a{color:#000;text-decoration:none;} </style>');
            docprint.document.write('</head><body onLoad="self.print()"><center>');
            docprint.document.write(content_vlue);
            docprint.document.write('</body></html>');
            docprint.document.close();
            docprint.focus();

        }
    </script>
    <style>
           body{

            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 100 100'%3E%3Crect x='0' y='0' width='87' height='87' fill-opacity='0.04' fill='%23000000'/%3E%3C/svg%3E");
        }
    </style>

</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="home.php">Tomai water supplies</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <form class="  form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

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
                <h3 class="mt-4"> Bills paid</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">generate bill paid receipt</li>
                </ol>
            </div>
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div id="login-box" class="col-md-8">
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
                        <div class="container">

                            <div id="accordion">
                                <?php $i=1;  while ($s_row = $sql->fetch_assoc()) {?>
                                <div class="card">
                                    <div class="card-header">
                                        <a class="text-primary" data-toggle="collapse" href="#collapse<?php echo $i;?>">
                                        <div class="row">
                                            <div class="col text-left">
                                            <?php
                                            $date = new DateTime($s_row['start_date']);
                                            echo $dt1=$date->format('D, d,M y');?></div>
                                            <p class=" col text-center">To</p>
                                            <div class="col text-right"><?php
                                                $date = new DateTime($s_row['end_date']);
                                                echo $dt1=$date->format('D, d,M y');?></div>
                                        </div>
                                        </a>
                                    </div>
                                    <div id="collapse<?php echo $i; ?>" class="collapse <?php if ($i==1) { echo 'show'; } ?>" data-parent="#accordion">
                                        <div class="card-body">
                                        <div class="row">

                                  <div class="col">
                        <p>Amount:<? echo 'ksh. '.formatMoney($s_row['Amount'],true);?></p>
                                        </div>
                                            <div class="col">
                                                <p>Units:<?echo  $s_row['units'].' '.'m<sup>3</sup>'?></p>
                                            </div>
                                            <div class="col">
                                                <a class="btn btn-success btn-sm" href="generate_receipt.php?cno=<?php echo $s_row['client_id']?>&date1=<?php echo $s_row['start_date']?>&date2=<?php echo $s_row['end_date'] ?>">Generate Receipt</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++;}?>


                            </div>
                        </div>


                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

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

