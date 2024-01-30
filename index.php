<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eleve∞ | Home page</title>
    <style>
        .product-show{
            display: flex;
        }
        .product{
            display: block;
            margin: 25px;
            border-style: solid;
            border-radius : 15px;
            padding: 20px;
        }
        .title{
            font-size: 16px;
            font-weight: bold;
        }
        .price{
            color: rgb(0,118,0);
            font-weight: bold;
        }
        .cart-button{
            background-color: rgb(249,217,76);
            border: none;
            height: 30px;
            width: 140px;
            border-radius: 15px;
            margin-right: 8px;
            cursor: pointer;
        }
        .pic{
            border-radius:15px;
        }
    </style>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Admin/CSS/admin-profile.css">
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
    <!-- <img src="Images/login_background.jpg" alt=""> -->
    <main>

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <h1>Product Lists</h1>
                        <p>you need to log in to add products in cart or to buy</p>
                        <p> the cart button won't work until you log in </p>
                    </div>
                    <form action='index.php' method='post'>
                    <?php
                            include("connection.php");
                            $sql = "select distinct(ptype) from product";
                            $r = mysqli_query($con, $sql);
                            while($row=mysqli_fetch_array($r)){
                                echo "<h2 align='center'>$row[0]</h2>"; // $row[0] -> product type

                                $sql1 = "select distinct(brand_name) from product where ptype = '$row[0]'";
                                $r1 = mysqli_query($con, $sql1); 
                                while($row1=mysqli_fetch_array($r1)){
                                    echo "<h4 align='left'>Product brand : $row1[0]</h4>";
                                    $sql2 = "select * from product natural join product_line where product.ptype='$row[0]' && product.brand_name='$row1[0]' and quantity>0";
                                    $r2 = mysqli_query($con, $sql2);
                                    echo "<div class='product-show'>";
                                    while($row2=mysqli_fetch_array($r2)){
                                        $id = $row2['product_id'];
                                        $name = $row2['product_name'];
                                        $pic = $row2['pic'];
                                        $price = $row2['selling_price'];
                                        $quantity = $row2['quantity'];
                                        echo "<div class='product'>";
                                        echo "<img class='pic' width='100px' height='100px' src='Images/Product_Image/$pic'><br>";
                                        echo "<p class='title'>$name</p>";
                                        echo "<p class='price'>BDT. $price - in stock</p>";
                                    
                                        echo "<input class='cart-button' type='button' value='Add to cart' name='$id'>";
                                        echo "</div>";
                                    
                                    } 
                                    echo "</div>";
                                }
                            }
                    ?>
                    </form>
                    
                </div>

            </div>

        </main>
    <?php
        include("footer.php");
    ?>
</body>
</html>