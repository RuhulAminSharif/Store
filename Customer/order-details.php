<?php
    date_default_timezone_set('Asia/Dhaka');
    session_start();
    if($_SESSION['customer_login_status']!="loged in"){
        header("Location:../index.php");
    }
    if(isset($_GET['sign']) and $_GET['sign']=="out"){
        $_SESSION['customer_login_status']="Loged out";
        unset($_SESSION['ID']);
        header("Location:../index.php");
    }
    include("../connection.php");
    $email = $_SESSION['ID'];
    $sql="select * from customer where email = '$email'";

    $r = mysqli_query($con, $sql);

    if(mysqli_num_rows($r)>0){
        $row=mysqli_fetch_array($r);
        $cus_id = $row['cus_id'];
        $f_name = $row['first_name'];
        $l_name = $row['last_name'];
        $pic = $row['pic'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eleve∞ | <?php echo $f_name." ".$l_name;?></title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="/home.css"> -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../Admin/CSS/admin-profile.css">
    <link type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css"
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" 
        referrerpolicy="no-referrer"
    />
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>Eleve</span>∞</div>
        </a>
        <ul class="side-menu">
            <li><a href="home.php"><i class="bx bx-home"></i>Home</a></li>
            <li><a href="product.php"><i class='bx bxl-product-hunt'></i>Product</a></li>
            <li><a href="cart-details.php"><i class='bx bx-cart'></i>Cart Details</a></li>
            <li class="active"><a href="orderhistory.php"><i class='bx bx-history'></i>Order History</a></li>
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
                echo "<img src='../Images/Customer_Image/$pic' alt='$f_name' style='width:20px;height:20px;'>";
            ?>
        </nav>

        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Order Details</h1>
                    <ul class="breadcrumb">
                        <li>
                            Descriptions about your order
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <h3>Order Catalog</h3>
                    </div>
                    <?php
                        include("../connection.php");
                        $sql = "select * from customer_order where cus_id='$cus_id'";
                        $r = mysqli_query($con, $sql);
                        $g_total = 0;
                        if(mysqli_num_rows($r)<1){
                            echo "You havn't order yet";
                        }else{
                            $order_id = $_SESSION['order_id'];
                            $order_details = "select * from order_line where order_id='$order_id'";
                            $y = mysqli_query($con,$order_details);
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
                                echo "<tr>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td><b>Grand Total : </b></td>";
                                echo "<td><b>BDT. $g_total</b></td>";
                                echo "</tr>";
                                echo "</table>";
                            
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>