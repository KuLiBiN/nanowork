<?php

if (!isset($user)) {
    echo '
    <ul class="nav navbar-nav">
        <li class="active"><a href="#" id="tasks_list">Задачи</a></li>
        <li><a href="#">Исполнители</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Авторизация <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="?uid=1">Заказчик</a></li>
                <li><a href="?uid=3">Исполнитель</a></li>
                <li><a href="#">Администратор</a></li>
            </ul>
        </li>
    </ul>';

} else {
    if ($user['type'] == 1) {
        echo '
    <ul class="nav navbar-nav">
        <li class="active"><a href="#" id="tasks_list">Задачи</a></li>
        <li><a href="#">Исполнители</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Заказчик ' . $user['name'] . '</a></li>
    </ul>';

    }
    if ($user['type'] == 2) {
        echo '
    <ul class="nav navbar-nav">
        <li class="active"><a href="#" id="tasks_list">Задачи</a></li>
        <li><a href="#">Исполнители</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Исполнитель ' . $user['name'] . '</a></li>
    </ul>';

    }
}