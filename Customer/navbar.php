<?php
//    session_start();
   if($_SESSION['customer_login_status']!="loged in" and ! isset($_SESSION['user_id']) )
    header("Location:../index.php");
   
   if(isset($_GET['sign']) and $_GET['sign']=="out") {
	$_SESSION['customer_login_status']="loged out";
	unset($_SESSION['user_id']);
   header("Location:../index.php");    
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    
        <i class="material-icons menu-icon">
          menu
        </i>
        <div class="logo">
            <img src="SVG/logo.svg" alt="logo">
            <div class="text">    
                Eleve∞
            </div>
        </div>
        <div class="item search right" tabindex="0">
            <div class="search-group">
                <select>
                    <option value="all">All</option>
                    <option value="desktop">Desktop</option>
                    <option value="laptop">Laptop</option>
                    <option value="mobile">mobile</option>
                </select>
                <input type="text">
                    <i class="material-icons search-icon">
                        search
                    </i>
            </div>
        </div>
        
        <a href="home.php" class="item">
            <div class="group">
                <i class="material-icons" >
                    home
                </i>
                <div class="detail">
                    Home
                </div>
            </div>
        </a>
        <a href="login.php" class="item">
            <div class="group">
                <img width="25px" src="../Images/Customer_Image/a0cbb6faecb49d6ae9c67a230738dea0.jpg" alt="">
                <div class="detail">
                    Account
                </div>
            </div>
        </a>
      
        <a href="#" class="item">
            <div class="group">
                <i class="material-icons">
                    shopping_cart
                </i>  
                <div class="detail">
                    Cart 
                    <div class="sub">
                        BDT 0.0
                    </div>
                </div>
            </div>
        </a>
    </nav>
</body>
</html>