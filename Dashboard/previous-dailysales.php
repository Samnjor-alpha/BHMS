
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


    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>



    <!--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css">-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">
        function PrintDiv() {
            var disp_setting="toolbar=yes,location=no,";
            disp_setting+="directories=yes,menubar=yes,";
            disp_setting+="scrollbars=yes,width=1000, height=600, left=1000, top=25";
            var content_value = document.getElementById("divToPrint").innerHTML;
            var docprint=window.open("","",disp_setting);
            docprint.document.open();
            docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
            docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
            docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="">');
            docprint.document.write('<head><title>Daily-Monthly  Reports</title>');
            docprint.document.write('<link href="../dist/css/invoice.css" rel="stylesheet" />');
            docprint.document.write('<link href="../dist/css/styles.css" rel="stylesheet" />');


            docprint.document.write('<style type="text/css">body{ margin:0px;');
            docprint.document.write('font-family:verdana,Arial;');
            docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
            docprint.document.write('</style>');

            docprint.document.write('</head><body  style="width: 100%; position: center; font-size: 13px;" onLoad="print()">');
            docprint.document.write(content_value);

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
                <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8">
                        <form method="post" action="" >
                            <div class="row d-sm-flex align-items-center justify-content-between mb-auto">

                                <div class="col">
                                    <div class="form-group">
                                        <label for="dt1">Month:</label>
                                        <select id="dt1" class="form-control-sm" name="d1" size='1'>
                                            <?php
                                            for ($i = 0; $i < 12; $i++) {
                                                $time = strtotime(sprintf('%d months', $i));
                                                $label = date('F', $time);
                                                $value = date('n', $time);
                                                echo "<option value='$value'>$label</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>



                                <div class="col">
                                    <div class="form-group">
                                        <label for="dt1"></label>
                                    <button type="submit" name="sale_q" class="form-control btn btn-sm btn-primary shadow-sm">Get Report</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                </div>

                <?php


                if (isset($_POST['sale_q'])){?>

                    <div class="card">
                        <div class="card-body">
                    <div class="text-center"  id="divToPrint">
                            <?php
                    $dt1 = $_POST['d1'];


                    $date2 = new DateTime('Y');
                    $dt2=$date2->format('Y');


                    $sql_sale = "SELECT * FROM daily_sales WHERE MONTH(recorded_date)=$dt1 and year(recorded_date)=$dt2";
                    $result_sale = mysqli_query($conn, $sql_sale);
                    if (mysqli_num_rows($result_sale) <1) {
                        echo"<div class='alert  alert-warning alert-dismissible'>";
                        echo"<p>No sales report for that month</p>";
                        echo"</div>";
                    }else{


                        ?>

                                    <h4 class="text-center">
                                        <address class="text-monospace text-dark">

                                            Tom Omai Water Supplies<br>

                                            Machakos<br>
                                            Makutano,Kyumbi
                                        </address></h4>

                        <div class="row d-sm-flex align-items-center justify-content-between mb-auto">
                        <table class="table     table-responsive" >
                        <thead>
                        <tr>
                            <th> Date sold</th>
                            <th>Units Sold</th>
                            <th> Amount collected </th>
                            <th> Spent Expenditures </th>
                            <th>Final Amount</th>
                            <th> Expenditures </th>


                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        for ($i = 0; $row_sale = $result_sale->fetch_assoc(); $i++) {
                            ?>
                            <tr class="record">
                                <td><?php
                                    $dy=$row_sale['recorded_date'];
                                    $date2 = new DateTime("$dy");
                                    echo $dt2=$date2->format("d-M-Y");

                                    ?></td>

                                <td><?php echo $row_sale['units'] . ' '.'m<sup>3<sup></sup>'; ?></td>
                                <td><?php   $dsdsd = $row_sale['Amount'];
                                    echo formatMoney($dsdsd, true); ?></td>

                                <td><?php
                                    $dsdsd = $row_sale['Amount_Exp'];
                                    echo formatMoney($dsdsd, true);
                                    ?></td>
                                <td><?php
                                    $dsdsd = $row_sale['Final_Amount'];
                                    echo formatMoney($dsdsd, true);
                                    ?></td>
                                <td class="text-monospace"><?php echo $row_sale['Expenditures']; ?></td>
                            </tr>

                        </tbody>
                            <?php }?>
                        <thead>
                        <tr>
                        <th colspan="" style="border-top:1px solid #999999"> Total:</th>
                            <th colspan="1" style="border-top:1px solid #999999">
                                <?php


                                $dt1 = $_POST['d1'];
                                $date2 = new DateTime('Y');
                                $dt2=$date2->format('Y');
                                $sqlt = "SELECT sum(units) FROM daily_sales WHERE MONTH(recorded_date)=$dt1 and year(recorded_date)=$dt2";
                                $result_sal = mysqli_query($conn, $sqlt);
                                for ($i = 0; $rows = $result_sal->fetch_assoc(); $i++) {
                                    $dsdsd = $rows['sum(units)'];
                                    echo formatMoney($dsdsd, true).''.'m<sup>3</sup>';
                                }
                                ?>
                            </th>
                            <th colspan="1" style="border-top:1px solid #999999">
                                <?php


                                $dt1 = $_POST['d1'];


                    $date2 = new DateTime('Y');
                    $dt2=$date2->format('Y');
                                $sqlt = "SELECT sum(Amount) FROM daily_sales WHERE MONTH(recorded_date)=$dt1 and year(recorded_date)=$dt2";
                                $result_sal = mysqli_query($conn, $sqlt);
                                for ($i = 0; $rows = $result_sal->fetch_assoc(); $i++) {
                                    $dsdsd = $rows['sum(Amount)'];
                                    echo 'Ksh '.
                                        formatMoney($dsdsd, true);
                                }
                                ?>
                            </th>
                            <th colspan="0" style="border-top:1px solid #999999"></th>
                        <th colspan="1" style="border-top:1px solid #999999">
                            <?php


                            $dt1 = $_POST['d1'];


                    $date2 = new DateTime('Y');
                    $dt2=$date2->format('Y');
                            $sqlt = "SELECT sum(Amount_Exp) FROM daily_sales WHERE MONTH(recorded_date)=$dt1 and year(recorded_date)=$dt2";
                            $result_sal = mysqli_query($conn, $sqlt);
                            for ($i = 0; $rows = $result_sal->fetch_assoc(); $i++) {
                                $dsdsd = $rows['sum(Amount_Exp)'];
                                echo 'Ksh '.formatMoney($dsdsd, true);
                            }
                            ?>
                        </th>

                        <th colspan="" style="border-top:1px solid #999999">
                        <?php
                        $sdl = "SELECT sum(Final_Amount) FROM daily_sales WHERE MONTH(recorded_date)=$dt1 and year(recorded_date)=$dt2";
                        $result_al = mysqli_query($conn, $sdl);
                        for ($i = 0; $cxz = $result_al->fetch_assoc(); $i++) {
                            $zxc = $cxz['sum(Final_Amount)'];
                            echo 'Ksh '.formatMoney($zxc, true);
                        }

                    ?>

                    </th>
                </tr>
                    </thead>
                    </table>

                    </div>
                    </div>

                        <?php


                        echo'<div class="container-fluid">';

                        echo'<button type="submit" onclick="PrintDiv();" class="btn btn-sm btn-success"><i class="fas fa-print fa-sm text-white-50"></i> Print Report</button>';
                        echo'</div>';}}

                        ?>

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
