
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
    <title>Generate Receipt</title>

    <? include '../public/stylesheet.php'?>

</head>
<body class="sb-nav-fixed">
<? include 'topbar.php'?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
    <?php require 'sidebar.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h3 class="mt-4">Generate Invoice</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">generate bill paid Invoice</li>
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

        <? include '../public/footer.php'?>

        <? include '../public/scripts.php'?>


</body>
</html>
