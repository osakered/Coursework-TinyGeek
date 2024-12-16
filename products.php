<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Все товары - TinyGeek</title>
    <link rel="stylesheet" href="assets/styles/AllProductsStyles.css">
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
    <h1 class="categories-header">Все товары</h3>


    <?php
    include ('assets/scripts/array_paginator.php');
    $url = '/cursed/products.php'; 
    $paginator = new ArrayPaginator($url, 4); 

    $sql = "SELECT * FROM Products";
    $result = $link->query($sql);
    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $data = $array;
    $paginator->setItems($data);

    $items = $paginator->getItems();
    ?>

    <select class="filter-select" name="filters" id="shop_filters">
        <?php
            $selectedFilter = isset($_GET['selected']) ? $_GET['selected'] : '1';
        ?>
        <option value="1" <?php echo $selectedFilter == '1' ? 'selected' : ''; ?>>Без фильтров</option>
        <option value="2" <?php echo $selectedFilter == '2' ? 'selected' : ''; ?>>По возрастанию цены</option>
        <option value="3" <?php echo $selectedFilter == '3' ? 'selected' : ''; ?>>По убыванию цены</option>
        <option value="4" <?php echo $selectedFilter == '3' ? 'selected' : ''; ?>>По алфавиту A-Z</option>
        <option value="5" <?php echo $selectedFilter == '3' ? 'selected' : ''; ?>>По алфавиту Z-A</option>
    </select>

    <script>
        document.getElementById('shop_filters').addEventListener('change', function () {
            const selectedValue = this.value;
            if (selectedValue) {
                const url = `products.php?selected=${encodeURIComponent(selectedValue)}`;
                window.location.href = "./" + url;
            }
        });
    </script>

    <?php
    session_start();
    @$_SESSION['selected_filter'] = $_GET['selected'];

    if ($_SESSION['selected_filter'] == 1) {
        $sql = "SELECT * FROM `Products`";
        $result = $link->query($sql);
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $paginator->setItems($array);
        $items = $paginator->getItems();
    }

    if ($_SESSION['selected_filter'] == 2) {
        $sql = "SELECT * FROM `Products` order by ProductPrice ASC";
        $result = $link->query($sql);
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $data = $array;
        $paginator->setItems($data);
        $items = $paginator->getItems();
    }

    if ($_SESSION['selected_filter'] == 3) {
        $sql = "SELECT * FROM `Products` order by ProductPrice DESC";
        $result = $link->query($sql);
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $paginator->setItems($array);
        $items = $paginator->getItems();
    }

    if ($_SESSION['selected_filter'] == 4) {
        $sql = "SELECT * FROM `Products` order by ProductName ASC";
        $result = $link->query($sql);
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $paginator->setItems($array);
        $items = $paginator->getItems();
    }

    if ($_SESSION['selected_filter'] == 5) {
        $sql = "SELECT * FROM `Products` order by ProductName DESC";
        $result = $link->query($sql);
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $paginator->setItems($array);
        $items = $paginator->getItems();
    }

    foreach ($items as $item) {
        if (isset($_POST['buy_product' . $item['idProduct']])) {
            session_start();
            $_SESSION['id_product'] = $item['idProduct'];
            header("Location:http://localhost/cursed/product.php");
        }
    }
    ?>

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
            echo '<div class="product-block-button">
                <input type="submit" class="product-button" value="Просмотр товара" name="buy_product' . $item['idProduct'] . '"">
            </div>
        </div>';
        }
        ?>
    </div>
    <?php
    echo $paginator->renderPagination();
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