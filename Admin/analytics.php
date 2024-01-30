<?php
    date_default_timezone_set('Asia/Dhaka');
    session_start();
    if($_SESSION['admin_login_status']!="loged in" and ! isset($_SESSION['user_id']) )
        header("Location:login.php");

    if(isset($_GET['sign']) and $_GET['sign']=="out"){
        $_SESSION['admin_login_status']="loged out";
        unset($_SESSION['user_id']);
        header("Location:login.php");    
    }

    include("../connection.php");
    $sql = "select count(distinct order_id) from customer_order natural join order_line where status=1";
    $r = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($r);
    $paid_orders = $row['0'];
    $sql = "select sum(sold_price) from customer_order natural join order_line where status=1";
    $r = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($r);
    $total_sales = $row['0'];

    $ID = $_SESSION['user_id'];
    $sql="select * from admin where admin_id = '$ID'";
    $r = mysqli_query($con, $sql);
    if(mysqli_num_rows($r)>0){
        $row=mysqli_fetch_array($r);
        $name = $row['name'];
        $email = $row['email'];
        $pass = $row['password'];
        $pic = $row['pic'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .orders{
            display: flex;
        }
        .sales{
            margin-right: 250px;
        }
        .bottom-data{
            display: block;
        }
    </style>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="CSS/admin-profile.css">
    <title>Eleve∞ | <?php echo $name;?></title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>Eleve</span>∞</div>
        </a>
        <ul class="side-menu">
            <li><a href="admin-profile.php"><i class="bx bx-home"></i>Home</a></li>
            <li><a href="shop.php"><i class='bx bx-store-alt'></i>Shop</a></li>
            <li><a href="category.php"><i class='bx bxs-add-to-queue'></i>Category</a></li>
            <li><a href="product.php"><i class='bx bxs-add-to-queue'></i>Product</a></li>
            <li class="active"><a href="analytics.php"><i class='bx bx-analyse'></i>Analytics</a></li>
            <li><a href="user.php"><i class='bx bx-group'></i>Users</a></li>
            <li><a href="corder.php"><i class="bx bxs-order"></i>Customer Orders</a></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="changepass.php" style="float:right">
                    <i class='bx bx-reset'></i>
                    Change Password 
                </a>
            </li>
            <li>
                <a href="?sign=out">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav style="float:right">
            <?php
                echo "<a href='admin-profile.php' class='profile'>
                    <img src='../Images/Admin_Image/$pic'>
                </a>";
            ?>
        </nav>

        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li> Order Information</li>
                    </ul>
                </div>
                <!-- <a href="#" class="report">
                    <i class='bx bx-cloud-download'></i>
                    <span>Download CSV</span>
                </a> -->
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <h3>
                            <?php
                                echo $paid_orders;
                            ?>
                        </h3>
                        <p>Paid Order</p>
                    </span>
                </li>
                <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3>
                            <?php
                                echo $total_sales;
                            ?>
                        </h3>
                        <p>Total Sales</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->
            <?php
                $today = date("Y-m-d");
                $q1 = "select order_id from customer_order where order_date='$today'and status=1";
                $r1= mysqli_query($con, $q1);
                $t_total = 0;
                if(mysqli_num_rows($r1)>0){
                    while($row1=mysqli_fetch_array($r1)){
                        $oid = $row1[0];
                        $q2 = "select sum(sold_price) from order_line where order_id='$oid'";
                        $r2 = mysqli_query($con,$q2);
                        $rrr = mysqli_fetch_array($r2);
                        $t_total += $rrr[0];
                    }
                }
                $t1 = strtotime("-6 days");
                $start =  date("Y-m-d", $t1);
                $end = date("Y-m-d");
                $currentDate = strtotime($start);
                $last_week_total = 0;
                while($currentDate <= strtotime($end)){
                    $day_to_calculate = date("Y-m-d", $currentDate);
                    $q1 = "select order_id from customer_order where order_date = '$day_to_calculate' and status=1";
                    $r1 = mysqli_query($con, $q1);
                    
                    if(mysqli_num_rows($r1)>0){
                        while($row1=mysqli_fetch_array($r1)){
                            $oid = $row1[0];
                            $q2 = "select sum(sold_price) from order_line where order_id='$oid'";
                            $r2 = mysqli_query($con,$q2);
                            $rrr = mysqli_fetch_array($r2);
                            $last_week_total += $rrr[0];
                        }
                    }
                    //Add one day onto the timestamp / counter.
                    $currentDate = strtotime("+1 day", $currentDate);
                }
                $t2 = strtotime("-29 days");
                $start =  date("Y-m-d", $t1);
                $end = date("Y-m-d");
                $currentDate = strtotime($start);
                $last_month_total = 0;
                while($currentDate <= strtotime($end)){
                    $day_to_calculate = date("Y-m-d", $currentDate);
                    $q1 = "select order_id from customer_order where order_date = '$day_to_calculate' and status=1";
                    $r1 = mysqli_query($con, $q1);
                    
                    if(mysqli_num_rows($r1)>0){
                        while($row1=mysqli_fetch_array($r1)){
                            $oid = $row1[0];
                            $q2 = "select sum(sold_price) from order_line where order_id='$oid'";
                            $r2 = mysqli_query($con,$q2);
                            $rrr = mysqli_fetch_array($r2);
                            $last_month_total += $rrr[0];
                        }
                    }
                    //Add one day onto the timestamp / counter.
                    $currentDate = strtotime("+1 day", $currentDate);
                }
            ?>
            <div class="bottom-data">
                <div class="orders">
                    <div class="sales"><h3>Todays sales <br><p>BDT.  <?php echo $t_total; ?></p></h3></div>
                    <div class="sales"><h3>Last week sales<br><p>BDT.  <?php echo $last_week_total; ?></h3></div>
                    <div class="sales"><h3>Last months sales<br><p>BDT.  <?php echo $last_month_total; ?></h3></div>
                </div>
                
            </div>
            <h2>See sales by filtering</h2>
            <div class="bottom-data">
                <div class="orders">
                    <div class="sales">
                        <h3>Search by date</h3>
                        <form action="analytics.php" method="post">
                            <label for="search_date">Enter a date</label>
                            <input type="date" id="search_date" name="search_date" value="<?php echo $today;?>" required>
                            <input type="submit" value="Click" name="date-to-search">
                        </form>
                            
                        <?php
                            if(isset($_POST['date-to-search'])){
                                $selected_date = $_POST['search_date'];
                                $q1 = "select order_id from customer_order where order_date='$selected_date'and status=1";
                                $r1= mysqli_query($con, $q1);
                                $t_total = 0;
                                if(mysqli_num_rows($r1)>0){
                                    while($row1=mysqli_fetch_array($r1)){
                                        $oid = $row1[0];
                                        $q2 = "select sum(sold_price) from order_line where order_id='$oid'";
                                        $r2 = mysqli_query($con,$q2);
                                        $rrr = mysqli_fetch_array($r2);
                                        $t_total += $rrr[0];
                                    }
                                }
                                if($t_total==0){
                                    echo "<b>No sales</b> on $selected_date";
                                }else{
                                    echo "<p>Sales on $selected_date is $t_total</p>";
                                }
                            }
                        ?>
                    </div>
                    <div class="sales">
                        <h3>Search by specific period</h3>
                        <form action="analytics.php" method="post">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" value="<?php echo $today;?>" required>
                            <label for="start_date">End Date</label>
                            <input type="date" name="end_date" value="<?php echo $today;?>" required>
                            <input type="submit" value="Click" name="time-period-to-search">
                        </form>
                        <?php
                            if(isset($_POST['time-period-to-search'])){
                                $start =  $_POST['start_date'];
                                $end = $_POST['end_date'];
                                $currentDate = strtotime($start);
                                $total = 0;
                                while($currentDate <= strtotime($end)){
                                    $day_to_calculate = date("Y-m-d", $currentDate);
                                    $q1 = "select order_id from customer_order where order_date = '$day_to_calculate' and status=1";
                                    $r1 = mysqli_query($con, $q1);
                                    
                                    if(mysqli_num_rows($r1)>0){
                                        while($row1=mysqli_fetch_array($r1)){
                                            $oid = $row1[0];
                                            $q2 = "select sum(sold_price) from order_line where order_id='$oid'";
                                            $r2 = mysqli_query($con,$q2);
                                            $rrr = mysqli_fetch_array($r2);
                                            $total += $rrr[0];
                                        }
                                    }
                                    //Add one day onto the timestamp / counter.
                                    $currentDate = strtotime("+1 day", $currentDate);
                                }
                                if($total==0){
                                    echo "<b>No sales</b>";
                                }else{
                                    echo "<p>Sales on selected period is $total</p>";
                                }
                            }
                        ?>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
</body>
</html>