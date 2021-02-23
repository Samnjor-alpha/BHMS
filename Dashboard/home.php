<?php
include '../authentication/config.php';
require  'session.php';
include 'query.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Dashboard</title>
    <? include '../public/stylesheet.php' ?>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="home.php">Tomai water supplies</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>
    <form class="  form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>

    <ul class="navbar-nav ml-sm-auto ml-md-auto ml-lg-auto ml-auto d-none d-sm-none d-md-inline-block d-lg-inline-block d-xl-inline-block ml-sm-0 ml-lg-0 ml-xl-0 ml-md-0 align-right">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="process-data/logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php require 'sidebar.php'; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <h3 class="mt-4">Dashboard </h3>
                    </div>

                    <div class="mt-4 mb-2 text-right">
                        <form method="post" action="">
                            <select id="dt1" class="form-control-sm" name="d1">
                                <?php
                                for ($i = 0; $i < 12; $i++) {
                                    $time = strtotime(sprintf('%d months', $i));
                                    $label = date('F', $time);
                                    $value = date('n', $time);
                                    echo "<option value='$value'>$label</option>";
                                }
                                ?>
                            </select>
                            <input class="btn  btn-sm btn-outline-success" name="query" value="View Records"
                                   type="submit">
                        </form>
                    </div>


                </div>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">
                        <?php
                        // PHP program to convert number to month name
                        if (isset($_POST['query'])) {
// Declare month number and initialize it
                            $month_num = $_POST['d1'];

// Use mktime() and date() function to
// convert number to month name
                            $month_name = date("F", mktime(0, 0, 0, $month_num, 10));

// Display month name
                            echo $month_name . "\n daily sales records";
                        } else {
                            $time = strtotime(sprintf('%d months', $i));
                            $label = date('F', $time);
                            $value = date('n', $time);
                            echo $label . ' ' . ' daily sale records';
                        }
                        ?>
                    </li>
                </ol>
                <div class="row">
                    <div class="col">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-12">

                                        <div class="small text-uppercase mb-2">Earnings</div>
                                    </div>
                                </div>


                                <div class="text-justify font-weight-bold text-capitalize" id="earnings"><?php
                                    echo ' Ksh.' . '' . formatMoney($GrandEarn, true);

                                    ?></div>


                            </div>

                        </div>
                    </div>

                    <div class="col">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="small text-uppercase mb-2">Reports</div>

                                    </div>
                                </div>


                                <div class="text-lg-left font-weight-bold text-uppercase col-auto"><?php

                                    $treports = $data_dreports['total'];

                                    echo $treports; ?></div>

                                <!--                                    <div class="col-auto">-->
                                <!--                                        <i class="fas fa-fw fa-file-excel fa-2x text-gray-300"></i>-->
                                <!--                                    </div>-->

                            </div>
                            <!--                            <div class="card-footer d-flex align-items-center justify-content-between">-->
                            <!--                                <a class="small text-white stretched-link" href="view-monthlysale.php">Generate Reports</a>-->
                            <!--                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>-->
                            <!--                            </div>-->
                        </div>
                    </div>
                    <!--                    -->
                    <div class="col">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="small text-uppercase mb-2">Expenditures</div>

                                    </div>
                                </div>
                                <div class="text-justify font-weight-bold text-capitalize count"><?php
                                    echo ' Ksh.' . '' . formatMoney($GrandExp, true);

                                    ?></div>


                            </div>

                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">

                            Annual Monthly sales records
                        </li>
                    </ol>
                    <div class="row">
                        <div class="col">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-12">

                                            <div class="small text-uppercase mb-2">Total Earnings</div>
                                        </div>
                                    </div>


                                    <div class="text-justify font-weight-bold text-capitalize" id="earnings"><?php
                                        echo ' Ksh.' . '' . formatMoney($annual_earning, true);

                                        ?></div>


                                </div>

                            </div>
                        </div>
                        <div class="col">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-12">

                                            <div class="small text-uppercase mb-2">Total Clients</div>
                                        </div>
                                    </div>


                                    <div class="text-justify font-weight-bold text-uppercase"><?php echo $data2['total'] ?></div>

                                    <!--                                    <div class="col-auto">-->
                                    <!--                                        <i class="fas fa-users fa-2x text-gray-300"></i>-->
                                    <!--                                    </div>-->

                                </div>

                            </div>
                        </div>
                        <div class="col">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="small text-uppercase mb-2">Reports</div>

                                        </div>
                                    </div>


                                    <div class="text-lg-left font-weight-bold text-uppercase col-auto"><?php

                                        $treports = $data_reports['total'];

                                        echo $treports; ?></div>


                                </div>
                            </div>
        </main>
        <footer class="py-4 bg-transparent mt-auto">
            <div class="container-fluid">

                <div class="text-info text-center">&copy;Tomai water supplies</div>


            </div>
        </footer>
    </div>

    <? include '../public/scripts.php' ?>

</body>
</html>
