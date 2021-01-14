
<?php
require  '../authentication/config.php';
require  'session.php';
include 'query.php';
include 'process-data/add-client.php'
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
    
    <link href="../dist/css/styles.css" rel="stylesheet" />


    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>



    <!--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css">-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    


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
                <h3 class="mt-4">Add Client</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Add New client</li>
                </ol>
            </div>
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
