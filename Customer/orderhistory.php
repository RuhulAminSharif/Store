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
    <style>
        .product-show{
            display: flex;
            /* margin: 25px; */
        }
        .product{
            display: block;
            margin: 25px;
            border-style: solid;
            border-radius:15px;
            padding: 20px;
        }
        .title{
            font-size: 16px;
            font-weight: bold;
        }
        .price{
            color: rgb(0,118,0);
            font-weight: bold;
        }
        .cart-button{
            background-color: rgb(249,217,76);
            border: none;
            height: 30px;
            width: 140px;
            border-radius: 15px;
            margin-right: 8px;
            cursor: pointer;
        }
        .pic{
            border-radius:15px;
        }
    </style>
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
                    <h1>Order History</h1>
                    <ul class="breadcrumb">
                        <li>
                            Pending and Approved Order List
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
                        if(mysqli_num_rows($r)<1){
                            echo "You havn't order yet";
                        }else{
                            $pending = "select * from customer_order where cus_id='$cus_id' and status=0";
                            $x = mysqli_query($con, $pending);
                            echo "<h2>Pending Orders<br/></h2>";
                            if(mysqli_num_rows($x)<1){
                                echo "You have no pending order";
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
                                        <td><a href='orderhistory.php?action=details&id=$order_id'>See Details</a></td>
                                        </tr>";
                                    $order_details = "select * from order_line where order_id='$order_id'";
                                    $y = mysqli_query($con,$order_details);
                                }
                                echo "</table>";
                            }

                            $approved = "select * from customer_order where cus_id='$cus_id' and status=1";
                            $x = mysqli_query($con, $approved);
                            echo "<h2>Approved Orders<br/></h2>";
                            if(mysqli_num_rows($x)<1){
                                echo "You have no approved order";
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
                                        <td><a href='orderhistory.php?action=details&id=$order_id'>See Details</a></td>
                                        </tr>";
                                    $order_details = "select * from order_line where order_id='$order_id'";
                                    $y = mysqli_query($con,$order_details);
                                }
                                echo "</table>";
                            }
                        }
                    ?>
                    <?php
                    if(isset($_GET['action']) and $_GET['action'] == 'details'){
                        $_SESSION['order_id'] = $_GET['id'];
                        echo "<script>window.location='order-details.php'</script>";  
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>