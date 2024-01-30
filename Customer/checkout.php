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
            <li class="active"><a href="cart-details.php"><i class='bx bx-cart'></i>Cart Details</a></li>
            <li><a href="orderhistory.php"><i class='bx bx-history'></i>Order History</a></li>
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
                    <h1>Order</h1>
                    <ul class="breadcrumb">
                        <li>
                            Welcome to order page
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <h3>Your Tentative Product Order List</h3>
                    </div>
                    <?php
                        include("../connection.php");
                        $sql = "select p_id from add_cart where user_id='$cus_id'";
                        $r = mysqli_query($con, $sql);
                        $g_total = 0;
                        $span = 3;
                        
                        echo "<table>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Extended Price</th>
                            </tr>";
                        while($row=mysqli_fetch_array($r)){
                            $x = $row['0']; // product id
                            $sql = "select * from product natural join product_line where product_id='$x'";
                            $r1 = mysqli_query($con, $sql);
                            $row1 = mysqli_fetch_array($r1);
                            $name = $row1['product_name'];
                            $quantity = $row1['quantity'];
                            $price = $row1['selling_price'];

                            $sql2 = "select * from add_cart where p_id='$x'";
                            $r2 =    mysqli_query($con, $sql2);
                            $row2 = mysqli_fetch_array($r2);
                            $cart_quantity = $row2['quantity'];
                            $sub_total = $cart_quantity*$price;
                            $g_total += $sub_total;
                            echo "<form action='checkout.php' method='post'>";	
                            echo "<tr>
                                <td><input type='hidden' name='p_id'value='$x'>$x</td>
                                <td>$name</td>
                                <td>$cart_quantity</td>
                                <td>$price</td>
                                <td>$sub_total</td>
                                </tr>"; 
                            }
                            echo "<tr>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td><b>Grand Total </b></td>";
                            echo "<td><b>BDT. $g_total</b></td>";
                            echo "</tr>";
                            echo "</table>";
                            echo "<input type='submit' value='Confirm Order' name='submission'>";
                            echo "</form>";                        
                    ?>
                    <?php
                    // customer order management
                    if(isset($_POST['submission'])){
                        // order id generation
                        $date = date(DATE_ATOM);
                        $res = str_replace( array('-','T' , ':', '+', '>' ), '', $date);
                        $order_id = "o-".$res;
                        // echo $order_id;
                        // echo $cus_id;
                        $order_date = date("Y-m-d");
                        $status = 0;
                        
                        $sqlorder = "insert into customer_order values('$order_id','$cus_id','$order_date',$status)";
	                    mysqli_query($con,$sqlorder);

                        $sql = "select * from add_cart where user_id='$cus_id'";
                        $r = mysqli_query($con, $sql);
                        //order_id	product_id	sold_quantity	sold_price
                        while($row=mysqli_fetch_array($r)){
                            $product_id = $row['p_id'];
                            $sold_quantity = $row['quantity'];
                            
                            // for unit price
                            $xx = "select * from product_line where product_id='$product_id'";
                            $yy = mysqli_query($con,$xx);
                            $zz = mysqli_fetch_array($yy);
                            $unit_price = $zz['selling_price'];
                            
                            $sold_price =  $sold_quantity*$unit_price;

                            $query="insert into order_line values('$order_id','$product_id',$sold_quantity,$sold_price)"; 
                            mysqli_query($con,$query);
                        }
                        echo "<script>alert('your order has been submited successfully')</script>";
                        // removing the items from cart
                        $del = "delete from add_cart where user_id='$cus_id'";
                        mysqli_query($con,$del);
                        echo "<script>window.location='cart-details.php'</script>";  
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>