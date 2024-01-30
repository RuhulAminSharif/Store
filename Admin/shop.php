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
            <li class="active"><a href="shop.php"><i class='bx bx-store-alt'></i>Shop</a></li>
            <li><a href="category.php"><i class='bx bxs-add-to-queue'></i>Category</a></li>
            <li><a href="product.php"><i class='bx bxs-add-to-queue'></i>Product</a></li>
            <li><a href="analytics.php"><i class='bx bx-analyse'></i>Analytics</a></li>
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
                        Product Information
                    </ul>
                </div>
            </div>

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Product Lists</h3>
                    </div>
                    <?php
                            include("../connection.php");
                            $sql = "select distinct(ptype) from product";
                            $r = mysqli_query($con, $sql);
                            while($row=mysqli_fetch_array($r)){
                                echo "<h2 align='center'>$row[0]</h2></br></br>"; // $row[0] -> product type

                                $sql1 = "select distinct(brand_name) from product where ptype = '$row[0]'";
                                $r1 = mysqli_query($con, $sql1); 
                                while($row1=mysqli_fetch_array($r1)){
                                    echo "<h4 align='left'>Product brand : $row1[0]</h4></br>";
                                    $sql2 = "select * from product natural join product_line where product.ptype='$row[0]' && product.brand_name='$row1[0]'";
                                    $r2 = mysqli_query($con, $sql2);
                                    echo "<table>";
                                    echo "<thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Per Unit Price</th>
                                            <th>Product Quantity</th>
                                            
                                        </tr>
                                    </thead>";
                                    echo "<tbody>";
                                    while($row2=mysqli_fetch_array($r2)){
                                        $id = $row2['product_id'];
                                        $name = $row2['product_name'];
                                        $pic = $row2['pic'];
                                        $price = $row2['selling_price'];
                                        $quantity = $row2['quantity'];
                                        echo "
                                        <tr>
                                            <td>$id</td>
                                            <td>$name</td>
                                            <td align='center'><img src='../Images/Product_Image/$pic'></td>
                                            <td>$price</td>
                                            <td>$quantity</td>
                                        </tr>
                                        ";
                                    }
                                    echo "</br>";
                                    echo "</tbody>";
                                echo "</table>"; 
                                    
                                }
                            }
                    ?>
                </div>

            </div>

        </main>

    </div>
</body>

</html>