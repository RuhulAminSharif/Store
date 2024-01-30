<?php
    date_default_timezone_set('Asia/Dhaka');
    session_start();
    include("connection.php");
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        
        $sql="select * from customer where email = '$email' and password = '$pass' and status=1";

        $r = mysqli_query($con, $sql);

        if(mysqli_num_rows($r)>0){
            $row = mysqli_fetch_array($r);
            $_SESSION['ID']  = $email;
            $_SESSION['profile'] = $row['pic'];
            $_SESSION['customer_login_status']="loged in";
            header("Location: Customer/home.php");
        }else{
            $sql1="select * from customer where email = '$email' and password = '$pass' and status=0";
            $r1 = mysqli_query($con, $sql1);
            if(mysqli_num_rows($r1)>0){
                echo "<script>alert('Blocked user')</script>";
                echo "<script>window.location='login.php'</script>";  
            }
            else{
                echo "<script>alert('Incorrect username or password')</script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eleve∞ | Log in</title>
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
        <a href="index.php" class="item">
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
                        <input type="text" name="email" required>
                        <span></span>
                        <label for="email">User Mail</label>
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