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
        $f_name = $row['first_name'];
        $l_name = $row['last_name'];
        $email = $row['email'];
        $pass = $row['password'];
        $address = $row['address'];
        $mobile = $row['mobile'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $pic = $row['pic'];
    }
    if(empty($_SESSION['cart'])){
	   $_SESSION['cart']=array();
   }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="CSS/home.css">
    <title>Eleve∞ | <?php echo $f_name." ".$l_name;?></title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>Eleve</span>∞</div>
        </a>
        <ul class="side-menu">
            <li class="active"><a href="home.php"><i class="bx bx-home"></i>Home</a></li>
            <li><a href="product.php"><i class='bx bxl-product-hunt'></i>Product</a></li>
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
                echo "<img src='../Images/Customer_Image/$pic' style='width:40px;height:40px;'>";
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
                            echo "<img src='../Images/Customer_Image/$pic' alt='$f_name' style='width:300px;height:300px;'>";
                            echo "<p style='color:black;'>$f_name $l_name</p>";
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
                    <form action="home.php" method="post" enctype="multipart/form-data">
                    <table>
                            <tr><th>First Name</th><?php echo "<td><input type='text' value='$f_name' name='first_name'></td>"; ?></tr>
                            <tr><th>Last Name</th><?php  echo "<td><input type='text' value='$l_name' name='last_name'></td>"; ?></tr>    
                            <tr><th>Email</th><?php echo "<td><input type='email' value='$email' name='mail' disabled></td>"; ?></tr>    
                            <tr><th>Address</th><?php echo "<td>  <select name='loc' value='$address'>
                                            <option value='$address' selected>$address</option>
                                            <option value='dhaka'>Dhaka</option>
                                            <option value='chittagong'>Chittagong</option>
                                            <option value='khulna'>Khulna</option>
                                            </select>
                                        </td>";?></tr>    
                            <tr><th>Mobile</th><?php echo "<td><input type='tel' name='mobile' value='$mobile'></td>";?></tr>    
                            <tr><th>Date of Birth</th><?php echo "<td><input type='date' name='dob' value='$dob'></td>";?></tr>    
                            <tr><th>Gender</th><?php echo    "<td>  <select name='gender' value='$gender'>
                                            <option value='male'>Male</option>
                                            <option value='female'>Female</option>
                                            </select>
                                        </td>";?></tr> 
                            <tr><th>Pic</th><?php echo "<td><input value='$pic' type='file' name='pic'></td>"?></tr>
                    </table>
                    <input type='submit' value='Save changes' name='submit' class='submission'>
                    </form>
                    <?php
                        include("../connection.php");
                        if(isset($_POST['submit'])){
                            // to receive value from the input fields
                            $f_name = $_POST['first_name'];
                            $l_name = $_POST['last_name'];
                            $loc = $_POST['loc'];
                            $mobile = $_POST['mobile'];
                            $dob = $_POST['dob'];
                            $gender = $_POST['gender'];
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

                                move_uploaded_file($_FILES['pic']['tmp_name'],"../Images/Customer_Image/$image");
                            }
                            $sql = "update customer set first_name='$f_name', last_name='$l_name', address='$loc', mobile='$mobile', dob='$dob', gender='$gender', pic='$image' where email='$email'";
                            // $r = mysqli_query($con, $sql);
                            if(mysqli_query($con, $sql)){
                                echo "<script>alert('Changes have been saved')</script>";
                                echo "<script>window.location='home.php'</script>";
                            
                            }
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>