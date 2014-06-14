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

<button type="button" class="btn btn-default bwork">Все</button>
<button type="button" class="btn btn-primary bwork0">Ожидают</button>
<button type="button" class="btn btn-success bwork1">В работе</button>
<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#newTask">Новая задача</button>

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
        $q = mysqli_query($main_db, 'SELECT `id`, `title`, `performer`, `cost`
        FROM `tasks` WHERE `author`=' . $user['id'] . '
        ORDER BY `id` DESC');

        while ($task = mysqli_fetch_assoc($q)) {
            $work = 0;
            if ($task['performer'] > 0) {
                $work = 1;
            }
            echo '<tr class="work' . $work . '">
                <td>' . $task['id'] . '</td>
                <td>' . $users_info[$task['performer']] . '</td>
                <td>' . $task['title'] . '</td>
                <td>' . $task['cost'] . '</td>
            </tr>';
        }
        echo '
        </tbody>
    </table>
</div>

<div class="modal fade" id="newTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

// все мои задачи
$(".bwork").click(function () {
    $(".work0").show();
    $(".work1").show();
});


// мои задачи ожидающие
$(".bwork0").click(function () {
    $(".work0").show();
    $(".work1").hide();
});


// все мои задачи завершенные
$(".bwork1").click(function () {
    $(".work0").hide();
    $(".work1").show();
});
</script>

';
    }


}