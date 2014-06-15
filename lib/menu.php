<?php

if (!isset($user)) {
    echo '
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
        <li><a href="#my_tasks" id="my_tasks">Мои задачи</a></li>
        <li><a href="#">У вас на счету <span id="money">'.$user['money'].'</span> руб.</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Заказчик ' . $user['name'] . ' <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="?uid=0">Выход</a></li>
            </ul>
        </li>
    </ul>';

    }
    if ($user['type'] == 2) {
        echo '
    <ul class="nav navbar-nav">
        <li><a href="#all_tasks" id="all_tasks">Все задачи</a></li>
        <li><a href="#my_tasks" id="my_tasks">Мои задачи</a></li>
        <li><a href="#">У вас на счету <span id="money">'.$user['money'].'</span> руб.</a></li>
    </ul>
   <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Исполнитель ' . $user['name'] . ' <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="?uid=0">Выход</a></li>
            </ul>
        </li>
    </ul>';

    }
}