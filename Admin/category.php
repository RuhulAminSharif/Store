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
    <style>
        .form-box{
            margin : 35px;
            display:flex;
        }
        .list{
            margin-right: 35px;
        }
        .form-value{
            margin-right: 50px;
        }
    </style>
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
            <li class="active"><a href="category.php"><i class='bx bxs-add-to-queue'></i>Category</a></li>
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
                    <h1>Category </h1>
                </div>
            </div>
            <!-- Insights -->
            <div class="category">
                <div class="form-box">
                    <?php
                            include("../connection.php");
                            $sql = "select * from category;";
                            $r = mysqli_query($con,$sql);
                            if(mysqli_num_rows($r)>0){
                                $cnt = 1;
                                echo "<table border='1' class='list'>
                                    <tr><th colspan='3'>Category List</th></tr>
                                    <tr><th>Count</th><th>Product Type</th><th>Product Brand</th></tr>";
                                
                                while($row=mysqli_fetch_array($r)){
                                    $ptype = $row['ptype'];
                                    $brand = $row['brand_name'];
                                    echo "<tr><td>$cnt</td><td>$ptype</td><td>$brand</td></tr>";
                                    $cnt += 1;
                                }
                                echo "</table>";
                            }else{
                                echo "There is no category added yet";
                            }
                    ?>
                    <div class="form-value">
                        
                        <form action="category.php" method="post">
                            <h2>Add category</h2>
                            <div class="cat">
                                <label for="ptype">Product type</label><br>
                                <input type="text" id="ptype" name="ptype" required>
                            </div>

                            <div class="cat">
                                <label for="brand">Brand name</label><br>
                                <input type="text" id="brand" name="brand" required>
                            </div>

                            <div class="cat">
                                <input type="submit" value="Submit" name="ok">
                            </div>
                            <?php
                                include("../connection.php");
                                if(isset($_POST['ok'])){
                                    $ptype = $_POST['ptype'];
                                    $brand_name = $_POST['brand'];
                                    
                                    $check = "select * from category where ptype='$ptype' and brand_name='$brand_name'";
                                    $r = mysqli_query($con, $check);

                                    if(mysqli_num_rows($r)>0){
                                        echo "<script>alert('Category already exist')</script>";
                                        echo "<script>window.location='category.php'</script>";
                                    }else{
                                        $sql="insert into category values ('$ptype', '$brand_name')";
                                        mysqli_query($con, $sql);
                                        echo "<script>alert('Category added')</script>";
                                        echo "<script>window.location='category.php'</script>";
                                    }
                                    
                                }
                            ?>
                        </form>

                        <form action="category.php" method="post">
                            <h2>Remove category</h2>
                            <div class="cat">
                                <label for="ptype">Product type</label><br>
                                <input type="text" id="ptype" name="ptype" required>
                            </div>

                            <div class="cat">
                                <label for="brand">Brand name</label><br>
                                <input type="text" id="brand" name="brand" required>
                            </div>

                            <div class="cat">
                                <input type="submit" value="Submit" name="notok">
                            </div>
                            <?php
                                include("../connection.php");
                                if(isset($_POST['notok'])){
                                    $ptype = $_POST['ptype'];
                                    $brand_name = $_POST['brand'];
                                    
                                    $check = "select * from category where ptype='$ptype' and brand_name='$brand_name'";
                                    $r = mysqli_query($con, $check);

                                    if(mysqli_num_rows($r)>0){
                                        $sql = "delete from category where ptype='$ptype' and brand_name='$brand_name'";
                                        mysqli_query($con, $sql);
                                        echo "<script>alert('Category Removed')</script>";
                                        echo "<script>window.location='category.php'</script>";
                                    }else{
                                        echo "<script>alert('There is no such category')</script>";
                                        echo "<script>window.location='category.php'</script>";
                                    }
                                    
                                }
                            ?>
                        </form>
                    </div>
                    <div class="filter">
                        <?php
                            $type = "select distinct(ptype) from category";
                            $rx = mysqli_query($con, $type);
                        ?>
                        <form action="category.php" method="post">
                            <h2>Search Brand By product Type</h2>
                            <div class="pro">
                                <label for="ptype" name="ptype">Product type</label><br>
                                <select name='ptype' required>
                                    <option>Product type</option>
                                    <?php foreach($rx as $key => $x){?>
                                        <option value="<?=$x['ptype'];?>"><?=$x['ptype'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="pro">
                                <input type="submit" value="Click" name="show">
                            </div>
                            <?php
                            if(isset($_POST['show'])){
                                $showtype = $_POST['ptype'];
                                $showbrand = "select distinct(brand_name) from category where ptype = '$showtype'";
                                $showbrandr = mysqli_query($con, $showbrand);
                                $cnt = 1;
                                echo "<table border='1' class='list'>
                                    <tr><th colspan='3'>Brand List of $showtype</th></tr>
                                    <tr><th>Count</th><th>Product Brand</th></tr>";
                                
                                while($showbrandrow=mysqli_fetch_array($showbrandr)){
                                    $brand = $showbrandrow[0];
                                    echo "<tr><td>$cnt</td><td>$brand</td></tr>";
                                    $cnt += 1;
                                }
                                echo "</table>";
                            }
                            ?>
                        </form>
                        <?php
                            $type = "select distinct(brand_name) from category";
                            $ry = mysqli_query($con, $type);
                        ?>
                        <form action="category.php" method="post">
                            <h2>Search product type by brand name</h2>
                            <div class="pro">
                                <label for="ptype" name="ptype">Product type</label><br>
                                <select name='bname' required>
                                    <option>Product type</option>
                                    <?php foreach($ry as $key => $x){?>
                                        <option value="<?=$x['brand_name'];?>"><?=$x['brand_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="pro">
                                <input type="submit" value="Click" name="show-brand">
                            </div>
                            <?php
                            if(isset($_POST['show-brand'])){
                                $showbrand = $_POST['bname'];
                                $ptype = "select distinct(ptype) from category where brand_name = '$showbrand'";
                                $showptyper = mysqli_query($con, $ptype);
                                $cnt = 1;
                                echo "<table border='1' class='list'>
                                    <tr><th colspan='3'>Brand List of $showbrand</th></tr>
                                    <tr><th>Count</th><th>Product Brand</th></tr>";
                                
                                while($showptyperow=mysqli_fetch_array($showptyper)){
                                    $ppp = $showptyperow[0];
                                    echo "<tr><td>$cnt</td><td>$ppp</td></tr>";
                                    $cnt += 1;
                                }
                                echo "</table>";
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End of Insights -->

        </main>

    </div>
</body>

</html>