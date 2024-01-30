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
    $sql = "select count(order_id) from customer_order where status=1";
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
            <li><a href="analytics.php"><i class='bx bx-analyse'></i>Analytics</a></li>
            <li><a href="user.php"><i class='bx bx-group'></i>Users</a></li>
            <li class="active"><a href="corder.php"><i class="bx bxs-order"></i>Customer Orders</a></li>
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
                        Order Management
                    </ul>
                </div>
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

             <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Customer Orders</h3>
                    </div>
                    <?php
                        include("../connection.php");
                        $sql = "select * from customer_order";
                        $r = mysqli_query($con, $sql);
                        if(mysqli_num_rows($r)<1){
                            echo "No order placed yet";
                        }else{
                            $pending = "select * from customer_order where status=0";
                            $x = mysqli_query($con, $pending);
                            echo "<h2>Pending Orders<br/></h2>";
                            if(mysqli_num_rows($x)<1){
                                echo "No pending order";
                            }else{
                                echo "<table>
                                        <tr>
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th>Order Details</th>
                                        <th>Approve</th>
                                        <th>Cancel</th>
                                        </tr>";
                                while($row=mysqli_fetch_array($x)){
                                    $order_id = $row['order_id'];
                                    $date = $row['order_date'];
                                    echo "<tr>
                                        <td>$order_id</td>
                                        <td>$date</td>
                                        <td><a href='corder.php?action=details&oid=$order_id'>See Details</a></td>
                                        <td><a href='corder.php?action=approve&id=$order_id'>Approve Order</a></td>
                                        <td><a href='corder.php?action=cancel&id=$order_id'>Cancel Order</a></td>
                                        </tr>";
                                    $order_details = "select * from order_line where order_id='$order_id'";
                                    $y = mysqli_query($con,$order_details);
                                }
                                echo "</table>";
                            }

                            $approved = "select * from customer_order where status=1";
                            $x = mysqli_query($con, $approved);
                            echo "<h2>Approved Orders<br/></h2>";
                            if(mysqli_num_rows($x)<1){
                                echo "No approved order";
                            }else{
                                echo "<table>
                                        <tr>
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th>Order Details</th>
                                        </tr>";
                                while($row=mysqli_fetch_array($x)){
                                    $order_id = $row['order_id'];
                                    $date = $row['order_date'];
                                    echo "<tr>
                                        <td>$order_id</td>
                                        <td>$date</td>
                                        <td><a href='corder.php?action=details&oid=$order_id'>See Details</a></td>
                                        </tr>";
                                    $order_details = "select * from order_line where order_id='$order_id'";
                                    $y = mysqli_query($con,$order_details);
                                }
                                echo "</table>";
                            }
                        }
                    ?>
                    <?php
                        // showing order details
                        if(isset($_GET['action']) and $_GET['action'] == 'details'){
                            $_SESSION['order_id'] = $_GET['oid'];
                            echo "<script>window.location='order-details.php'</script>";  
                        }

                        // approving order
                        if(isset($_GET['action']) and $_GET['action'] == 'approve'){
                            $order_id = $_GET['id'];
	                        $sql = "select * from order_line where order_id='$order_id'";
                            $r = mysqli_query($con,$sql);
                            $fg = 1;
                            while($row=mysqli_fetch_array($r)){
                                $sold_quantity = $row['sold_quantity'];
                                $p_id = $row['product_id'];
                                $xx = "select * from product_line where product_id='$p_id'";
                                $rr = mysqli_query($con,$xx);
                                $row1 = mysqli_fetch_array($rr);
                                $stock_quantity = $row1['quantity'];
                                if($sold_quantity>$stock_quantity){
                                    $fg = 0;
                                    break;
                                }
                            }
                            if($fg==0){
                                echo "<script>alert('Order not processed')</script>";
                                echo "<script>window.location='corder.php'</script>";  
                            }else{
                                $sql = "select * from order_line where order_id='$order_id'";
                                $r = mysqli_query($con,$sql);
                                while($row=mysqli_fetch_array($r)){
                                    $sold_quantity = $row['sold_quantity'];
                                    $p_id = $row['product_id'];
                                    $sqlupdate="update product_line set quantity=quantity-$sold_quantity where product_id='$p_id'";
		                            mysqli_query($con,$sqlupdate);
                                }
                                $sqlorderupdate="update customer_order set status=1 where order_id='$order_id'";
                                mysqli_query($con,$sqlorderupdate);
                                echo "<script>alert('Order Confirmed!!')</script>";
                                echo "<script>window.location='corder.php'</script>";  
                            }
                        }

                        // cancelling order that has not been confirmed before
                        if(isset($_GET['action']) and $_GET['action'] == 'cancel'){
                            $order_id = $_GET['id'];
                            $del = "delete from customer_order where order_id='$order_id'";
                            mysqli_query($con,$del);
                            echo "<script>window.location='corder.php'</script>";  
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>