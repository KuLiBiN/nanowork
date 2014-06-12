<?php
session_start();
require_once('lib/mysql.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nanowork for VK</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Nanowork</a>
    </div>
    <div class="navbar-collapse collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
            <li class="active"><a href="#" id="tasks_list">Задачи</a></li>
            <li><a href="#">Исполнители</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Авторизация <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Заказчик</a></li>
                    <li><a href="#">Исполнитель</a></li>
                    <li><a href="#">Администратор</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid" id="content">


</div>




<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">

        $('#tasks_list').hover(function () {

            alert('sdfgsdfg');

        });



</script>


</body>
</html>