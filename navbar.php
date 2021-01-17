<link rel="stylesheet" href="navbar.css">

<!-- queried from HeaderSide.php start -->
<input type="checkbox" id="check">
<!-- HEADER AREA-->
<header> 
        <label for="check">
            <i class="fas fa-bars" id="sidebar_button"></i>
        </label>
        <div class="left_area"> 
            <h3>Theme Park <span>Admin Panel</span></h3>
        </div>
        <!-- <div class="right_area">
            <a href="#" class="logout_button">Logout</a>
        </div>-->
        <div class="right_area"> 
        
            <form method="POST">
               <button name="logout" class="logout_button">Log Out</button>
            </form>
        </div>
    </header>
    <!-- END OF HEADER AREA-->

    <!-- SIDEBAR AREA-->
    <div class="sidebar">
        
        
        <a href="adminPanel.php"><i class="fas fa-plus"></i> <span>New Park Pass</span> </a>
        <a href="customerDetails.php"><i class="fas fa-users"></i><span>Customers</span> </a>
        <a href="rideDetails.php"><i class="fas fa-train"></i> <span>Rides</span> </a>
        <a href="guideDetails.php"><i class="fa fa-user-md"></i> <span>Guide</span> </a>
        <a href="packages.php"><i class="fas fa-money-check"></i><span>Packages</span> </a>
        <a href="transactions.php"><i class="fas fa-money-check-alt"></i><span>Transactions</span> </a>
        <a href="settings.php"> <i class="fas fa-sliders-h"></i><span>Settings</span> </a>
    
       
    
    <!-- </div>
    <div class="content"> -->
        
    </div>
    
    <!-- END OF SIDEBAR AREA-->
    <!-- queried from HeaderSide.php end -->
