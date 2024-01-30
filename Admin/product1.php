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
    $sql = "select distinct(ptype) from category";
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
            <li class="active"><a href="product.php"><i class='bx bxs-add-to-queue'></i>Product</a></li>
            <li><a href="updateproduct.php"><i class='bx bx-reset'></i>Update Product</a></li>
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
                        <form action="product1.php" method="post" enctype="multipart/form-data">
                            <h2>Add product</h2>
                            <div class="pro">
                                <label for="ptype" name="p_type">Product type</label><br>
                                <select name='p_type' disabled>
                                    <option><?php echo $_SESSION['p']; ?></option>
                                </select>
                            </div>
                            <?php
                                    $c = 'pro';
                                    $b = 'brand';
                                    echo "<div class='$c'>
                                    <label for='$b' name='$b'>Brand name</label><br>
                                    <select name='brand'>
                                        <option>brand name</option>";
                                        include("../connection.php");
                                        $x = $_SESSION['p'];
                                        $sql = "select distinct(brand_name) from category where ptype = '$x'";
                                        $r = mysqli_query($con, $sql); 
                                        while($row=mysqli_fetch_array($r)){
                                            $a = $row[0];
                                            echo "<option value='$a'>$a</option>";

                                        }
                                    echo "</select>";
                            ?>
                            <div class="pro">
                                <label for="p_id">Product ID</label><br>
                                <input type="text" name="p_id" placeholder="product id.." required>
                            </div>
                            <div class="pro">
                                <label for="pname">Product name</label><br>
                                <input type="text" name="pname" placeholder="product name.." required>
                            </div>
                            <div class="pro">
                                <label for="descrip">Product description</label><br>
                                <textarea name="descrip" placeholder="description.." required></textarea>
                            </div>
                            <div class="pro">
                                <label for="pic">Product picture</label><br>
                                <input type="file" name="pic" required>
                            </div>
                            <div class="pro">
                                <label for="price">Price</label><br>
                                <input type="number" name="price" placeholder="price.." required>
                            </div>
                            <div class="pro">
                                <label for="quantity">Quantity</label><br>
                                <input type="number" name="quantity" placeholder="quantity.." required>
                            </div>
                            <div class="pro">
                                <input type="submit" value="Submit" name="Add">
                            </div>
                            <?php
                                include("../connection.php");
                                if(isset($_POST['Add'])){
                                    // to receive value from the input fields
                                    $ptype = $_SESSION['p'];
                                    $brand = $_POST['brand'];
                                    $p_id = $_POST['p_id'];
                                    $name = $_POST['pname'];
                                    $descrip = $_POST['descrip'];
                                    $price = $_POST['price'];
                                    $quantity = $_POST['quantity'];

                                    // image processing
                                        // to find extension
                                        $ext = explode(".", $_FILES['pic']['name']);
                                        $cnt = count($ext);
                                        $ext = $ext[$cnt-1];
                                            //echo $ext;
                                        // to generate new name for image
                                        $date = date(DATE_ATOM);
                                        $img_fname = md5($date);

                                        // generated image name with extension
                                        $image = $img_fname.".".$ext;
                                        // echo $image;

                                        $check = "select * from product where product_id='$p_id'";
                                        $r = mysqli_query($con, $check);
                                        if(mysqli_num_rows($r)>0){
                                            echo "can't add product". "\n". "this product already exist";
                                            echo "To add stock of this product go to ";
                                            echo "<a href='updateproduct.php'>update product</a>";
                                        }else{
                                            $query="insert into product values('$p_id','$name', '$descrip','$image', '$ptype', '$brand')";
                                            $query1="insert into product_line values('$p_id',$price, $quantity)";
                                            mysqli_query($con, $query);
                                            mysqli_query($con, $query1);
                                            echo "Success";
                                            if($image!=null){
                                                move_uploaded_file($_FILES['pic']['tmp_name'],"../Images/Product_Image/$image");
                                            }
                                        }
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