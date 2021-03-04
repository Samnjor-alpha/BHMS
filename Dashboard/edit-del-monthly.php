
<?php
include '../authentication/config.php';
require  'session.php';
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
    <title>Manage monthly sales</title>

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
                <h3 class="mt-4">Manage Sales</h3>
<!--                //<div class="mt-4 mb-2 text-center">-->
<!--                    <form method="post" action="">-->
<!--                        <select id="dt1" name="edr1">-->
<!--                            --><?php
//                            for ($i = 0; $i < 12; $i++) {
//                                $time = strtotime(sprintf('%d months', $i));
//                                $label = date('F', $time);
//                                $value = date('n', $time);
//                                echo "<option value='$value'>$label</option>";
//                            }
//                            ?>
<!--                        </select>-->
<!--                        <input class="btn btn-secondary btn-sm" name="editr" value="View sales" type="submit">-->
<!--                    </form></div>-->
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Manage <? $date2 = new DateTime('Y');
                       echo  $dt2=$date2->format('Y'); ?> Monthly Records</li>
                </ol>
                <div class="row">
                    <div class="float-left">
                        <div class="btn-group">
                            <a href="javascript: history.go(-1)" class="btn  btn-lg"><i class="text-secondary fas fa-arrow-left"></i></a>

                        </div>
                    </div>
                    <!-- /.btn-group -->
                </div>

            <div class="container">
                <div  class="row justify-content-center">
                    <div id="login-column" class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
                        <div id="login-box" class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
                            <div>
                                <?php if (!empty($_SESSION['msg'])): ?>
                                    <div class="alert <?php echo $_SESSION['msg_class'] ?> alert-dismissible fade show col justify-content-center align-items-center text-center" id="login-box" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <?php echo $_SESSION['msg']; ?>
                                    </div>
                                <?php endif; ?>
                                <?php
                                unset($_SESSION['msg']);
                                unset($_SESSION['msg_class'])
                                ?>
                            </div>









                            <div class="card">
                                <div class="card-body">
                                    <div  id="divToPrint">

                                        <?php if (mysqli_num_rows($result_mrecords) <1){?>
                                            <div class="row justify-content-center">
                                                <div class="">

                                                    <strong>No Records for this year</strong>
                                                </div>
                                            </div>
                                        <?php }else {?>


                                        <table class="table  table-responsive" >
                                            <thead class="small justify-content-center">
                                            <tr>
                                                <th>Start Date Recorded </th>
                                                <th>End Date Recorded </th>
                                                <th> Client Name</th>
                                                <th>Initial Reading</th>
                                                <th>Final Reading</th>
                                                <th>Units Consumed</th>
                                               <th> Amount collected </th>
                                               <th>Action</th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            for ($i = 0; $row_msale = $result_mrecords->fetch_assoc(); $i++) {
                                            ?>
                                            <tr class="small" >
                                                <td class="">
                                                    <?php
                                                    $dy=$row_msale['start_date'];
                                                    $date2 = new DateTime("$dy");
                                                    echo $dt2=$date2->format("D,d-M-Y");

                                                    ?></td>
                                                <td class="">
                                                    <?php
                                                    $dy=$row_msale['end_date'];
                                                    $date2 = new DateTime("$dy");
                                                    echo $dt2=$date2->format("D,d-M-Y");

                                                    ?></td>
                                                <td><?php
                                                    $client=$row_msale['client_id'];
                                                    $mc_results = mysqli_query($conn, "SELECT * FROM monthly_clients where mc_id='$client'");
                                                    $cs_row = $mc_results->fetch_assoc();

                                                    echo $cs_row['biz_name']
                                                    ?></td>
                                                <td><?php echo $row_msale['i_reading'] ; ?></td>
                                                <td><?php echo $row_msale['f_reading'] ?></td>
                                                <td><?php   $dsdsd = $row_msale['units'];
                                                    echo formatMoney($dsdsd, true). ' '.'m<sup>3<sup></sup>';?></td>

                                                <td><?php
                                                    $dsdsd = $row_msale['Amount'];
                                                    echo 'ksh. '.formatMoney($dsdsd, true);
                                                    ?></td>

                                                <td><a href="edit-monthlysale.php?mrecordno=<?php echo$row_msale['mr_id'];?>" class="text-success">Edit</a>|<a  class="text-danger" onclick="return confirm('Do you want to delete');" href="process-data/delete-msale.php?delmrecno=<?php echo $row_msale['mr_id']?>">Delete</a></td>
                                            </tr>

                                            </tbody>
                                            <?php }}?>

                                        </table>

                                    </div>



                                </div>
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
