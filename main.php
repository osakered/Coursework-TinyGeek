<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Главная - TinyGeek</title>
    <link rel="stylesheet" href="assets/styles/MainStyles.css">
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
        <img class="imgalert" src="./assets/images/warning.webp" alt="Внимание">
        <strong>Внимание!</strong> Данный сайт разработан как курсовой проект, и магазин не является действующим! 
    </div>

    <div class="topnav">
        <a class="inactive" href="#">+7 (343) 307-37-84</a>
        <div class="topnav-right">
          <img class="locationimg" src="./assets/images/location.webp" alt="Локация">
          <a class="inactive" href="#">Екатеринбург</a>
        </div>    
    </div> 
    <div class="bottomnav">
        <img class="navlogo" src="./assets/images/logo_detailed.webp" alt="Логотип">
        <a class="inactive" href="#">TinyGeek</a>
        <a class="active" href="./main.php">Главная</a>
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

    <div class="slideshow-container">
    <div class="mySlides fade">
      <img src="./assets/images/ad_banner1.webp" style="width:100%" alt="реклама">
    </div>
    <div class="mySlides fade">
      <img src="./assets/images/ad_banner2.webp" style="width:100%" alt="реклама">
    </div>
    <div class="mySlides fade">
      <img src="./assets/images/ad_banner3.webp" style="width:100%" alt="реклама">
    </div>
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>
  <br>
  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
  </div>
  <script src="./assets/scripts/MainAdSlider.js"></script>

  <div class="chooseus">
  <h2>Почему выбирают нас</h2>
  <div class="chooseus-container">
    <div class="chooseus-block">
        <img src="./assets/images/choice.webp" alt="выбор">
        <h3>Выбор</h3>
        <p>Широкий ассортимент товаров, от умных ошейников до фруктовых книг.</p>
    </div>
    <div class="chooseus-block">
        <img src="./assets/images/rush.webp" alt="скорость">
        <h3>Скорость</h3>
        <p>Пришел, оплатил, забрал. Или дождался курьера в течении суток.</p>
    </div>
    <div class="chooseus-block">
        <img src="./assets/images/warranty.webp" alt="гарантия">
        <h3>Гарантия</h3>
        <p>Если что-то само развалилось, или вы передумали - вернем деньги.</p>
    </div>
    </div>
  </div>
  <div class="aboutus">
    <h2>О магазине</h2>
    <p>Магазин электроники TinyGeek в Екатеринбурге предлагает широкий ассортимент современных гаджетов и электроники для любителей технологий. В нашем магазине вы найдете последние модели смартфонов, ноутбуков, планшетов, а также аксессуары и комплектующие от известных брендов.</p>
    <p>TinyGeek гордится высоким уровнем обслуживания клиентов и профессиональной консультацией. Наши сотрудники всегда готовы помочь вам выбрать подходящее устройство, исходя из ваших потребностей и бюджета.</p>
    <p>Кроме того, мы регулярно проводим акции и распродажи, чтобы сделать покупки еще более выгодными. У нас также есть возможность онлайн-заказа с доставкой по городу.</p>
    <p>Приходите в TinyGeek и откройте для себя мир высоких технологий!</p>
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