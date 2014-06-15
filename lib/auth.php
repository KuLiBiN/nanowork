<?php

// получаем id юзера
if (isset($_SESSION['user']) || isset($_GET['uid'])) {

    // если юзер уже был авторизован
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $uid = intval($user['id']);
    }

    // если первая авторизация
    if (isset($_GET['uid'])) {
        $uid = intval($_GET['uid']);
    }

    // получаем профиль из базы
    $q = mysqli_query($main_db, 'SELECT * FROM `users` WHERE `id`=' . $uid . ' LIMIT 1');
    if (mysqli_num_rows($q) > 0) {
        // если есть такой юзер - записываем его профиль в сессию
        $user = mysqli_fetch_assoc($q);
        $_SESSION['user'] = $user;
    } else {
        // если юзера нет - обнуляем сессию и профиль
        unset($uid);
        unset($user);
        unset($_SESSION['user']);
    }

}
