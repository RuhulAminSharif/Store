<?php
    date_default_timezone_set('Asia/Dhaka');
    include("connection.php");
    if(isset($_POST['submit'])){
        // to receive value from the input fields
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $email = $_POST['mail'];
        $loc = $_POST['loc'];
        $mobile = $_POST['mobile'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
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
        // customer id generation
        $date = date(DATE_ATOM);
        $res = str_replace( array('-','T' , ':', '+', '>' ), '', $date);
        $cus_id = "c-".$res;
        // echo $cus_id;
        $check = "select email from customer where email='$email'";
        $r = mysqli_query($con, $check);
        $row = mysqli_fetch_array($r);
        if($row>0){
            echo "<script>alert('There exist account with this e-mail already.')</script>";
        }else{
            $query="insert into customer values('$cus_id','$f_name', '$l_name', '$email', '$pass', '$loc', '$mobile' ,'$dob', '$gender','$image',1)";
            if(mysqli_query($con, $query)){
                echo "Success";
                if($image!=null){
                    move_uploaded_file($_FILES['pic']['tmp_name'],"Images/Customer_Image/$image");
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
    <title> Eleve∞ | Customer Registration</title>
    <link type="text/css" rel="stylesheet" href="CSS/signup.css">
    <link type="text/css" rel="stylesheet" href="CSS/header.css">
    <link type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
    <section>
        <div class="reg">
            <form action="signup.php" method="post" enctype="multipart/form-data">
                <div class="title">
                    Registration
                </div>
                
                <div class="name-details">
                    <label for="f_name">First Name</label>
                    <input type="text" id="f_name" name="f_name" required>
                </div>
    
                <div class="name-details">
                    <label for="l_name">Last Name</label>
                    <input type="text" id="l_name" name="l_name" required>
                </div>
    
                <div class="e-mail">
                    <object data="SVG/mail.svg" type=""></object>
                    <label for="mail">Email</label>
                    <input type="email" id="mail" name="mail" required>
                </div>
    
                <div class="location">
                    <label for="location">Location</label>
                    <select id="country" name="loc">
                        <option value="" disabled selected> </option>
                        <option value="dhaka">Dhaka</option>
                        <option value="chittagong">Chittagong</option>
                        <option value="khulna">Khulna</option>
                    </select>
                </div>
    
                <div class="contact">
                    <label for="mobile">Mobile number:</label>
                    <input type="tel" id="mobile" name="mobile" required>
                </div>
    
                <div class="date-of-birth">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
    
                <div class="gender-details">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="" disabled selected></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
    
                <div class="picture">
                    <label for="pic">Picture</label>
                    <input type="file" id="pic" name="pic" required>
                </div>
    
                <div class="pass-details">
                    <object data="SVG/lock.svg" type=""></object>
                    <label for="pass">Password</label>
                    <input type="password" id="pass" name="pass" required>
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
    </section>
    <!-- <?php
        // include("footer.php");
    ?> -->
</body>
</html>