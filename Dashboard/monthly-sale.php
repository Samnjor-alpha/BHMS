
<?php
include '../authentication/config.php';

require  'session.php';
include 'query.php';
include 'process-data/csrf.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Monthly sales</title>
    <?php  include '../public/stylesheet.php'?>
</head>
<body class="sb-nav-fixed">
<?php  include 'topbar.php'?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php require 'sidebar.php';?>
    </div>
    <?php  include 'process-data/add-mrecord.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h3 class="mt-4">Add Monthly Record : <? echo date('D, M,Y'); ?></h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Record a monthly Bill</li>
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
                    <div id="login-box" class="col-md-10" >

                    <form action="" method="post" >
                            <input type="hidden" name="token" value="<?php echo $token; ?>" />
                            <div class="form-group">
                                <label class="small mb-1" for="client">Client</label>

                                <?php

                                if (mysqli_num_rows($mc_results) <1){


                                    ?>
                                    <a class="btn btn-info btn-block" href="addclient.php">Add Client</a>
                                <?php }else{ ?>
                                <select id="client"  name="mc" class="form-control form-control-user">
                                    <option selected disabled>--Choose client--</option>
                                    <?php while ($cs_row = $mc_results->fetch_assoc()) {?>
                                        <option value="<?php echo $cs_row['mc_id'] ?>" ><?php  echo $cs_row['biz_name']?></option>

                                    <?php }?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="iunits">Initial Reading</label>
                                        <input class="form-control" name="uiR" id="iunits" onchange="updateDue()" type="number" step="0.01"  required placeholder="Initial Reading" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="funits">Final Reading</label>
                                        <input class="form-control" name="ufR" onchange="updateDue()" id="funits" type="number" step="0.01" required placeholder="Final Reading" />
                                    </div>
                                </div>
                                <div class="col">

                                    <div class="form-group">
                                        <label class="small mb-1 .d-sm-none d-md-block" for="units">Units consumed</label>
                                        <input class="form-control"  name="mnits" id="units" type="number" step="0.01" min="0.0"  placeholder="Enter units consumed" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="rate">Rate</label>
                                        <input class="form-control" min="100" onchange="updateDue()" name=rate id="rate" type="number" placeholder="Rate per unit" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">

                                        <label class="small mb-1" for="Amount">Amount Collected</label>

                                        <input class="form-control" id="Amount" min="100"   name="camount" type="number" placeholder="Amount Collected" required/>


                                    </div>
                                </div>


                            </div>






                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="small mb-1" for="dater">Date from:</label> <br>
                                        <span class="text text-danger small">**Initial units reading date recorded**</span>

                                        <input class="form-control" id="dater"  type="date" name="sdater"  required/>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">

                                        <label class="small mb-1" for="dater">Date to:</label><br>
                                        <span class="text text-danger small">**Final units reading date recorded**</span>
                                        <input class="form-control" id="dater" value="<?php echo date('Y-m-d'); ?>" type="date" name="endater"  required/>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-block btn-success" name="SMR"  value="Submit Record" type="submit"  />
                            </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>

            </div>

        </main>

        <?php  include '../public/footer.php'?>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../dist/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>


</body>
</html>
