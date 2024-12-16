<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Контакты - TinyGeek</title>
    <link rel="stylesheet" href="assets/styles/ContactsStyles.css">
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
        <a href="./categories.php">Категории</a>
        <a class="active" href="./contacts.php">Контакты</a>
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

    
 

    <div class="contacts-container">
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d34947.08168962466!2d60.582134577832036!3d56.80832614866215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x43c16ef278826bc7%3A0xc81b0908919e1ad0!2z0KLQoNCmIMKr0JPRgNC40L3QstC40YfCuw!5e0!3m2!1sru!2sru!4v1733650186245!5m2!1sru!2sru" 
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="contact-info">
            <h1>Контактная информация</h1>
            <h2>Телефон: +7 (343) 307-37-84</h2>
            <h2>Email: Tinygeek@gmail.com</h2>
            <h2>Адрес: г. Екатеринбург, ул. 8 Марта, 46</h2>
            <h2>Время работы:</h2>
            <h2>Пн-Пт 10:00-21:00</h2>
            <h2>Сб-Вс 10:00-19:00</h2>
        </div>
    </div>

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