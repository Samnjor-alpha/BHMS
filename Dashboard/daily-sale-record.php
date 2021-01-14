
<?php
include '../authentication/config.php';
require  'session.php';
include 'process-data/csrf.php';
include 'query.php';
include 'process-data/add-drecord.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Daily sale records</title>
    
    <link href="../dist/css/styles.css" rel="stylesheet" />


    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>



<!--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css">-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<style>
    /* bootstrap-tagsinput.css file - add in local */

    .bootstrap-tagsinput {
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        display: inline-block;
        padding: 4px 6px;
        color: #555;
        vertical-align: middle;
        border-radius: 4px;
        max-width: 100%;
        line-height: 22px;
        cursor: text;
    }
    .bootstrap-tagsinput input {
        border: none;
        box-shadow: none;
        outline: none;
        background-color: transparent;
        padding: 0 6px;
        margin: 0;
        width: auto;
        max-width: inherit;
    }
    .bootstrap-tagsinput.form-control input::-moz-placeholder {
        color: #777;
        opacity: 1;
    }
    .bootstrap-tagsinput.form-control input:-ms-input-placeholder {
        color: #777;
    }
    .bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
        color: #777;
    }
    .bootstrap-tagsinput input:focus {
        border: none;
        box-shadow: none;
    }
    .bootstrap-tagsinput .tag {
        padding:2px;
        border-width:2px;
        color: #ffff;
        background-color: #0f6674;
    }
    .bootstrap-tagsinput .tag [data-role="remove"] {
        margin-left: 8px;
        cursor: pointer;
    }
    .bootstrap-tagsinput .tag [data-role="remove"]:after {
        content: "x";
        padding: 0px 2px;
    }
    .bootstrap-tagsinput .tag [data-role="remove"]:hover {
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.87), 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
        box-shadow: inset 0 3px 5px rgb(245, 241, 241);
    }




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
                <h3 class="mt-4">Daily sale Records : <? echo date('D, d-M-Y'); ?></h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Today's Sale</li>
                </ol>
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
                        <input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class="form-group">
                            <label class="small mb-1" for="dater">Date Recorded</label>
                            <input class="form-control" id="dater" data-date-format="dd/mm/yyyy" value="<?php echo date('Y-m-d'); ?>" type="date" name="dater"  required/>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                           <label class="small mb-1" for="units">Initial Reading</label>
                           <input class="form-control" name="iR" id="units" type="number" step="0.01" min="0.0" placeholder="Initial Reading" />
                       </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                            <label class="small mb-1" for="units">Final Reading</label>
                            <input class="form-control" name="fR" id="units" type="number" step="0.01" min="0.0"  placeholder="Final Reading" />
                        </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-xl-6 col-sm-6">
                                <div class="form-group">

                            <label class="small mb-1" for="Amount">Amount Collected</label>

                            <input class="form-control" id="Amount" min="0" onchange="updateDue()" name="iAmount" type="number" placeholder="Amount Collected" />


                        </div>
                            </div>


                            <div class="col-md-6 col-lg-6 col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="AmExp">Spend on Exp..</label>
                                    <input class="form-control" id="AmExp" type="number" onchange="updateDue()" name="AmExp" min="0" placeholder="Amount Spend on Expenditures" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">

                                <label class="small mb-1" for="expenditures">Expenditures</label><br>


                                <input  class="form-control" name="tags" data-role="tagsinput" id="expenditures" placeholder="Add expenditures" type="text" required />
                            </div>



                        <div class="form-group">
                            <label class="small mb-1" for="finalAmount">Final Amount collected</label>
                            <input class="form-control" id="finalAmount" type="number" name="fAmount" placeholder="Final Amount" required/>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-block btn-success" name="SR"  value="Submit Record"  type="submit"  />
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

<script src="../dist/js/tags.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>


</body>
</html>
