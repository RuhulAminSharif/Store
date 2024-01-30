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
        $rowx=mysqli_fetch_array($r);
        $name = $rowx['name'];
        $email = $rowx['email'];
        $pass = $rowx['password'];
        $pic = $rowx['pic'];
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
    <ul class="side-menu">
            <li><a href="admin-profile.php"><i class="bx bx-home"></i>Home</a></li>
            <li><a href="shop.php"><i class='bx bx-store-alt'></i>Shop</a></li>
            <li><a href="product.php"><i class='bx bxs-add-to-queue'></i>Product</a></li>
            <li><a href="updateproduct.php"><i class='bx bx-reset'></i>Update Product</a></li>
            <li><a href="analytics.php"><i class='bx bx-analyse'></i>Analytics</a></li>
            <li><a href="user.php"><i class='bx bx-group'></i>Users</a></li>
            <li><a href="corder.php"><i class="bx bxs-order"></i>Customer Orders</a></li>
        </ul>
        <ul class="side-menu">
            <li class="active">
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
        <h2 align='center'>Change Your Password</h2>
                <div class="container">
                    <form action="changepass.php" method="post">
                        <div class="row">
                            <div class="col-25">
                                <label for="pass">Old Password</label>
                            </div>
                            <div class="col-75">
                                <input type="password" id="pass" name="opass" placeholder="Your old password..">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="pass">New Password</label>
                            </div>
                            <div class="col-75">
                                <input type="password" id="pass" name="npass" placeholder="Your new password..">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="pass">Confirm Password</label>
                            </div>
                            <div class="col-75">
                                <input type="password" id="pass" name="cpass" placeholder="Retype Your password..">
                            </div>
                        </div>
                        <div class="row">
                            <input type="submit" value="Change Password" name="submit">
                        </div>
                    </form>
                </div>
                <?php
                    if(isset($_POST['submit'])){
                        include("../connection.php");
                        $id=$_SESSION['user_id'];
                        $opass=$_POST['opass'];
                        $npass=$_POST['npass'];
                        $cpass=$_POST['cpass'];
                        if($npass==$cpass){
                            $sql="select password from admin where password='$opass' and admin_id='$id'";
                            $r=mysqli_query($con,$sql);
                            if(mysqli_num_rows($r)>0){
                                $sql1="update admin set password='$npass' where admin_id='$id'"; 
                                if(mysqli_query($con,$sql1)){
                                    echo "Password Changed Successfully!";
                                }  
                            }else{
                                echo "Old password does not match";
                            }
                        }else{
                            echo "New password does not match with Confirm password";
                        }
                    }
                ?>

        </main>

    </div>
</body>

</html>