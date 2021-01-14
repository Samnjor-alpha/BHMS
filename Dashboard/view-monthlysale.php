
<?php
include '../authentication/config.php';
require  'session.php';

include 'query.php';
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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>



    <!--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css">-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">


        $(document).ready(function(){
            $('#filter').on('change', function() {
                if ( this.value === '1')
                    //.....................^.......
                {
                    $("#date").show();
                    $("#sup").hide();
                    $("#sup1").hide();


                }
                else if (this.value==='2')
                {
                    $("#sup").show();
                    $("#date").hide();
                    $("#sup1").hide();
                }else if (this.value==='3'){
                    $("#sup1").show();
                    $("#date").hide();
                    $("#sup").hide();
                }
            });
        });


    </script>
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
            docprint.document.write('<head><title>Monthly  Reports</title>');
            docprint.document.write('<link href="../dist/css/invoice.css" rel="stylesheet" />');
            docprint.document.write('<link href="../dist/css/styles.css" rel="stylesheet" />');

            docprint.document.write('<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />');
            docprint.document.write('<style type="text/css">body{ margin:0px;');
            docprint.document.write('font-family:verdana,Arial;');
            docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
            docprint.document.write('</style>');
            docprint.document.write('<style type="text/css">#dontprint{display:none;}');

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
                <h3 class="mt-4">Previous sale Records</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Previous Sales</li>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="filter">Filter By:</label>
                                    <select id='filter' class="form-control form-control-user">
                                        <option selected disabled>Choose filter </option>
                                        <option value="1">Date</option>
                                        <option value="2">Client</option>
                                        <option value="3">Client & Date</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style='display:none;' id='date'>

                            <form method="post" action="" >
                                <div class="row d-sm-flex align-items-center justify-content-between mb-auto">

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="dt1">From:</label>
                                            <input type="date" id="dt1" name="d1" class="form-control form-control-user" required>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="dt2">To:</label>
                                            <input type="date" id="dt2" name="d2" class="form-control form-control-user" value="<?php echo date('Y-m-d'); ?>" >
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <button type="submit" name="g_d" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</button>

                                    </div>
                                </div>
                            </form>
                            <br/>
                        </div>
                        <div style='display:none;' id='sup1'>
                            <div class="row">
                                <div class="col">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <?php 
                                            $mc_results = mysqli_query($conn, "SELECT * FROM monthly_clients");
                                            ?>
                                            <label for="biz">Client</label>
                                            <select  id="biz" name="biz" class="form-control form-control-user" required>
                                                <option class="disabled">Choose client</option>
                                                <?php while ($s_row = $mc_results->fetch_assoc()) {?>
                                                    <option value="<?php echo $s_row['mc_id'] ?>"><?php  echo $s_row['biz_name']?></option>
                                                <?php }?>
                                            </select>

                                        </div>
                                        <div class="row d-sm-flex align-items-center justify-content-between mb-auto">

                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="dt1">From:</label>
                                                    <input type="date" id="dt1" name="md1" class="form-control form-control-user" required>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="dt2">To:</label>
                                                    <input type="date" id="dt2" name="md2" class="form-control form-control-user" value="<?php echo date('Y-m-d'); ?>" >
                                                </div>
                                            </div>


                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block btn-info" name="g_r">Generate report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div style='display:none;' id='sup'>
                            <div class="row">
                                <div class="col">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <?php 
                                            $mc_results = mysqli_query($conn, "SELECT * FROM monthly_clients");
                                            ?>
                                            <label for="biz">Client</label>
                                            <select  id="biz" name="biz" class="form-control form-control-user" required>
                                                <option class="disabled">Choose client</option>
                                                <?php while ($s_row = $mc_results->fetch_assoc()) {?>
                                                    <option value="<?php echo $s_row['mc_id'] ?>"><?php  echo $s_row['biz_name']?></option>
                                                <?php }?>
                                            </select>

                                        </div>
                                        <div class="row d-sm-flex align-items-center justify-content-between mb-auto">




                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block btn-info" name="gc_r">Generate report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Monthly sales</h6>
                            </div>
                            <div class="card-body" id="divToPrint">
                                <?php                                        if (isset($_POST['g_d'])){

                                $date = new DateTime($_POST['d1']);
                                $dt1=$date->format('Y-m-d');

                                $date2 = new DateTime($_POST['d2']);
                                $dt2=$date2->format('Y-m-d');


                                $sql_sale = "SELECT * FROM mcustomer_sales WHERE start_date  AND end_date between '$dt1' and '$dt2' ORDER by mr_id DESC ";
                                $result_sale = mysqli_query($conn, $sql_sale);
                                if (mysqli_num_rows($result_sale) <1) {
                                    echo"<div class='alert  alert-warning alert-dismissible'>";
                                    echo"<p>No record(s) found in that range</p>";
                                    echo"</div>";
                                }else{

                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <h4 class="text-center">
                                                <address class="text-monospace text-dark">

                                                    Tom Omai Water Supplies<br>

                                                    Machakos<br>
                                                    Makutano,Kyumbi
                                                </address></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class=" table table-responsive">
                                            <table class="table  table-bordered">
                                                <thead>

                                                <tr>
                                                    <th>Name</th>
                                                    <th>Units</th>
                                                    <th>Rate(ksh)</th>
                                                    <th>Amount Paid</th>
                                                    <th>Amount Expected</th>
                                                    <th>Amount due</th>
                                                    <th>Date from:</th>
                                                    <th>Date to:</th>

                                                </tr>
                                                </thead>



                                                <tbody>
                                                <?php  for ($i = 0;
                                                            $c_row = $result_sale->fetch_assoc();
                                                            $i++) { ?>
                                                    <tr>
                                                        <td class="small"><?php echo $c_row['client_name'];?></td>


                                                        <td class="small"><?php echo $c_row['units']?></td>
                                                        <td class="small"><?php    echo $c_row['rate_per_unit'];?></td>

                                                        <td class="small"><?php
                                                            $amount= $c_row['Amount'];
                                                            echo' Ksh.'.' '. formatMoney($amount,true);?>

                                                        </td>
                                                        <td class="small"><?php

                                                            $amount=$c_row['Expected_amount'];

                                                            echo' Ksh.'.' '. formatMoney($amount,true);
                                                            ?></td>
                                                        <td class="small"><?php
                                                            $amount= $c_row['amount_due'];
                                                            echo' Ksh.'.' '. formatMoney($amount,true);?></td>
                                                        <td class="small"><?php  $dater = new DateTime($c_row['start_date']);

                                                            $fdate=$dater->format('d-M-y');

                                                            echo $fdate;
                                                            ?></td>
                                                        <td class="small"><?php


                                                            $dater = new DateTime($c_row['end_date']);

                                                            $fdate=$dater->format('d-M-y');

                                                            echo $fdate;


                                                            ?></td>
                                                    </tr>

                                                <?php }?>

                                                <tr><td colspan="1">Total units:</td>
                                                    <td class="small"><?php    $resultass = "SELECT sum(units) FROM mcustomer_sales where start_date  AND end_date between '$dt1' and '$dt2'";
                                                        $result_prins = mysqli_query($conn, $resultass);

                                                        for($i=0; $rowass = $result_prins->fetch_assoc(); $i++){

                                                            echo $rowass['sum(units)'].''.'m<sup>3</sup>';
                                                        }?></td>


                                                </tr>
                                                <tr><td colspan="3">Total amount:</td>
                                                    <td class="small"><?php
                                                        $resultas = "SELECT sum(Amount) FROM mcustomer_sales where start_date  AND end_date between '$dt1' and '$dt2'";
                                                        $result_prin = mysqli_query($conn, $resultas);

                                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){

                                                            $amount=$rowas['sum(Amount)'];
                                                            echo' Ksh.'.' '. formatMoney($amount,true);
                                                        }

                                                        ?></td>
                                                    <td class="small"><?php
                                                        $resultas = "SELECT sum(Expected_amount) FROM mcustomer_sales where start_date  AND end_date between '$dt1' and '$dt2'";
                                                        $result_prin = mysqli_query($conn, $resultas);

                                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){

                                                            $amount=$rowas['sum(Expected_amount)'];
                                                            echo' Ksh.'.' '. formatMoney($amount,true);
                                                        }

                                                        ?></td>
                                                    <td class="small"><?php
                                                        $resultas = "SELECT sum(amount_due) FROM mcustomer_sales where start_date  AND end_date between '$dt1' and '$dt2'";
                                                        $result_prin = mysqli_query($conn, $resultas);

                                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){

                                                            $amount=$rowas['sum(amount_due)'];
                                                            echo' Ksh.'.' '. formatMoney($amount,true);
                                                        }

                                                        ?></td>

                                                </tr>
                                                </tbody>
                                            </table>
                                            <?php


                                            echo'<div class="container-fluid" id="dontprint">';

                                            echo'<button type="submit" onclick="PrintDiv();" class="btn btn-sm btn-success"><i class="fas fa-print fa-sm text-white-50"></i> Print Report</button>';
                                            echo'</div>';}}

                                            ?>
                                            <?php                                        if (isset($_POST['g_r'])){

                                                $sup=$_POST['biz'];
                                                $date = new DateTime($_POST['md1']);
                                                $dt1=$date->format('Y-m-d');

                                                $date2 = new DateTime($_POST['md2']);
                                                $dt2=$date2->format('Y-m-d');

                                                $sql_sale = "SELECT * FROM mcustomer_sales WHERE  start_date and end_date between '$dt1' and '$dt2' AND client_id='$sup'";
                                                $result_sale = mysqli_query($conn, $sql_sale);
                                                if (mysqli_num_rows($result_sale) <1) {
                                                    echo"<div class='alert  alert-warning alert-dismissible'>";
                                                    echo"<p>No sales found in that date range</p>";

                                                    echo"</div>";
                                                }else{

                                                    ?>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">
                                                                <h4 class="text-center">
                                                                    <address class="text-monospace text-dark">

                                                                        Tom Omai Water Supplies<br>

                                                                        Machakos<br>
                                                                        Makutano,Kyumbi
                                                                    </address></h4>
                                                        </div>
                                                        <div class="panel-body">
                                                            <table class="table  table-bordered">

                                                                <thead>

                                                                <tr>
                                                                    <th>Name</th>
                                                    <th>Units</th>
                                                    <th>Rate(ksh)</th>
                                                    <th>Amount Paid</th>
                                                    <th>Amount Expected</th>
                                                    <th>Amount due</th>
                                                    <th>Date from:</th>
                                                    <th>Date to:</th>

                                                                </tr>
                                                                </thead>



                                                                <tbody>
                                                                <?php  for ($i = 0;
                                                                            $c_row = $result_sale->fetch_assoc();
                                                                            $i++) { ?>
                                                                    <tr>
                                                                        <td class="small"><?php echo $c_row['client_name'];?></td>


                                                                        <td class="small"><?php echo $c_row['units']?></td>
                                                                        <td class="small"><?php    echo $c_row['rate_per_unit'];?></td>

                                                                        <td class="small"><?php  echo $c_row['Amount']?></td>
                                                                        <td class="small"><?php  echo $c_row['Expected_amount']?></td>
                                                                        <td class="small"><?php  echo $c_row['amount_due']?></td>
                                                                        <td class="small"><?php

                                                                            echo $c_row['start_date'];
                                                                            ?></td>
                                                                        <td class="small"><?php
                                                                            echo $c_row['end_date'];                                         ?></td>
                                                                    </tr>

                                                                <?php }?>

                                                                <tr><td colspan="1">Total units:</td>
                                                                    <td class="small"><?php    $resultass = "SELECT sum(units) FROM mcustomer_sales where start_date and end_date between '$dt1' and '$dt2' AND client_id='$sup'";
                                                                        $result_prins = mysqli_query($conn, $resultass);

                                                                        for($i=0; $rowass = $result_prins->fetch_assoc(); $i++){
                                                                            echo $rowass['sum(units)'].''.'m<sup>3</sup>';

                                                                        }?></td>


                                                                </tr>
                                                                <tr><td colspan="3">Total amount:</td>
                                                                    <td class="small"><?php
                                                                        $resultas = "SELECT sum(Amount) FROM mcustomer_sales where start_date and end_date between '$dt1' and '$dt2' AND client_id='$sup'";
                                                                        $result_prin = mysqli_query($conn, $resultas);

                                                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){
                                                                            $fgfg=$rowas['sum(Amount)'];
                                                                            echo' Ksh.'.' '. formatMoney($fgfg, true);
                                                                        }

                                                                        ?></td>
                                                                    <td class="small"><?php
                                                                        $resultas = "SELECT sum(Expected_amount) FROM mcustomer_sales where start_date and end_date between '$dt1' and '$dt2' AND client_id='$sup'";
                                                                        $result_prin = mysqli_query($conn, $resultas);

                                                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){
                                                                            $fgfg=$rowas['sum(Expected_amount)'];
                                                                            echo' Ksh.'.' '. formatMoney($fgfg, true);
                                                                        }

                                                                        ?></td>
                                                                    <td class="small"><?php
                                                                        $resultas = "SELECT sum(amount_due) FROM mcustomer_sales where start_date and end_date between '$dt1' and '$dt2' AND client_id='$sup'";
                                                                        $result_prin = mysqli_query($conn, $resultas);

                                                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){
                                                                            $fgfg=$rowas['sum(amount_due)'];
                                                                            echo' Ksh.'.' '. formatMoney($fgfg, true);
                                                                        }

                                                                        ?></td>

                                                                <tr><td colspan="7">Total days:</td>
                                                                    <td class="small"><?php    $resultass = "SELECT sum(days_unit_spent) FROM mcustomer_sales where start_date and end_date between '$dt1' and '$dt2' AND client_id='$sup'";
                                                                        $result_prins = mysqli_query($conn, $resultass);

                                                                        for($i=0; $rowass = $result_prins->fetch_assoc(); $i++){
                                                                            echo $rowass['sum(days_unit_spent)'];

                                                                        }?></td>


                                                                </tr>


                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <?php


                                                    echo'<div class="container-fluid" id="dontprint">';

                                                    echo'<button type="submit" onclick="PrintDiv();" class="btn btn-sm btn-success"><i class="fas fa-print fa-sm text-white-50"></i> Print Report</button>';
                                                    echo'</div>';}}

                                            ?>
                                            <?php                                        if (isset($_POST['gc_r'])){

                                                $sup=$_POST['biz'];


                                                $sql_sale = "SELECT * FROM mcustomer_sales WHERE   client_id='$sup'";
                                                $result_sale = mysqli_query($conn, $sql_sale);
                                                if (mysqli_num_rows($result_sale) <1) {
                                                    echo"<div class='alert  alert-warning alert-dismissible'>";
                                                    echo"<p>No record sales  found for that client</p>";
                                                    echo"</div>";
                                                }else{

                                                    ?>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">
                                                                <h4 class="text-center">
                                                                    <address class="text-monospace text-dark">

                                                                        Tom Omai Water Supplies<br>

                                                                        Machakos<br>
                                                                        Makutano,Kyumbi
                                                                    </address></h4>
                                                        </div>
                                                        <div class="panel-body">
                                                            <table class="table  table-bordered">
                                                                <thead>

                                                                <tr>
                                                                    <th>Name</th>
                                                    <th>Units</th>
                                                    <th>Rate(ksh)</th>
                                                    <th>Amount Paid</th>
                                                    <th>Amount Expected</th>
                                                    <th>Amount due</th>
                                                    <th>Date from:</th>
                                                    <th>Date to:</th>

                                                                </tr>
                                                                </thead>



                                                                <tbody>
                                                                <?php  for ($i = 0;
                                                                            $c_row = $result_sale->fetch_assoc();
                                                                            $i++) { ?>
                                                                    <tr>
                                                                        <td class="small"><?php echo $c_row['client_name'];?></td>


                                                                        <td class="small"><?php echo $c_row['units']?></td>
                                                                        <td class="small"><?php    echo $c_row['rate_per_unit'];?></td>

                                                                        <td class="small"><?php  echo $c_row['Amount']?></td>
                                                                        <td class="small"><?php  echo $c_row['Expected_amount']?></td>
                                                                        <td class="small"><?php  echo $c_row['amount_due']?></td>
                                                                        <td class="small"><?php

                                                                            echo $c_row['start_date'];
                                                                            ?></td>
                                                                        <td class="small"><?php
                                                                            echo $c_row['end_date'];                                         ?></td>
                                                                    </tr>

                                                                <?php }?>

                                                                <tr><td colspan="1">Total units:</td>
                                                                    <td class="small"><?php    $resultass = "SELECT sum(units) FROM mcustomer_sales where client_id='$sup'";
                                                                        $result_prins = mysqli_query($conn, $resultass);

                                                                        for($i=0; $rowass = $result_prins->fetch_assoc(); $i++){
                                                                            echo $rowass['sum(units)'].''.'m<sup>3</sup>';

                                                                        }?></td>


                                                                </tr>
                                                                <tr><td colspan="3">Total amount:</td>
                                                                    <td class="small"><?php
                                                                        $resultas = "SELECT sum(Amount) FROM mcustomer_sales where  client_id='$sup'";
                                                                        $result_prin = mysqli_query($conn, $resultas);

                                                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){
                                                                            $fgfg=$rowas['sum(Amount)'];
                                                                            echo' Ksh.'.' '. formatMoney($fgfg, true);
                                                                        }

                                                                        ?></td>
                                                                    <td class="small"><?php
                                                                        $resultas = "SELECT sum(Expected_amount) FROM mcustomer_sales where client_id='$sup'";
                                                                        $result_prin = mysqli_query($conn, $resultas);

                                                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){
                                                                            $fgfg=$rowas['sum(Expected_amount)'];
                                                                            echo' Ksh.'.' '. formatMoney($fgfg, true);
                                                                        }

                                                                        ?></td>
                                                                    <td class="small"><?php
                                                                        $resultas = "SELECT sum(amount_due) FROM mcustomer_sales where  client_id='$sup'";
                                                                        $result_prin = mysqli_query($conn, $resultas);

                                                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){
                                                                            $fgfg=$rowas['sum(amount_due)'];
                                                                            echo' Ksh.'.' '. formatMoney($fgfg, true);
                                                                        }

                                                                        ?></td>

                                                                <tr><td colspan="7">Total days:</td>
                                                                    <td class="small"><?php    $resultass = "SELECT sum(days_unit_spent) FROM mcustomer_sales where  client_id='$sup'";
                                                                        $result_prins = mysqli_query($conn, $resultass);

                                                                        for($i=0; $rowass = $result_prins->fetch_assoc(); $i++){
                                                                            echo $rowass['sum(days_unit_spent)'];

                                                                        }?></td>


                                                                </tr>


                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <?php


                                                    echo'<div class="container-fluid" id="dontprint">';

                                                    echo'<button type="submit" onclick="PrintDiv();" class="btn btn-sm btn-success"><i class="fas fa-print fa-sm text-white-50"></i> Print Report</button>';
                                                    echo'</div>';}}

                                            ?>
                                        </div>
                                    </div>
                                </div>


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