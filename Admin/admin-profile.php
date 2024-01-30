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
            <li class="active"><a href="admin-profile.php"><i class="bx bx-home"></i>Home</a></li>
            <li><a href="shop.php"><i class='bx bx-store-alt'></i>Shop</a></li>
            <li><a href="category.php"><i class='bx bxs-add-to-queue'></i>Category</a></li>
            <li><a href="product.php"><i class='bx bxs-add-to-queue'></i>Product</a></li>
            <li><a href="analytics.php"><i class='bx bx-analyse'></i>Analytics</a></li>
            <li><a href="user.php"><i class='bx bx-group'></i>Users</a></li>
            <li><a href="corder.php"><i class="bx bxs-order"></i>Customer Orders</a></li>
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
                    <h1>Profile</h1>
                    <ul class="breadcrumb">
                        <li>
                            Personal Information
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <span class="info">
                        <?php
                            echo "<img src='../Images/Admin_Image/$pic' alt='$name' style='width:300px;height:300px;'>";
                            echo "<p style='color:black;'>$name</p>";
                        ?>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <h3>All Information</h3>
                    </div>
                    <form action="admin-profile.php" method="post" enctype="multipart/form-data">
                    <table>
                            <tr><th>Name</th><?php echo "<td><input type='text' value='$name' name='full_name'></td>"; ?></tr>
                            <tr><th>Email</th><?php echo "<td><input type='email' value='$email' name='mail' disabled></td>"; ?></tr>      
                            <tr><th>Pic</th><?php echo "<td><input value='$pic' type='file' name='pic'></td>"?></tr>
                    </table>
                    <input type='submit' value='Save changes' name='submit' class='submission'>
                    </form>
                    <?php
                        include("../connection.php");
                        if(isset($_POST['submit'])){
                            // to receive value from the input fields
                            $full_name = $_POST['full_name'];
                            // image processing
                                // to find extension
                                $ext = explode(".", $_FILES['pic']['name']);
                                $cnt = count($ext);
                                $ext = $ext[$cnt-1];
                                    // echo $ext;
                            if($ext==''){
                                $image = $pic;
                                // echo $pic;
                            }else{
                                // to generate new name for image
                                $date = date(DATE_ATOM);
                                // echo $date;
                                $img_fname = md5($date);
                    
                                // generated image name with extension
                                $image = $img_fname.".".$ext;
                                // echo $image;

                                move_uploaded_file($_FILES['pic']['tmp_name'],"../Images/Admin_Image/$image");
                            }
                            $sql = "update admin set name='$full_name', pic='$image' where email='$email'";
                            // $r = mysqli_query($con, $sql);
                            if(mysqli_query($con, $sql)){
                                echo "<script>alert('Changes have been saved')</script>";
                                echo "<script>window.location='admin-profile.php'</script>";
                            }
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>