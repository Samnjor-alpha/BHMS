
<?php
include '../authentication/config.php';
require  'session.php';
include 'query.php'
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
<div>

</div>     <div  class="row justify-content-center">


                        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8">


                            <div class="card">

                                <div class="card-body">

                                        <?php if (!empty($_SESSION['msg'])): ?>
                                            <div class="alert <?php echo $_SESSION['msg_class'] ?> alert-dismissible fade show"  role="alert">
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

                                    <?php
                                    if (mysqli_num_rows($result_clients) <1) {
                                    echo"<div class='alert  alert-warning alert-dismissible'>";
                                        echo"No monthly customers available";
                                        echo"</div>";
                                    }else{        ?>
                                    <table class="table  table-borderless" >
                                        <thead>
                                        <tr>
                                            <th >Biz name</th>
                                            <th> Mobile Number </th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>

                                        <?php
                                        for ($i = 0; $row_sale = $result_clients->fetch_assoc(); $i++) {
                                        ?>
                                        <tbody>

                                            <tr>

                                                <td><?php   echo $row_sale['biz_name']; ?></td>
                                                <td><?php echo '+'.$row_sale['tel_phone']; ?></td>
                                                <td> <a class="btn btn-sm btn-success" href="view-customer.php?client_id=<?php echo $row_sale['mc_id'] ?>">View</a></td>
                                            </tr>



                                        </tbody>
                                        <?php }?>

                                    </table>
                                        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                                            <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
                                        </div>
                                        <div style="position: center;">
                                        <ul class="pagination">
                                            <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>

                                            <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
                                                <a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
                                            </li>

                                            <?php
                                            if ($total_no_of_pages <= 10){
                                                for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                                    if ($counter == $page_no) {
                                                        echo "<li class='active'><a>$counter</a></li>";
                                                    }else{
                                                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                                    }
                                                }
                                            }
                                            elseif($total_no_of_pages > 10){

                                                if($page_no <= 4) {
                                                    for ($counter = 1; $counter < 8; $counter++){
                                                        if ($counter == $page_no) {
                                                            echo "<li class='active'><a>$counter</a></li>";
                                                        }else{
                                                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                                        }
                                                    }
                                                    echo "<li><a>...</a></li>";
                                                    echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                                                    echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                                                }

                                                elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                                                    echo "<li><a href='?page_no=1'>1</a></li>";
                                                    echo "<li><a href='?page_no=2'>2</a></li>";
                                                    echo "<li><a>...</a></li>";
                                                    for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                                        if ($counter == $page_no) {
                                                            echo "<li class='active'><a>$counter</a></li>";
                                                        }else{
                                                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                                        }
                                                    }
                                                    echo "<li><a>...</a></li>";
                                                    echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                                                    echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                                                }

                                                else {
                                                    echo "<li><a href='?page_no=1'>1</a></li>";
                                                    echo "<li><a href='?page_no=2'>2</a></li>";
                                                    echo "<li><a>...</a></li>";

                                                    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                        if ($counter == $page_no) {
                                                            echo "<li class='active'><a>$counter</a></li>";
                                                        }else{
                                                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>

                                            <li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
                                                <a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
                                            </li>
                                            <?php if($page_no < $total_no_of_pages){
                                                echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                                            } ?>
                                        </ul>
                                        </div>
                                    <?php }?>






                                </div>
                            </div>


</div>


                </div>

        </main>




                <?php  include '../public/footer.php'?>

        <?php  include '../public/scripts.php'?>


</body>
</html>
