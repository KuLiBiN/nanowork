<?php

if (!isset($user)) {
    echo '
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Авторизация <b class="caret"></b></a>
            <ul class="dropdown-menu">';
            // вывод юзеров
            $q = mysqli_query($main_db, 'SELECT `id`, `type`, `name` FROM `users` ORDER BY `type` ASC, `name` ASC');
            while ($u = mysqli_fetch_assoc($q)) {
                echo '<li><a href="?uid=' . $u['id'] . '">' . $user_type[$u['type']] . ' ' . $u['name'] . '</a></li>';
            }
            echo '</ul>
        </li>
    </ul>';

} else {
    if ($user['type'] == 1) {
        echo '
    <ul class="nav navbar-nav">
        <li><a href="#my_tasks" id="my_tasks">Мои задачи</a></li>
        <li><a href="#">У вас на счету <span id="money">' . $user['money'] . '</span> руб.</a></li>
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
        <li><a href="#">У вас на счету <span id="money">' . $user['money'] . '</span> руб.</a></li>
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