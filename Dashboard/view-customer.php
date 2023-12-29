
<?php
require  'session.php';
include  '../authentication/config.php';
$msg = "";
$msg_class = "";

$sup= $_GET['client_id'];
$sql = mysqli_query($conn, "SELECT * FROM monthly_clients WHERE mc_id='$sup'");
$s_row = $sql->fetch_assoc();

$c_id = $s_row['mc_id'];
$date2 = new DateTime('Y');
$dt2=$date2->format('Y');
$bills = mysqli_query($conn,"SELECT * FROM mcustomer_sales where client_id='$c_id'");
$sale_row = $bills->fetch_assoc();
$amountdue=$sale_row['amount_due'];
if(mysqli_num_rows($sql)<1){
    header('location:view-customers.php');
}

function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
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
    <title>View Customer</title>
    
    <link href="../dist/css/styles.css" rel="stylesheet" />

    <link href="../dist/css/viewcustomer.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        body{

            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 100 100'%3E%3Crect x='0' y='0' width='87' height='87' fill-opacity='0.04' fill='%23000000'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="sb-nav-fixed">
<?php  include 'topbar.php'?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php require 'sidebar.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h3 class="mt-4">Client reports</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active text-capitalize"><?php echo $s_row['fname'].' '.$s_row['lname'] ?>/ <?php echo $s_row['biz_name'] ?></li>
                </ol>
                <div class="container-fluid">
                    <?php
                    if (mysqli_num_rows($bills) <1) {?>
                        <div class="row justify-content-center">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>No Bills record found for this client</strong>
                            </div>
                        </div>
                    <?php }?>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="card">
                                <div class="card-header py-3 d-flex flex-row  text-center align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold ">Client Profile</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-left shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Actions</div>
                                            <?php if (mysqli_num_rows($bills) <1) {?>

                                            <?php }else{?>
                                                <a class="dropdown-item"  href="client-receipts.php?no=<?php echo $sale_row['client_id']?>" >Generate Bill Receipt</a>
                                            <?php }?>

                                            <?php


                                            if ($amountdue===''){?>

                                            <?php }if ($amountdue <200){ ?>

                                            <?php }else{?>
                                                <a class="dropdown-item">Generate amount due receipt</a>
                                            <?php }?>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-success" href="edit-client.php?client-id=<?php echo $s_row['mc_id'] ?>"><i class="fas fa-user-edit"></i> Edit Client</a>
                                            <a class="dropdown-item text-danger" href="delete-client.php?client-d=<?php echo $s_row['mc_id']?>"><i class="fas fa-user-minus"></i> Delete Client</a>

                                        </div>
                                    </div>
                                </div>

                                <div class="card-body profile-usertitle">
                                    <div class="align-items-center justify-content-center profile-userpic">
                                        <img src="../dist/assets/img/avatar.png" class="img-responsive" alt="avatar">
                                    </div>
                                    <div class="profile-usertitle-name text-capitalize">
                                        <?php echo $s_row['fname'].' '.$s_row['lname']; ?>
                                    </div>
                                    <div class="profile-usertitle-job">
                                        <?php echo $s_row['biz_name'] ?>
                                    </div>
                                </div>
                                <!-- END SIDEBAR USER TITLE -->
                                <!-- SIDEBAR BUTTONS -->


                                <div class="profile-usertitle">
                                    <div class="profile-usertitle-mobile">
                                        <?php echo '+'.$s_row['tel_phone'] ?>
                                    </div>
                                    <div class="profile-usertitle-email">
                                        <?php
                                        if ($s_row['email']==''){
                                            echo "Email:n/a";
                                        }else{
                                            echo $s_row['email']; } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>

                        <div class="col col-md-8">
                            <div class="card">
                                <div class="card-header py-3 d-flex flex-row  text-center align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold">All time records</h6>

                                </div>
                                <div class="profile-content">
                                    <div class="row">
                                        <div class="col">
                                            <div class="card bg-primary text-white mb-4">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">

                                                        <?php
                                                        $resultase = "SELECT sum(Amount) FROM mcustomer_sales where client_id='$c_id'";
                                                        $result_prine = mysqli_query($conn, $resultase);



                                                        ?>
                                                        <div class="small text-uppercase mb-2">Amount paid</div>


                                                    </div>
                                                    <div class="text-xs font-weight-normal"><?php

                                                        if (mysqli_num_rows($result_prine)>0) {
                                                            for($i=0; $rowass = $result_prine->fetch_assoc(); $i++){

                                                                $amount=$rowass['sum(Amount)'];
                                                                echo' Ksh.'.' '. formatMoney($amount,true);
                                                            }

                                                        }else{
                                                            $earn= 0.00;
                                                            echo' Ksh.'.' '. formatMoney($earn,true);
                                                        }


                                                        ?></div>



                                                </div>

                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card bg-success text-white mb-4">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">

                                                        <div class="small text-uppercase mb-2">units Consumed</div>
                                                        <?php
                                                        $resultasu = "SELECT sum(units) FROM mcustomer_sales where client_id='$c_id'";
                                                        $result_prinu = mysqli_query($conn, $resultasu);

                                                        for($i=0; $rowasu = $result_prinu->fetch_assoc(); $i++){

                                                            $units=$rowasu['sum(units)'];
//                                                            echo $units.''.'m<sup>3</sup>';

                                                        }


                                                        ?>


                                                        <div class="text-xs font-weight-normal  ">
                                                            <?php
                                                            if ($units=='') {


                                                                $units= 0.00;
                                                                echo $units.''.'m<sup>3</sup>';



                                                            }else{
                                                                echo $units.''.'m<sup>3</sup>';
                                                            }?>
                                                        </div>



                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <?php
                                        $resultas = "SELECT sum(amount_due) FROM mcustomer_sales where client_id='$c_id'";
                                        $result_prin = mysqli_query($conn, $resultas);

                                        for($i=0; $rowas = $result_prin->fetch_assoc(); $i++){

                                            $due=$rowas['sum(amount_due)'];

                                        }




                                        if ($due >200) {
                                            $bg = 'bg-danger';
                                            $DUE=$due;
                                        }else if (mysqli_num_rows($result_prin) <1) {
                                            $bg='bg-warning';
                                            $DUE='0.00';

                                        }else{
                                            $bg='bg-warning';
                                            $DUE='0.00';
                                        }

                                        ?>

                                        <div class="col">
                                            <div class="card <?php echo $bg  ?> text-white mb-4">

                                                <div class="card-body">

                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="small text-uppercase mb-2">Amount due</div>

                                                        </div>

                                                        <div class="text-xs font-weight-normal  ">
                                                            <?php echo 'ksh '.$DUE ?>
                                                        </div>



                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
       <?php  include '../public/footer.php'?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="../dist/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

</body>
</html>