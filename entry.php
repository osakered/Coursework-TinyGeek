<!DOCTYPE html>
<head>
  <lang="en">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Войти - TinyGeek</title>
  <link rel="stylesheet" href="assets/styles/EntryStyles.css">
  <link rel="icon" href="assets/images/logo_icon.webp" type='image/x-icon'>
  <link rel="shortcut icon" href="assets/images/logo_icon.webp" type='image/x-icon'>
</head>
<? include ('assets/scripts/db_connect.php') ?>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <h1 class="logotype">TinyGeek</h1>
      <header>Вход</header>
      <form action="entry.php" method="post">
        <input type="text" name="login" placeholder="Введите логин">
        <input type="password" name="password" placeholder="Введите пароль">
        <!-- <a href="#">Забыли пароль?</a> -->
        <input type="submit" class="button" value="Войти">
      </form>
      <?php
        if (!empty($_REQUEST['login']) and !empty($_REQUEST['password']) ) {
          $login = $_REQUEST['login'];
          $password = $_REQUEST['password'];
          $query=mysqli_query($link, "SELECT * FROM Users WHERE login='".$login."'");

          $assoc = mysqli_fetch_assoc($query);
          @$passmd5 = md5($password.$assoc['salt']);
          $query = 'SELECT * FROM Users WHERE login="'.$login.'" AND password="'.$passmd5.'"';
         
          $result = mysqli_query($link, $query);
          $user = mysqli_fetch_assoc($result);
    
          if (!empty($user)) {
            session_start();
            $_SESSION['auth'] = true;
    
            $_SESSION['idUser'] = $user['idUser'];
            $_SESSION['login'] = $user['login'];
            echo $message = '<div id="success-message"><h3>Вы успешно авторизированы!</h3></div>';
            header("Location:main.php");
          } else {
            echo $message = '<div id="error-message"><h3>Неверный логин или пароль!</h3></div>';
          }
          }
      ?>
      <div class="signup">
        <span class="signup">Еще нет аккаунта?
         <label for="check">Регистрация</label>
        </span>
      </div>
    </div>

    <div class="registration form">
      <h1 class="logotype">TinyGeek</h1>
      <header>Регистрация</header>
      <form action="entry.php" method="post">
        <input type="text" name="usernamecreate" placeholder="Придумайте никнейм">
        <input type="text" name="logincreate" placeholder="Придумайте логин">
        <input type="password" name="passwordcreate" placeholder="Придумайте пароль">
        <input type="password" name="passwordcreateconf" placeholder="Повторите пароль">
        <input type="submit" class="button" name="registerbutton" value="Зарегистрироваться">
      </form>
      <?
      if(isset($_POST["registerbutton"])){
          if(!empty($_POST['usernamecreate']) && !empty($_POST['logincreate']) && !empty($_POST['passwordcreate']) && !empty($_POST['passwordcreateconf']))
          {
          if($_POST['passwordcreate'] == $_POST['passwordcreateconf'])
          {
              $username = $_POST['usernamecreate'];
              $login = $_POST['logincreate'];
              $password = $_POST['passwordcreate'];
              $query=mysqli_query($link, "SELECT * FROM Users WHERE login='".$login."'");
              $numrows=mysqli_num_rows($query);
          if($numrows==0)
          {
            @$query = mysqli_query($link, "SELECT MAX(`idUser`) FROM `Users`");
            @$lastid = mysqli_fetch_array($query);
            $newid = $lastid[0] + 1;
            $array = array('A', 'E', 'I', 'O', 'U', 'Y', 'B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Z', 
              'a', 'e', 'i', 'o', 'u', 'y', 'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'z');
            $salt = $array[mt_rand(0,sizeof($array)-1)].$array[mt_rand(0,sizeof($array)-1)].$array[mt_rand(0,sizeof($array)-1)]
              .$array[mt_rand(0,sizeof($array)-1)].$array[mt_rand(0,sizeof($array)-1)];
            $passmd5 = md5($password.$salt);
            $role = "Client";
            $sql="INSERT INTO Users(username, login, password, salt, role) VALUES('$username','$login','$passmd5','$salt','$role')"; 
            $result=mysqli_query($link,$sql);
          
          if($result)
          {
            echo $message='<div id="success-message"><h3>Пользователь добавлен!</h3></div>';
          }
          else
          {
            echo $message='<div id="error-message"><h3>Пользователь не был добавлен!</h3></div>';
          }
        }else
          {
            echo $message='<div id="error-message"><h3>Пользователь уже существует!</h3></div>';
          }
          }
          else
          {
            echo $message='<div id="error-message"><h3>Пароли не совпадают!</h3></div>';
          }
        }
          else 
          {
              echo $message='<div id="error-message"><h3>Поля не заполнены!</h3></div>';
          }
      }
      ?>
      <div class="signup">
        <span class="signup">Уже есть аккаунт?
         <label for="check">Войти</label>
        </span>
      </div>
    </div>
  </div>
</body>
</html>

