
<?php
require  '../authentication/config.php';
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
    <title>Add Customer</title>
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
                <h3 class="mt-4">Add Client</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Add New client</li>
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
            <?php  include 'process-data/add-client.php' ?>
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div id="login-box" class="col">
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
                            <div class="row">
                                <div class="col-lg col-md">
                            <div class="form-group">
                                <label class="small mb-1" for="units">First Name</label>
                                <input class="form-control" name="fname" id="units" type="text"  placeholder="First Name" required/>
                            </div>
                                </div>
                                <div class="col col-lg col-md col-sm-4">
                            <div class="form-group">
                                <label class="small mb-1" for="units">Last Name</label>
                                <input class="form-control" name="lname" id="units" type="text"  placeholder="Last Name" required />
                            </div>
                                </div>
                            <div class="col">
                            <div class="form-group">
                                <label class="small mb-1" for="finalAmount">Business Name</label>
                                <input class="form-control" id="finalAmount" type="text" name="biz" placeholder="Business Name" required/>
                            </div>
                            </div>
                            </div>

                            <div class="form-group">

                                <label class="small mb-1" for="rate">Rate per unit</label>

                                <!--                                <input class="form-control" id="phone" name="mobile"  placeholder="Telephone" />-->
                                <input type="number" class="form-control" min="100" name="rate"  maxlength="4" placeholder="rate per Unit" id="rate-input" required>


                            </div>
                            <div class="row">
                                <div class="col">
                            <div class="form-group">

                                <label class="small mb-1" for="Amount">Mobile No.</label>

<!--                                <input class="form-control" id="phone" name="mobile"  placeholder="Telephone" />-->
                                <input type="text" class="form-control" name="mobile"  maxlength="12" placeholder="254712345678" id="phone-input" required>


                            </div>
                                </div>
                                <div class="col">
                            <div class="form-group">

                                <label class="small mb-1" for="Amount">Email (optional)</label>

                                <input class="form-control"  name="email" type="email" placeholder="email" />


                            </div>
                                </div>
                            </div>

                                <div class="form-group">
                                    <input class="btn btn-block btn-success" name="addclient"  value="Add Client" type="submit"  />
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
