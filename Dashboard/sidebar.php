<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="home.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard</a>
            <div class="sb-sidenav-menu-heading">Daily Sales</div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
            ><div class="sb-nav-link-icon"><i class="fas fa-calendar-day"></i></div>Daily sales
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                ></a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="daily-sale-record.php">Record today's sale</a>
                </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutss"
               aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="far fa-file-excel"></i></div>Generate  Report
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                ></a>
            <div class="collapse" id="collapseLayoutss" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="previous-dailysales.php">View Previous sales</a>
                    <a class="nav-link" href="managedailysales.php">Manage daily sales</a>
                </nav>
            </div>
            <div class="sb-sidenav-menu-heading">Monthly Sales</div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsm" aria-expanded="false" aria-controls="collapseLayouts"
            ><div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>Monthly sales
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                ></a>
            <div class="collapse" id="collapseLayoutsm" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="monthly-sale.php?billno=<?php echo $billno?>">Record  sales</a>
                </nav>
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="edit-del-monthly.php">Manage Reports</a></nav>
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="view-monthlysale.php">Generate  Report</a></nav>
            </div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutssm"
               aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>Monthly Customers
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
            <div class="collapse" id="collapseLayoutssm" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="addclient.php">Add new Client</a>
                </nav>
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="view-customers.php?client-id=clients">View Customers</a>
                    </nav>
            </div>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="text-left">Logged in as:</div>
        <p class="text-left"> <?php echo $_SESSION['bhmsuser']; ?></p>
        <div class="text-left ml-sm-auto   d-sm-inline-block d-md-none d-lg-none d-xl-none ml-sm-0 ml-lg-0 ml-xl-0 ml-md-0"><a class="btn btn-block btn-outline-danger" href="process-data/logout.php">Logout</a> </div>
    </div>
</nav>