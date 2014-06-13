<?php

if (isset($_SESSION['user']))
echo <<<HTML
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
HTML;

