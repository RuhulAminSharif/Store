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

    $sql="select count(*) from customer where status=1";
    $sql1="select count(*) from customer where status=0";

    $r = mysqli_query($con, $sql);
    $r1 = mysqli_query($con, $sql1);

    $row=mysqli_fetch_array($r);
    $row1=mysqli_fetch_array($r1);
?>
<!DOCTYPE html >
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
            <li><a href="analytics.php"><i class='bx bx-analyse'></i>Analytics</a></li>
            <li class="active"><a href="user.php"><i class='bx bx-group'></i>Users</a></li>
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
                        <li><a href="#">
                                <b>User</b>
                            </a></li>
                    </ul>
                </div>
            </div>
            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <h3>
                            <?php
                                 echo $row[0]+$row1[0];
                            ?>                           
                        </h3>
                        <p>Total Customer Account</p>
                    </span>
                </li>
                <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3>
                        <?php
                                 echo $row[0];
                            ?>
                        </h3>
                        <p>Active Cutomer Account</p>
                    </span>
                </li>
                <li><i class='bx bx-show-alt'></i>
                    <span class="info">
                        <h3>
                        <?php
                                 echo $row1[0];
                            ?>
                        </h3>
                        <p>Banned Customer Account</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>User Lists</h3>
                    </div>
                    
                            <?php
                                include("../connection.php");
                                $sql="select * from customer where status=1";
                
                                $r = mysqli_query($con, $sql);
                                echo "<h2>Active Users<br/></h2>";
                                if(mysqli_num_rows($r)<1){
                                    echo "No active user";
                                }else{
                                    echo "<table><thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>";
                                    while($row=mysqli_fetch_array($r)){
                                        $f_name = $row['first_name'];
                                        $l_name = $row['last_name'];
                                        $status = $row['status'];
                                        $cus_id = $row['cus_id'];
                                        // echo $cus_id;
                                        
                                        echo "<tr><td>$f_name $l_name</td><td>Active</td>
                                                <td><a href='user.php?action=block&id=$cus_id'>Block</a></td>
                                                </tr>";
                                        
                                    }
                                    echo "</table>";

                                }
                                $sql="select * from customer where status=0";
                
                                $r = mysqli_query($con, $sql);
                                echo "<h2>Block Users<br/></h2>";
                                if(mysqli_num_rows($r)<1){
                                    echo "No suspicious user";
                                }else{
                                    echo "<table><thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>";
                                    while($row=mysqli_fetch_array($r)){
                                        $f_name = $row['first_name'];
                                        $l_name = $row['last_name'];
                                        $status = $row['status'];
                                        $cus_id = $row['cus_id'];
                                        // echo $cus_id;
                                        
                                        echo "<tr><td>$f_name $l_name</td><td style='color:red;'>Banned</td>
                                                <td><a href='user.php?action=unblock&id=$cus_id'>Unblock</a></td>
                                                </tr>";

                                        
                                        
                                    }
                                    echo "</table>";
                                }
                                // blocking user
                                if(isset($_GET['action']) and $_GET['action'] == 'block'){
                                    $cus_id = $_GET['id'];
                                    // echo $cus_id;
                                    $s = 0;
                                    $modify = "update customer SET status=0 where cus_id = '$cus_id'";
                                    if(mysqli_query($con,$modify) )
                                        echo "<script>alert('User blocked!!')</script>";
                                    echo "<script>window.location='user.php'</script>";  
                                }

                                // unblocking user
                                if(isset($_GET['action']) and $_GET['action'] == 'unblock'){
                                    $cus_id = $_GET['id'];
                                    $modify = "update customer set status=1 where cus_id = '$cus_id'";
                                    if(mysqli_query($con,$modify) )
                                        echo "<script>alert('User unblocked!!')</script>";
                                    echo "<script>window.location='user.php'</script>";  
                                }
                            ?>
                </div>

            </div>

        </main>

    </div>
</body>

</html>