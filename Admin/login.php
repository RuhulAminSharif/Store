<?php
    date_default_timezone_set('Asia/Dhaka');
    session_start();
    include("../connection.php");
    if(isset($_POST['login'])){
        $id = $_POST['id'];
        $pass = $_POST['pass'];
        
        $sql="select * from admin where (email = '$id' or admin_id='$id') and password = '$pass'";

        $r = mysqli_query($con, $sql);

        if(mysqli_num_rows($r)>0){
            $row = mysqli_fetch_array($r);
            $admin_id = $row['admin_id'];
            $email = $row['email'];
            $status = $row['status'];
            
            if($status==0){
                header("Location:invalid-admin.php");
            }else{
                $_SESSION['user_id']=$admin_id;
                $_SESSION['admin_login_status']="loged in";
                header("Location: admin-profile.php");
            }
        }else{
            echo "<script>alert('Incorrect username or password')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Log in</title>
    <link type="text/css" rel="stylesheet" href="CSS/login.css">
    <link type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="CSS/header.css">
    <link type="text/css"
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" 
        referrerpolicy="no-referrer"
    />
</head>
<body>
    <nav class="navbar">
        <a href="#" class="item">
            <div class="group">
                <i class="material-icons" >
                    home
                </i>
                <div class="detail">
                    Home
                </div>
            </div>
        </a>
        <a href="signup.php" class="item" style="float:right;">
            <div class="group">
                <i class="material-icons" >
                    account_circle
                </i>
                <div class="detail">
                    Account
                    <div class="sub">
                        Sign Up
                    </div>
                </div>
            </div>
        </a>
    </nav>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="login.php" method="post">
                    <h2>Login</h2>
                    <div class="user-id">
                        <object data="SVG/mail.svg" type=""></object>
                        <input type="text" id="id" name="id" required>
                        <span></span>
                        <label for="id">User Mail/ID</label>
                    </div>

                    <div class="pass-details">
                        <object data="SVG/lock.svg" type=""></object>
                        <input type="password" id="pass" name="pass" required>
                        <span></span>
                        <label for="pass">Password</label>
                    </div>

                    <div class="forget-pass">
                        <a href="#">Forget your Password?</a>
                    </div>

                    <div class="submission">
                        <input type="submit" value="Log in" name="login">
                    </div>

                    <div class="signup_link">
                        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php
        include("footer.php");
    ?>
</body>
</html>