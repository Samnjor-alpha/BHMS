
<?php
include '../authentication/config.php';
require  'session.php';
$drid=$_GET['recordno'];
$adm_id=$_SESSION['id'];
$date2 = new DateTime('Y');
$dt2=$date2->format('Y');
$value = date('n', $time);

$drecords="select *  from daily_sales where year(recorded_date)='$dt2'  and dr_id='$drid'";
$result_drecords=mysqli_query($conn,$drecords);
$s_drow = $result_drecords->fetch_assoc();
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
    <title>Manage daily records</title>
    <?php  include '../public/stylesheet.php'?>
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
                <h3 class="mt-4">Edit Record for date : <?
                    $dy=$s_drow['recorded_date'];
                    $date2 = new DateTime("$dy");
                    echo $dt2=$date2->format("d-M-Y"); ?></h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">This  daily Sale</li>
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
                    <div id="login-box" class="col-md-10">
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
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="small mb-1" for="dater">Date Recorded</label>
                                <input class="form-control" id="dater" data-date-format="dd/mm/yyyy" value="<?php echo $s_drow['recorded_date']; ?>" type="date" name="dater"  required/>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="units">Initial Reading</label>
                                        <input class="form-control"  value="<?php echo $s_drow['i_reading'] ?>" name="iR" id="units" type="number" step="0.01" min="0.0" placeholder="Initial Reading" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="units">Final Reading</label>
                                        <input class="form-control" name="fR" id="units" type="number" step="0.01" min="0.0" value="<?php echo $s_drow['f_reading'] ?>" placeholder="Final Reading" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">

                                        <label class="small mb-1" for="Amount">Amount Collected</label>

                                        <input class="form-control" id="Amount" min="10"value="<?php echo $s_drow['Amount'] ?>" onchange="updateDue()" name="iAmount" type="number" placeholder="Amount Collected" />


                                    </div>
                                </div>


                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="AmExp">Amount spend on Exp..</label>
                                        <input class="form-control" id="AmExp" value="<?php echo $s_drow['Amount_Exp'] ?>" type="number" onchange="updateDue()" name="AmExp" placeholder="Amount Spend on Expenditures" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                <label class="small mb-1" for="expenditures">Expenditures</label><br>


                                <input  class="form-control" name="tags" data-role="tagsinput" id="expenditures" value="<?php echo $s_drow['Expenditures'] ?>" placeholder="Add expenditures" type="text" required />
                            </div>



                            <div class="form-group">
                                <label class="small mb-1" for="finalAmount">Final Amount collected</label>
                                <input class="form-control" id="finalAmount" value="<?php echo $s_drow['Final_Amount'] ?>" type="number" name="fAmount" placeholder="Final Amount" required/>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-block btn-success" name="USR"  value="Update Record"  type="submit"  />
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </main>

        <?php  include '../public/footer.php'?>


        <?php include '../public/scripts.php'?>

</body>
</html>
