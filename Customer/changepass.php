<?php
    date_default_timezone_set('Asia/Dhaka');
    session_start();
    if($_SESSION['customer_login_status']!="loged in" and ! isset($_SESSION['ID']) )
        header("Location:../login.php");
    
    if(isset($_GET['sign']) and $_GET['sign']=="out"){
        $_SESSION['customer_login_status']="loged out";
        unset($_SESSION['ID']);
        header("Location:../login.php");    
    }
    include("../connection.php");
    $email = $_SESSION['ID'];
    $sql="select * from customer where email = '$email'";

    $r = mysqli_query($con, $sql);

    if(mysqli_num_rows($r)>0){
        $row=mysqli_fetch_array($r);
        $pic = $row['pic'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../Admin/CSS/admin-profile.css">
    <title>Customer Profile | Eleve∞</title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="side-menu">
                <li><a href="home.php"><i class="bx bx-home"></i>Home</a></li>
                <li><a href="product.php"><i class='bx bxl-product-hunt'></i>Product</a></li>
                <li><a href="cart-details.php"><i class='bx bx-cart'></i>Cart Details</a></li>
                <li><a href="orderhistory.php"><i class='bx bx-history'></i>Order History</a></li>
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
            <a href="home.php" class="profile" style="float:right">
                <?php echo "<img src='../Images/Customer_Image/$pic'>"; ?>
            </a>
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
                        $id=$_SESSION['ID'];
                        $opass=$_POST['opass'];
                        $npass=$_POST['npass'];
                        $cpass=$_POST['cpass'];
                        if($npass==$cpass){
                            $sql="select password from customer where password='$opass' and email='$id'";
                            $r=mysqli_query($con,$sql);
                            if(mysqli_num_rows($r)>0){
                                $sql1="update customer set password='$npass' where email='$id'"; 
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