<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Товар - TinyGeek</title>
    <link rel="stylesheet" href="assets/styles/ProductStyles.css">
    <link rel="icon" href="assets/images/logo_icon.webp">
</head>
<?php 
  include('assets/scripts/db_connect.php');

  session_start();

  if (isset($_SESSION['login']))
  {
    $login = $_SESSION['login'];
    $sql = "SELECT * FROM Users WHERE login = '".$_SESSION['login']."'";
    $result = mysqli_query($link, $sql);
    $roledata = mysqli_fetch_all($result);
    $role = $roledata[0][5];

    $sql = "SELECT * FROM Reviews WHERE idProduct = ".$_SESSION['id_product']."";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result,MYSQLI_ASSOC);

    if (count($data)>0){
        $rating = 0;
        $count = count($data);
        foreach ($data as $row) {
           $rating += $row['Rate'];
        }
        $rating = $rating / $count;
    }
    if (@$count == null)
    {
        $count = 0;
    }
  }
?>
<body>
    <div class="alert">
        <span class="closealert" onclick="this.parentElement.style.display='none';">&times;</span> 
        <img class="imgalert" src="./assets/images/warning.webp">
        <strong>Внимание!</strong> Данный сайт разработан как курсовой проект, и магазин не является действующим! 
    </div>

    <div class="topnav">
        <a class="inactive" href="#">+7 (343) 307-37-84</a>
        <div class="topnav-right">
          <img class="locationimg" src="./assets/images/location.webp">
          <a class="inactive" href="#">Екатеринбург</a>
        </div>    
    </div> 
    <div class="bottomnav">
        <img class="navlogo" src="./assets/images/logo_detailed.webp">
        <a class="inactive" href="#">TinyGeek</a>
        <a href="./main.php">Главная</a>
        <a class="active" href="./products.php">Все продукты</a>
        <a href="./categories.php">Категории</a>
        <a href="./contacts.php">Контакты</a>
        <div class="topnav-right">
          <?
            if(isset($role)) {
            if ($role == 'Admin') {
              echo '<a href="./admin-panel.php">Администрирование</a>';
              echo '<a href="./log-out.php">Выход</a>';
            } elseif ($role == 'Client') {
              echo '<a href="./cart.php">Корзина</a>';
              echo '<a href="./log-out.php">Выход</a>';
            } 
            } 
            else {
              echo '<a href="./entry.php">Войти</a>';
            }
          ?>
        </div>
    </div> 


    <?php 
    
    $sql = "SELECT * FROM Products WHERE idProduct = ".$_SESSION['id_product']."";
    $result = mysqli_query($link, $sql);
    $array = mysqli_fetch_all($result,MYSQLI_ASSOC);


    foreach ($array as $item) 
    {
        echo '<form method = "POST">';
        echo '<div class="product-block">';
        echo '<div>';
        echo '<div>';
        echo '<img class="product-block-image" src="data:image/png;base64,'.base64_encode($item['ProductImage']).'">';
        echo '</div>';
        echo '</div>';
        echo '<div>';
        echo '<div class="product-block-name">';
        echo '<p>'.$item["ProductName"].'</p>';
        echo '</div>';	
    ?>

    <div class="stars-total">
        <span class="<?php if (ceil($rating) >= 1) echo 'active'; ?>"></span>	
        <span class="<?php if (ceil($rating) >= 2) echo 'active'; ?>"></span>    
        <span class="<?php if (ceil($rating) >= 3) echo 'active'; ?>"></span>  
        <span class="<?php if (ceil($rating) >= 4) echo 'active'; ?>"></span>    
        <span class="<?php if (ceil($rating) >= 5) echo 'active'; ?>"></span>
        <p><?php 
        if (isset($_SESSION['login'])){
            echo 'Отзывов: '.$count.'' ;
        }
        else
        {
            echo 'Войдите для просмотра рейтинга';
        }
        ?></p>
    </div>
               
    <?php
        echo '<div class="product-details">';
        echo '<p class="product-desc">'.$item["ProductDesc"].'</p>';
        echo '<div class="product-price">'
        .(int)$item["ProductPrice"].' руб
        </div>';
        echo '<div class="product-block-btn">
        <input type="submit" class="add-to-cart" value="В корзину" name="buy_product'.$item['idProduct'].'"">
        </div>';
        echo '</div></div></div>';
        }
        if (isset($_SESSION['idUser']))
        {
        echo '
        <div class="write-review">
        <h3>Напишите отзыв о продукте</h3>
        <form method="POST">
            <div class="rating-block">
            <input type="radio" id="star-5" name="rating" value="5">
            <label for="star-5" title="Оценка «5»"></label>	

            <input type="radio" id="star-4" name="rating" value="4">
            <label for="star-4" title="Оценка «4»"></label>    

            <input type="radio" id="star-3" name="rating" value="3">
            <label for="star-3" title="Оценка «3»"></label> 

            <input type="radio" id="star-2" name="rating" value="2">
            <label for="star-2" title="Оценка «2»"></label> 

            <input type="radio" id="star-1" name="rating" value="1">
            <label for="star-1" title="Оценка «1»"></label>
            </div>

            <textarea name="text" class="review_textarea"></textarea>
            <input type="submit" name="button_submit" value="Отправить">
        </form>
        </div>';
        }
    ?>
    <?if (isset($_SESSION['login'])){?>
    <?php foreach ($data as $row): ?>
    <div class="users-review">
        <p>Пользователь: <?
        $sql = "SELECT * FROM Users where idUser = ".$row['idUser']."";
        $result = mysqli_query($link,$sql);
        $array_user = mysqli_fetch_array($result);

        echo $array_user['username']; ?></p>

        <div class="stars-user">
            <span class="<?php if ($row['Rate'] >= 1) echo 'active'; ?>"></span>	
            <span class="<?php if ($row['Rate'] >= 2) echo 'active'; ?>"></span>    
            <span class="<?php if ($row['Rate'] >= 3) echo 'active'; ?>"></span>  
            <span class="<?php if ($row['Rate'] >= 4) echo 'active'; ?>"></span>    
            <span class="<?php if ($row['Rate'] >= 5) echo 'active'; ?>"></span>
        </div>

        <p class="summary"><?php echo $row['Summary']; ?></p>	
    </div>
    <?php endforeach; ?>

    <?php
    $add = true;

    if (isset($_POST['buy_product'.$item['idProduct']]))
        {
            if (isset($_SESSION['idUser']))
            {
            $sql = "SELECT * FROM ShoppingCart where idUser = ".$_SESSION['idUser']."";
            $result = $link->query($sql);
            $array_cart = mysqli_fetch_all($result,MYSQLI_ASSOC);
            foreach ($array_cart as $var)
            {
                if ($var['id_user'] == $_SESSION['idUser'] && $var['id_product'] == $item['idProduct'])
                {
                    $add = false;
                    $addcount = $var['Quantity'];
                }
            }
            if ($add == true)
                {
                    $sql="INSERT INTO ShoppingCart(idProduct,idUser, Quantity) VALUES(".$item['idProduct'].",".$_SESSION['idUser'].", 1)";
                    $result=mysqli_query($link,$sql);
                }
            else
                {
                    $count = $addcount + 1;
                    $sql="UPDATE `ShoppingCart` SET `Quantity` = $count where id_user = ".$_SESSION['idUser']." and idProduct = ".$item['idProduct']."";
                    $result=mysqli_query($link,$sql);
                }
            }
            else
            {
                header("Location: auth.php");
            }
        }

    if (isset($_POST['button_submit']) && isset($_POST['text']) && isset($_POST['rating']))
    {
        $rating = intval($_POST['rating']);
        $text = $_POST['text'];
        $id_user = $_SESSION['idUser'];
        $id_product = $_SESSION['id_product'];

        $sql="INSERT INTO Reviews(`Summary`, `Rate`, `idUser`, `idProduct`) VALUES ('".$text."',$rating,$id_user,$id_product)";
        $result=mysqli_query($link,$sql);
    }
    ?>
    <?}?>

<footer>
    <ul class="social">
        <li><a href="https://github.com/osakered"><img src="./assets/images/github-logo.webp"></a></li>
        <li><a href="https://vk.com/wall-198181079_550067"><img src="./assets/images/gamno-logo.webp"></a></li>
        <li><a href="https://desktop.telegram.org/"><img src="./assets/images/telegram-logo.webp"></a></li>
        
    </ul>
    <ul class="menu">
        <li></li>
        <li><a href="./main.php">Главная</a></li>
        <li><a href="./products.php">Продукты</a></li>
        <li><a href="./categories.php">Категории</a></li>
        <li><a href="./contacts.php">Контакты</a></li>
    </ul>
    <p>©2024-2025 Site by Osakered | No Rights Reserved</p>
</footer>
</body>
</html>