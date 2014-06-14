<?php
session_start();
require_once('../lib/mysql.php');
require_once('../lib/auth.php');

$action = 'all';
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'all') {
        $action = 'all';
    }
    if ($_GET['action'] == 'my' && isset($user)) {
        $action = 'my';
    }
}

// имена пользователей
$users_info = array();
$users_info[0] = '';
$q = mysqli_query($main_db, 'SELECT `id`, `name` FROM `users`');
while ($u = mysqli_fetch_assoc($q)) {
    $users_info[$u['id']] = $u['name'];
}

if ($action == 'all') {

    echo '
<h1 class="page-header">Все задачи</h1>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Заказчик</th>
            <th>Задача</th>
            <th>Стоимость</th>
        </tr>
        </thead>
        <tbody>';
    $q = mysqli_query($main_db, 'SELECT
                `tasks`.`id` AS `id`,
                `tasks`.`author` AS `author_id`,
                `authors`.`name` AS `author_name`,
                `tasks`.`title` AS `title`,
                `tasks`.`description` AS `description`,
                `tasks`.`cost` AS `cost`
            FROM `tasks`
            INNER JOIN `users` AS `authors` ON `authors`.`id`=`tasks`.`author`
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
    echo '
        </tbody>
    </table>
</div>';
}

if ($action == 'my') {

    // заказчик
    if ($user['type'] == 1) {

        echo '
<h1 class="page-header">Мои задачи</h1>



<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Исполнитель</th>
            <th>Описание</th>
            <th>Стоимость</th>
        </tr>
        </thead>
        <tbody>';
        $q = mysqli_query($main_db, 'SELECT `id`, `title`, `performer`
        FROM `tasks` WHERE `author`=' . $user['id'] . '
        ORDER BY `id` DESC');

        while ($task = mysqli_fetch_assoc($q)) {
            $work = 0;
            if ($task['performer'] > 0) {
                $work = 1;
            }
            echo '<tr class="work'.$work.'">
                <td>' . $task['id'] . '</td>
                <td>' . $users_info[$task['id']] . '</td>
                <td>' . $task['title'] . '</td>
                <td>' . $task['cost'] . '</td>
            </tr>';
        }
        echo '
        </tbody>
    </table>
</div>';
    }


}