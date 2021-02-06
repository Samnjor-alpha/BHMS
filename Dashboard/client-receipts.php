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
    <title>Client Receipts</title>


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
                <h3 class="mt-4"> Bills paid</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">generate bill paid receipt</li>
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

        <? include '../public/footer.php'?>

        <? include '../public/scripts.php'?>


</body>
</html>

