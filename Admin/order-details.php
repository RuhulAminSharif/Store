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
                <a href="changepass.php">
                    <i class='bx bx-reset'></i>
                        Change Password 
                </a>
            </li>
            <li>
                <a href="?sign=out" class="logout">
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
                    <h1>Order Details</h1>
                    <ul class="breadcrumb">
                        <li>
                            Order Information
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bottom-data">
                <div class="orders">
                    <?php
                        include("../connection.php");
                        $g_total = 0;
                        
                            $o_id = $_SESSION['order_id'];
                            $order_details = "select * from order_line where order_id='$o_id'";
                            $y = mysqli_query($con,$order_details);
                            
                            $customer_details = "select * from customer_order where order_id='$o_id'";
                            $z = mysqli_query($con,$customer_details);
                            $cus_info = mysqli_fetch_array($z);
                            $c_id = $cus_info['cus_id'];
                            
                            $customer_details = "select * from customer where cus_id='$c_id'";
                            $z = mysqli_query($con,$customer_details);
                            $cus_info = mysqli_fetch_array($z);
                            $cus_name = $cus_info['first_name'];
                            $cus_name1 = $cus_info['last_name'];
                            $address = $cus_info['address'];
                            $num =  $cus_info['mobile'];
                            // echo $num;
                            echo "<div class='header'>
                                <h3>Customer Info</h3>
                            </div>";
                            echo "<table>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                </tr>
                                <tr>
                                    <td>$c_id</td>
                                    <td>$cus_name $cus_name1</td>
                                    <td>$address</td>
                                </tr>
                                </table>";
                            echo "<div class='header'>
                                <h3>Order Catalog</h3>
                            </div>";
                            echo "<table>
                                <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Per Unit Price</th>
                                <th>Sub Total</th>
                                </tr>";
                                while($row=mysqli_fetch_array($y)){
                                    $p_id = $row['product_id'];
                                    $sold_quantity = $row['sold_quantity'];
                                    $sold_price = $row['sold_price'];
                                    $unit_price = $sold_price/$sold_quantity;
                                    $g_total += $sold_price;
                                    echo "<tr>
                                        <td>$p_id</td>
                                        <td>$sold_quantity</td>
                                        <td>$unit_price</td>
                                        <td>$sold_price</td>
                                        </tr>";
                                }
                                echo "<tr><td colspan = '2'><b>Grand Total :</b></td><td><b>BDT. $g_total</b></td></tr>";
                                echo "</table>";
                            
                        
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>