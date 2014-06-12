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
            <li class="active"><a href="#">Задачи</a></li>
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

<div class="container-fluid">
    <h1 class="page-header">Общие задачи</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Заказчик</th>
                <th>Описание</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>

            <?php

            $q = mysqli_query($main_db, 'SELECT
                `tasks`.`id` AS `id`,
                `tasks`.`author` AS `author_id`,
                `users`.`name` AS `author_name`,
                `tasks`.`title` AS `title`,
                `tasks`.`description` AS `description`,
                `tasks`.`cost` AS `cost`
            FROM `tasks`
            INNER JOIN `users` ON `users`.`id`=`tasks`.`author`
            WHERE `tasks`.`performer`=0
            ORDER BY `tasks`.`id` DESC');

            while ($task = mysqli_fetch_assoc($q)) {

                echo '<tr>
                <td>' . $task['id'] . '</td>
                <td>' . $task['author_name'] . '</td>
                <td>' . $task['title'] . '</td>
                <td>' . $task['cost'] . '</td>
            </tr>';

            }

            ?>


            </tbody>
        </table>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>