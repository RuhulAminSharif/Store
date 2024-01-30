<?php
    date_default_timezone_set('Asia/Dhaka');
    include("../connection.php");
    if(isset($_POST['submit'])){
        // to receive value from the input fields
        $name = $_POST['name'];
        $email = $_POST['mail'];
        $pass = $_POST['pass'];

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
        // admin id generation
        $date = date(DATE_ATOM);
        $admin_id = "admin-".$date;
        $res = str_replace( array('-','T' , ':', '+', '>' ), '', $date);
        $admin_id = "admin-".$res;
        // echo $admin_id;
        $check = "select email from admin where email='$email'";
        $r = mysqli_query($con, $check);
        $row = mysqli_fetch_array($r);
        if($row>0){
            echo "There exist account with this e-mail already. ";
            echo "Log in instead of trying to register";
        }else{
            $query="insert into admin values('$admin_id','$name','$email', '$pass', '$image',1)";
            if(mysqli_query($con, $query)){
                echo "Success";
                echo "your admin is : $admin_id";
                if($image!=null){
                    move_uploaded_file($_FILES['pic']['tmp_name'],"../Images/Admin_Image/$image");
                }
                header("Location:login.php");
            }else{
                echo "error!".mysqli_error($con);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link type="text/css" rel="stylesheet" href="CSS/signup.css">
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
        <a href="login.php" class="item" style="float:right;">
            <div class="group">
                <i class="material-icons" >
                    account_circle
                </i>
                <div class="detail">
                    Account
                    <div class="sub">
                        Sign In
                    </div>
                </div>
            </div>
        </a>
    </nav>
    <main>
        <div class="reg">
            <form action="signup.php" method="post" enctype="multipart/form-data">
                <div class="title">
                    Admin Registration
                </div>
                
                <div class="name-details">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
    
    
                <div class="e-mail">
                    <label for="mail">Email</label>
                    <input type="email" id="mail" name="mail" required>
                </div>
    
                <div class="picture">
                        <label for="pic">Picture</label>
                    <input type="file" id="pic" name="pic" required>
                </div>
    
                <div class="pass-details">
                    <label for="pass">Password</label>
                    <input type="password" id="pass" name="pass"required>
                </div>
    
                <!-- <div class="C-Pass">
                    <label for="c_pass">Confirm Password</label>
                    <input type="password" id="c_pass" name="c_pass" placeholder="Confirm password" required>
                </div> -->
    
                <div class="btn">
                    <input type="submit" value="Register" name="submit" class="submission">
                </div>
            </form>
        </div>
    </main>
    <?php
        include("footer.php");
    ?>
</body>
</html>