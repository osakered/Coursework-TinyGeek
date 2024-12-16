<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Категории - TinyGeek</title>
    <link rel="stylesheet" href="assets/styles/CategoriesStyles.css">
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
        <a class="active" href="./categories.php">Категории</a>
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

    <h1 class="categories-header">Все категории товаров</h3>
    <div class="categories-container">
        <div class="category-block">
            <a href="headphones.php"><img src="./assets/images/category-headphones.webp"><p>Наушники</p></a>
        </div>
        <div class="category-block">
            <a href="laptops.php"><img src="./assets/images/category-laptop.webp"><p>Ноутбуки</p></a>
        </div>
        <div class="category-block">
            <a href="phones.php"><img src="./assets/images/category-smartphone.webp"><p>Телефоны</p></a>
        </div>
        <div class="category-block">
            <a href="tablets.php"><img src="./assets/images/category-tablet.webp"><p>Планшеты</p></a>
        </div>
        <div class="category-block">
            <a href="watches.php"><img src="./assets/images/category-watch.webp"><p>Часы</p></a>
        </div>
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