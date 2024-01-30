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
                    <h1>Product</h1>
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
                        <h3>Your Cart</h3>
                    </div>
                    <?php
                        include("../connection.php");
                        $sql = "select p_id from add_cart where user_id='$cus_id'";
                        $r = mysqli_query($con, $sql);
                        $g_total = 0;
                        $span = 3;
                        if(mysqli_num_rows($r)<1){
                            echo "Your cart is empty";
                        }else{
                            echo "<table>
                                <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Product Price</th>
                                <th>Sub Total </th>
                                <th>Action</th>
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
	                            echo "<form action='cart-details.php' method='post'>";	
                                echo "<tr>
                                <td>$name</td>
                                <td><input type='number' name='$x' value='$cart_quantity' min='1' max='$quantity'></td>
                                <td>$price</td>
                                <td>$sub_total</td>
                                <td><a href='cart-details.php?action=delete&id=$x'>Remove</a></td>
                                </tr>"; 
                            }
                            echo "<tr>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td><b>Grand Total : </b></td>";
                            echo "<td><b>BDT. $g_total</b></td>";
                            echo "</tr>";
                            echo "</table>";
                            echo "<input type='submit' value='Update' name='submission'>";
                            echo "<br/></form>";
                            echo "<a href='checkout.php'>Click to Checkout</a>";	
                        }
                    ?>
                    <?php
                    // Item Remove from cart
                    if(isset($_GET['action']) and $_GET['action'] == 'delete'){
                        $p_id = $_GET['id'];
                        $sql = "delete from add_cart where p_id='$p_id' and user_id='$cus_id'";
                        $r = mysqli_query($con, $sql);	
                        echo "<script>window.location='cart-details.php'</script>";  
                    }
                    // quantity update code
                    if(isset($_POST['submission'])){
                        $sql = "select p_id from add_cart where user_id='$cus_id'";
                        $r = mysqli_query($con, $sql);
                        if(mysqli_num_rows($r)>=1){
                            while($row=mysqli_fetch_array($r)){
                                $p = $row['0'];
                                $q = $_POST[$p];
                                $query="update add_cart set quantity='$q' where user_id='$cus_id' and p_id='$p'"; 
                                mysqli_query($con,$query);
                                echo "<script>window.location='cart-details.php'</script>";  
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>