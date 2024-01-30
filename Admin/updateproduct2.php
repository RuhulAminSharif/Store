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
<?php
    include("../connection.php");
    $sql = "select distinct(ptype) from product";
    $r = mysqli_query($con, $sql);
    
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
            <li class="active"><a href="updateproduct.php"><i class='bx bx-reset'></i>Update Product</a></li>

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
                    <h1>Product management</h1>
                </div>
            </div>

            <!-- Insights -->
            <div class="product">
                <div class="form-box">
                    <div class="form-value">
                        <form action="updateproduct2.php" method="post" enctype="multipart/form-data">
                            <h2>Add product</h2>
                            <div class="pro">
                                <label for="ptype" name="p_type">Product type</label><br>
                                <select name='p_type' disabled>
                                    <option><?php echo $_SESSION['p']; ?></option>
                                </select>
                            </div>
                            <div class="pro">
                                <label for="ptype" name="p_type">Product type</label><br>
                                <select name='brand' disabled>
                                    <option><?php echo $_SESSION['brand']; ?></option>
                                </select>
                            </div>
                            <?php
                                    $c = 'pro';
                                    $t = 'type';
                                    echo "<div class='$c'>
                                    <label for='id' name='id'>Product ID</label><br>
                                    <select name='id' required>
                                        <option>select id</option>";
                                        include("../connection.php");
                                        $x = $_SESSION['p'];
                                        $y = $_SESSION['brand'];
                                        $sql = "select * from product natural join product_line where product.ptype='$x' && product.brand_name='$y'";
                                        $r = mysqli_query($con, $sql); 
                                        while($row=mysqli_fetch_array($r)){
                                            $a = $row['product_id'];
                                            echo "<option value='$a'>$a</option>";

                                        }
                                    echo "</select>";
                            ?>
                            <div class="pro">
                                <input type="submit" value="Submit" name="ok">
                            </div>
                        </form>
                        <?php
                                include("../connection.php");
                                if(isset($_POST['ok'])){
                                    // to receive value from the input fields

                                    $_SESSION['p_id'] = $_POST['id'];
                                    if($_SESSION['p']=='Product type')
                                        header("Location: updateproduct.php");
                                    else if($_SESSION['brand']=='brand name')
                                        header("Location: updateproduct1.php");
                                    else if($_SESSION['p_id']=='select id') 
                                        header("Location: updateproduct2.php");
                                    else 
                                        header("Location: updateproduct3.php");
                                }
                        ?>
                    </div>
                </div>
            </div>
            <!-- End of Insights -->
        </main>
    </div>
</body>

</html>