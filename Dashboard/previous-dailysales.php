
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
    <title>Previous Daily Sales</title>
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
                <h3 class="mt-4">Previous sale Records</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Previous Sales</li>
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
                        echo"<p>No record reports for that month</p>";
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
                        <table class="table    table-bordered table-responsive" >
                        <thead>
                        <tr>
                            <th> Date sold</th>
                            <th>Units Sold</th>
                            <th> Amount collected </th>
                            <th> Spent Expenditures </th>
                            <th>Final Amount</th>
                            <th> Expenditures </th>
                            <th>Recorded by</th>


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
                                <td class="text-monospace"><?php
                                    $a_id=$row_sale['admin_id'];
                                    $rec_details = "SELECT * FROM admin_user where a_id='$a_id'";

                                    $result_record=mysqli_query($conn,$rec_details);
                                    if (mysqli_num_rows($result_record)>0){
                                    $row_rec = $result_record->fetch_assoc();
                                    echo $row_rec['username'];}else{
                                        echo "Unknown";
                                    }
                                    ?></td>
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
                            <th colspan="" style="border-top:1px solid #999999">
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

                        <th colspan="0" style="border-top:1px solid #999999">
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

                <? include '../public/footer.php'?>

        <? include '../public/scripts.php'?>



</body>
</html>
