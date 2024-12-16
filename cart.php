<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Корзина - TinyGeek</title>
    <link rel="stylesheet" href="assets/styles/CartStyles.css">
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

    $sql = "SELECT * FROM ShoppingCart where idUser = ".$_SESSION['idUser']."";
    $result = $link->query($sql);
    $array_cart = mysqli_fetch_all($result,MYSQLI_ASSOC);

    $array_products = [];

    foreach ($array_cart as $var)
    {
    $sql = "SELECT * FROM Products WHERE idProduct = ".$var['idProduct']."";
    $result = $link->query($sql);
    $array = mysqli_fetch_array($result);
    $array['Quantity'] = $var['Quantity'];
    array_push($array_products,$array);
    }

    foreach ($array_products as $var)
    {
        @$totalprice += $var['ProductPrice'] * $var['Quantity'];
    }

    if ($totalprice == null)
    {
        $totalprice = 0;
    }
  }

    if (isset($role)) {
      if ($role !== 'Client') {
          header('Location: access_denied.php');
          exit();
      }
    } else {
        header('Location: entry.php');
        exit();
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
        <a href="./products.php">Все продукты</a>
        <a href="./categories.php">Категории</a>
        <a href="./contacts.php">Контакты</a>
        <div class="topnav-right">
          <?
            if(isset($role)) {
            if ($role == 'Admin') {
              echo '<a href="./admin-panel.php">Администрирование</a>';
              echo '<a href="./log-out.php">Выход</a>';
            } elseif ($role == 'Client') {
              echo '<a class="active" href="./cart.php">Корзина</a>';
              echo '<a href="./log-out.php">Выход</a>';
            } 
            } 
            else {
              echo '<a href="./entry.php">Войти</a>';
            }
          ?>
        </div>
    </div> 

    <div class="cart-list">
    <?php 
    foreach($array_products as $var) 
    {
        if (isset($_POST["del_product".$var['idProduct'].""]))
        {
            $sql = "DELETE FROM ShoppingCart where idProduct = ".$var['idProduct']." and idUser = ".$_SESSION['idUser']."";
            $result = mysqli_query($link,$sql);
            header("Refresh:0");
        }
        if (isset($_POST["update_product".$var['idProduct'].""]))
        {
            $newQuantity = $_POST['quantity' . $var['idProduct']];

            $sql = "UPDATE ShoppingCart SET Quantity = " . intval($newQuantity) . " WHERE idProduct = " . intval($var['idProduct']) . " AND idUser = " . intval($_SESSION['idUser']);
            $result = mysqli_query($link,$sql);
            header("Refresh:0");
        }
    }
    foreach ($array_products as $var) 
    {
        echo '<form method = "POST">';
        echo '<div class="product-block">';
            echo '<div>';
            echo '<img class="product-block-image" src="data:image/png;base64,'.base64_encode($var['ProductImage']).'">';
            echo '</div>';
            echo '<div class="product-info">';
            echo '<div >
            <p class="product-block-name">'.$var["ProductName"].'</p>';	
            echo '<p class="product-block-quantity">Количество: <input type="number" class="quantity-input-number" name="quantity' . $var['idProduct'] . '" value="'.$var['Quantity'].'" min="1"></p>';		
            echo '</div>';
            echo '<p class="product-price">Цена: '.$var['ProductPrice']*$var['Quantity'].' руб.</p>';
            echo '<div class="product-input">
            <input type="submit" class="product-button" value="Обновить кол-во" name="update_product' . $var['idProduct'] . '">
            <input type="submit" class="product-button" value="Удалить" name="del_product' . $var['idProduct'] . '"">
            </div></div>';
        echo '</div>';
        echo '</form>';
    }
    if ($totalprice > 0){
    echo '<p class="total-price">Итого: '.$totalprice.' руб.</p>'; 
    echo '<div class="buy"><input type="submit" class="buy-btn" value="Перейти к оформлению" onclick="alert(\'Это курсовой проект, какое оформление\')"></div>';
    }
    else
    {
        echo '<p class="total-price" style="margin-top:320px; margin-bottom:320px;">В вашей корзине пока что нет товаров.</p>';
    }
    ?>
    
    
    
<footer>
    <ul class="social">
        <li><a href="https://github.com/osakered"><img src="./assets/images/github-logo.webp" alt="Гитхаб"></a></li>
        <li><a href="https://vk.com/"><img src="./assets/images/gamno-logo.webp" alt="ВК"></a></li>
        <li><a href="https://desktop.telegram.org/"><img src="./assets/images/telegram-logo.webp" alt="Телеграм"></a></li>
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