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
    // Cart implementation code
    if(isset($_POST['add']))
    {
        $p_id = $_GET['id'];
        
        $sql="select * from add_cart where p_id = '$p_id' and user_id='$cus_id'";
        $r = mysqli_query($con, $sql);

        if(mysqli_num_rows($r)>0){
            echo "<script>alert('Item already added')</script>";
            echo "<script>window.location='product-details.php'</script>";
        }else{
            $sql1 = "insert into add_cart values ('$cus_id', '$p_id',1)";
            $r = mysqli_query($con, $sql1);
            
            echo "<script>alert('Item added')</script>";
        }		   
    }
    
    // product-details implementation code
    if(isset($_GET['action']) and $_GET['action'] == 'details'){
        $_SESSION['product_details_id'] = $_GET['id'];
        echo "<script>window.location='product-details.php'</script>";  
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
            <li class="active"><a href="product.php"><i class='bx bxl-product-hunt'></i>Product</a></li>
            <li><a href="cart-details.php"><i class='bx bx-cart'></i>Cart Details</a></li>
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
                    <h1>Product Details</h1>
                </div>
            </div>

            <div class="bottom-data">
                <div class="orders">
                    <?php
                        include("../connection.php");
                        $product_show_id = $_SESSION['product_details_id'];
                        $query = "select * from product natural join product_line where product.product_id = '$product_show_id'";
                        $r = mysqli_query($con, $query);
                        $row=mysqli_fetch_array($r);
                        $id = $row['product_id'];
                        $name = $row['product_name'];
                        $description = $row['description'];
                        $pic = $row['pic'];
                        $ptype = $row['ptype'];
                        $brand_name = $row['brand_name'];
                        $price = $row['selling_price'];
                        $quantity = $row['quantity'];
                        echo "<form action='product-details.php?action=add&id=$id' method='post'>";
                        echo "<a href='product.php?action=details&id=$id'><img width='200px' height='200pxclass='pic' width='100px' height='100px' src='../Images/Product_Image/$pic'></a><br>";
                        echo "<p class='title'>$name</p>";
                        echo "<p>It's a product of $brand_name</p>";
                        $length = strlen($description);
                        for ($index = 0; $index < $length; $index++) {
                            echo $description[$index];
                            
                        }
                        echo "<p class='price'>BDT. $price - in stock</p>";
                                
                        echo "<input class='cart-button' type='submit' value='Add to cart' name='add'>";
                        echo "</form>";
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>