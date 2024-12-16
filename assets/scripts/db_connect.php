<? 
    $db_host = 'localhost';
    $db_user = 'root';
    // $db_pass = 'root';
    $db_database = 'cursed';
    @$link = mysqli_connect($db_host,$db_user,$db_pass,$db_database); // Подключение БД
    if (!mysqli_connect_errno())
    mysqli_query($link, 'SET NAMES utf8');
    else
    {
    echo 'Ошибка подключения к базе данных!';
    exit;
    }
?>