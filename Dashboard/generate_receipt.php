
<?php
include '../authentication/config.php';
require  'session.php';
include'query.php';
$cid=$_GET['cno'];
$dt1=$_GET['date1'];
$dt2=$_GET['date2'];
$sql = mysqli_query($conn, "SELECT * FROM monthly_clients WHERE mc_id='$cid'");
$s_row = $sql->fetch_assoc();


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
            docprint.document.write('font-family:verdana,Arial;');
            docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
            docprint.document.write('</style>');
            docprint.document.write('<style type="text/css">#disclaimer{ margin-bottom:0px;');
            docprint.document.write('</style>');
            docprint.document.write('</head><body style="width: 100%; font-size: 13px;" onLoad="print()">');
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
                <h3 class="mt-4">Generate Invoice</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">generate bill paid Invoice</li>
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



                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Monthly Invoice</h6>
                            </div>
                            <div class="card-body">
<?php

    $date = new DateTime($dt1);
    $d1=$date->format('Y-m-d');

    $date2 = new DateTime($dt2);
    $d2=$date2->format('Y-m-d');


    $sql_sale = "SELECT * FROM mcustomer_sales WHERE start_date='$d1' AND end_date='$d2' and client_id='$cid'";
   $result_sale = mysqli_query($conn, $sql_sale);
    $sqll_date = "SELECT * FROM mcustomer_sales WHERE start_date='$d1' AND end_date='$d2' and client_id='$cid'";
    $result_dates = mysqli_query($conn, $sqll_date);
    if (mysqli_num_rows($result_dates) <1) {
         header('Location:client-receipts.php');
    }else{?>
                                <div class="container-fluid" id="divToPrint">
                                    <div class="row">
                                        <div class="col">
                                            <div class="justify-content-center align-items-center">
<!--                                               <img src="../dist/assets/img/logo.png"/>-->
                                                <h2 class="text-center">Invoice</h2>



                                                <div class="col text-right">
                                                    <address class="text-monospace text-dark">
                                                        <strong>Contact:</strong><br>
                                                        Tomai Water Supplies<br>
                                                        +254723778932<br>
                                                        tomaiwaterservices@gmail.com<br>
                                                        Machakos<br>
                                                        Makutano,Kyumbi
                                                    </address>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col text-capitalize">
                                                    <address class="text-monospace">
                                                        <strong>Billed To:</strong><br>
                                                        <?php echo $s_row['fname'].' '.$s_row['lname'] ?><br>
                                                        <?php echo $s_row['biz_name'] ?><br>
                                                        Machakos<br>
                                                        Makutano, Kyumbi
                                                    </address>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <address class="text-capitalize">
                                                        <strong>Payment Method:</strong><br>
                                                        Mpesa,Cash<br>
                                                        <?php
                                                        if ($s_row['email']==''){
                                                            echo "Email:n/a";
                                                        }else{
                                                            echo $s_row['email']; }?>
                                                    </address>
                                                </div>
                                                <div class="col text-right">
                                                    <address class="text-monospace ">
                                                        <strong>Bill Charge Date:</strong><br>
                                                    <?php
                                                    $date = new DateTime($dt1);
                                                    $d1=$date->format('D,d-M-Y');

                                                    $date2 = new DateTime($dt2);
                                                    $d2=$date2->format('D,d-M-Y');


                                                    echo  '<p class="small">'.$d1.' : '.$d2.'</p>'; ?><br><br>
                                                    </address>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><strong>Bill Summary</strong></h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive" style="margin-bottom:50px" >
                                                        <table class="table  table-condensed"  style="border:1px black solid;">
                                                            <thead>
                                                            <tr><td class="alert-dark text-center text-uppercase"><strong>Previous Reading</strong></td>
                                                                <td class="alert-dark text-center text-uppercase"><strong>Current Reading</strong></td>
                                                                <td class="alert-dark text-center text-uppercase"><strong>Units Used</strong></td>
                                                                <td class="alert-dark text-center text-uppercase"><strong>Rate per unit</strong></td>
                                                                <td class="text-right alert-dark text-uppercase"><strong>Amount</strong></td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
        <?php
        for ($i = 0;
                    $cc_row = $result_sale->fetch_assoc();
                    $i++) {






        ?>

 <tr class="text-center">

     <td class="small"><?php echo $cc_row['i_reading']?></td>
     <td class="small"><?php echo $cc_row['f_reading']?></td>
            <td class="small"><?php echo $cc_row['units'].''.'m<sup>3</sup>'?></td>
            <td class="small"><?php    echo 'ksh. '.$cc_row['rate_per_unit'];?></td>

            <td class="small text-right" ><b><?php
                $amount= $cc_row['Amount'];
                    echo' Ksh.'.' '. formatMoney($amount,true);?></b>

            </td>


 </tr>
        <?}?>
<tr>
            <td colspan="5" class="thick-line"></td>
</tr>
        <tr>
            <td   class="no-line text-center" ><strong>Total</strong></td>
            <td id="total"  colspan="4" class="no-line  text-right">
                <?php



           $d_row = $result_dates->fetch_assoc();
               ;


               $date = new DateTime($d_row['start_date']);
               $sdt1 = $date->format('Y-m-d');

               $date2 = new DateTime($d_row['end_date']);
               $sdt2 = $date2->format('Y-m-d');


               //$date_row = $result_dates->fetch_assoc();


               $resultas = "SELECT sum(Amount) FROM mcustomer_sales where start_date ='$sdt1' and end_date='$sdt2' AND client_id='$cid'";
               $result_prin = mysqli_query($conn, $resultas);

               for ($i = 0; $rowas = $result_prin->fetch_assoc(); $i++) {
                   $fgfg = $rowas['sum(Amount)'];


                   echo ' Ksh.' . ' ' . formatMoney($fgfg, true);
               }


                ?>
            </td>
        </tr>


        </tr>



                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <footer id="disclaimer" class="small text-center">
                                        <?php $resultasd = "SELECT * FROM mcustomer_sales where start_date ='$sdt1' and end_date='$sdt2' AND client_id='$cid'";
                                        $result_pridn = mysqli_query($conn, $resultasd);
                                        $rowday = $result_pridn->fetch_assoc()?>


                                    </footer>
                                </div>




                                <div class="container-fluid">
        <div class="row">
<div class="col col-lg-6 col-sm-6">
                                <button type="submit"   onclick="PrintDiv();" class="btn btn-sm btn-success"><i class="fas fa-print fa-sm text-white-50"></i>Print Draft</button>
</div>
            <div class="col col-lg-6 col-sm-6">
                <a type="submit"  href="invoice.php?invoice=<?php echo $rowday['mr_id']  ?>&vip=<? echo $cid?>" class="btn btn-sm btn-success"><i class="fas fa-print fa-sm text-white-50"></i> Print Invoice</a>
            </div>        </div>
                                </div><?}?>
                            </div>
                        </div>
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
