<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Панель управления - TinyGeek</title>
    <link rel="stylesheet" href="assets/styles/AdminPanelStyles.css">
    <link rel="icon" href="assets/images/logo_icon.webp">
</head>
<?php 
  include('assets/scripts/db_connect.php');

  session_start();
  $_SESSION['prev_url'] = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

  if (isset($_SESSION['login']))
  {
    $login = $_SESSION['login'];
    $sql = "SELECT * FROM Users WHERE login = '".$_SESSION['login']."'";
    $result = mysqli_query($link, $sql);
    $roledata = mysqli_fetch_all($result);
    $role = $roledata[0][5];
  }
  $sql = "SELECT * FROM Products";
  $result = mysqli_query($link, $sql);
  $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($items as $item)
    {
        if (isset($_POST['edit_product'.$item['idProduct']])) 
        {
            header("Location: edit-product.php?id=" . urlencode($item['idProduct']));
            exit;
        }
    }
    foreach ($items as $item)
    {
        if (isset($_POST['delete_product' . $item['idProduct']])) {
            $sql = "DELETE FROM `Products` WHERE idProduct = ".$item['idProduct']."";
            $result = mysqli_query($link, $sql);
            header("Refresh:0");
        }
    }

    if (isset($role)) {
      if ($role !== 'Admin') {
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
              echo '<a class="active" href="./admin-panel.php">Администрирование</a>';
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

    <div class="product-add-block">
    <h1 class="admin-header">Панель управления</h3>
    <a href="add-product.php" class="product-button-add">Добавить товар</a>  
    </div>
    
    <div class="product-container" id="products-list">
        <?php
        foreach ($items as $item) {
            echo '<form method = "POST">';
            echo '<div class="product-block">';
            echo '<div class="product-block-image">';
            echo '<img alt="товар" src="data:image/webp;base64,' . base64_encode($item['ProductImage']) . '" height="300px" width="300px">';
            echo '</div>';
            echo '<div class="product-block-name">';
            echo '<p>' . $item["ProductName"] . '</p>';
            echo '</div>';
            echo '<div class="product-block-price">'
                . (int)$item["ProductPrice"] . ' руб.
            </div>';

            echo '<div class="product-plock-edit">
            <input type="submit" class="product-button" value="Редактировать" name="edit_product'.$item['idProduct'].'">
            </div>
            <div class="product-block-delete">
                <input type="submit" class="product-button" value="Удалить" name="delete_product' . $item['idProduct'] . '">
            </div>
        </div>';
        }
        ?>
    </div>
    
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