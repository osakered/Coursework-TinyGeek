<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ошибка - TinyGeek</title>
    <link rel="icon" href="assets/images/logo_icon.webp">
</head>
<? 
include('assets/scripts/db_connect.php');
session_start();
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Doto&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Roboto", sans-serif;
  font-weight: 400;
  font-style: normal;
}
body {
  background: radial-gradient(at bottom right, #fdfdfd 0, #fdfdfd 8px, 
  rgba(253,253,253,0.2) 8px, rgba(253,253,253,0.2) 16px, rgba(253,253,253,0.75) 16px, rgba(253,253,253,0.75) 24px, 
  rgba(253,253,253,0.25) 24px, rgba(253,253,253,0.25) 32px, rgba(253,253,253,0.3) 32px, rgba(253,253,253,0.3) 40px, 
  rgba(253,253,253,0.75) 40px, rgba(253,253,253,0.75) 48px, rgba(253,253,253,0.2) 48px, rgba(253,253,253,0.2) 56px, 
  transparent 56px, transparent 64px), 
  radial-gradient(at top left, transparent 0, transparent 8px, rgba(253,253,253,0.2) 8px, rgba(253,253,253,0.2) 16px,
  rgba(253,253,253,0.75) 16px, rgba(253,253,253,0.75) 24px, rgba(253,253,253,0.3) 24px, rgba(253,253,253,0.3) 32px,
  rgba(253,253,253,0.25) 32px, rgba(253,253,253,0.25) 40px, rgba(253,253,253,0.75) 40px, rgba(253,253,253,0.75) 48px,
  rgba(253,253,253,0.2) 48px, rgba(253,253,253,0.2) 56px, #fdfdfd 56px, #fdfdfd 64px, transparent 64px, transparent 160px);
  background-blend-mode: multiply;
  background-size: 64px 64px, 64px 64px;
  background-color: #f2f2f2;
}
.logotype {
  font-size: 5rem;
  font-weight: 500;
  text-align: center;
  margin-bottom: 1.5rem;
  font-family: "Doto", sans-serif;
  font-weight: 900;
  font-style: normal;
  font-variation-settings: "ROND" 0;
}
h1 {
  color:black;
  margin-top:1%;
  margin-bottom:1%;
  font-size: 50px;
}
a {
  color:#277adc;
  margin-top:1%;
  margin-bottom:1%;
}
p {
  color: black;
  margin-top:1%;
  margin-bottom:1%;
}
strong {
  font-weight:1000;
  color:#277adc;
}
.redir {
  margin-top:10%;
  text-align: center;
}
</style>
<body>
  <div class="redir">
    <h1 class="logotype">TinyGeek</h1>
    <h1>Ошибка <strong>404</strong></h1>
    <p>Страница не найдена</p>
    <a href="main.php">Вернуться на главную</a>
  </div>
</body>
</html>