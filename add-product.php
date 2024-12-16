<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавить товар - TinyGeek</title>
    <link rel="stylesheet" href="assets/styles/AdminPanelStyles.css">
    <link rel="icon" href="assets/images/logo_icon.webp">
</head>
<?php 
    include_once('assets/scripts/db_connect.php');

    try {
        $conn = new PDO('mysql:host=localhost;dbname=cursed', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) {
        die("Ошибка подключения: " . $e->getMessage());
    }

    session_start();

    if (isset($_SESSION['login']))
    {
        $login = $_SESSION['login'];
        $sql = "SELECT * FROM Users WHERE login = '".$_SESSION['login']."'";
        $result = mysqli_query($link, $sql);
        $roledata = mysqli_fetch_all($result);
        $role = $roledata[0][5];
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

    if (isset($_POST['add-product-button']))
    {
        $idCategory = $_POST['select-category'];
        $ProductName = strval($_POST['add-prod-name']);
        $ProductImage = $_FILES['add-prod-image']['tmp_name'];
        $filedata = file_get_contents($ProductImage);     
        $ProductPrice = intval($_POST['add-prod-price']); 
        $ProductDesc = strval($_POST["add-prod-desc"]);

        $stmt = $conn->prepare("INSERT INTO Products (`idCategory`, `ProductName`, `ProductImage`, `ProductPrice`, `ProductDesc`) 
        VALUES (:IDcategory, :ProdName, :ProdImage, :ProdPrice, :ProdDesc)");

        $stmt->bindValue(':IDcategory', $idCategory, PDO::PARAM_INT);
        $stmt->bindValue(':ProdName', $ProductName, PDO::PARAM_STR);
        $stmt->bindValue(':ProdImage', $filedata, PDO::PARAM_LOB);
        $stmt->bindValue(':ProdPrice', $ProductPrice, PDO::PARAM_INT);
        $stmt->bindValue(':ProdDesc', $ProductDesc, PDO::PARAM_STR);
        

        if ($stmt->execute()) {
            echo 'Товар добавлен';
        } else {
            echo 'Ошибка: ' . implode(", ", $stmt->errorInfo());
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
    <h1 class="admin-header">Добавление товара</h3>
    </div>
    
    <div class="add-prod-container">
        <div class="add-prod">
            <form method="POST" enctype="multipart/form-data">
            <input type="text" name="add-prod-name" class="add-prod-name" required placeholder="Название товара">
            <input type="text" name="add-prod-price" class="add-prod-price" required placeholder="Цена товара">
            <label class="input-file">
                <input type="file" name="add-prod-image" class="add-prod-image" required>
                <span class="choose-img">Выберите изображение</span>
            </label>
            <label class="label-description">Описание товара</label>
            <textarea name="add-prod-desc" class="add-prod-desc"  required></textarea>
            <label>Категория</label>
            <select name="select-category" class="select-category">
                <?php
                $sql = "SELECT * FROM Categories";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($array as $item)
                {
                    echo '<option value="'.$item['idCategory'].'">'.$item['CategoryName'].'</option>';
                } 
                ?>
            </select>
            <input type="submit" value="Добавить" name="add-product-button" class="add-product-button">
            </form>
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