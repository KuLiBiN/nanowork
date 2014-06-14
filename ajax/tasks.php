<?php
session_start();
require_once('../lib/mysql.php');
require_once('../lib/auth.php');

// работа с задачами только для авторизованных юзеров
if (!isset($user)) {
    exit();
}

// действия с задачами
$action = 'no';
if (isset($_GET['action'])) {
    // все задачи для исполнителей
    if ($_GET['action'] == 'all' && $user['type'] == 2) {
        $action = 'all';
    }
    // мои задачи
    if ($_GET['action'] == 'my') {
        $action = 'my';
    }
    // добавление задачи для заказчиков
    if ($_GET['action'] == 'new' && $user['type'] == 1) {
        if (isset($_GET['title']) && isset($_GET['description']) && isset($_GET['cost'])) {
            $title = trim(mysqli_real_escape_string($main_db, $_GET['title']));
            $description = trim(mysqli_real_escape_string($main_db, $_GET['description']));
            $cost = abs(floatval($_GET['cost']));
            mysqli_query($main_db, 'INSERT INTO `tasks`
            SET `author`=' . $user['id'] . ',
            `title`="' . $title . '",
            `description`="' . $description . '",
            `cost`=' . $cost . '');
        }
        $action = 'my';
    }
}
if ($action == "no") {
    exit();
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
        <h4 class="modal-title" id="myModalLabel">Новая задача</h4>
      </div>
      <div class="modal-body">
       <form class="form-horizontal" id="newTaskForm">
  <fieldset>
    <div class="form-group">
      <label for="inputTitle" class="col-lg-2 control-label">Название</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="inputTitle" placeholder="Название" name="title">
      </div>
    </div>
    <div class="form-group">
      <label for="inputDescription" class="col-lg-2 control-label">Описание</label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" id="inputDescription" name="description"></textarea>
      </div>
    </div>
        <div class="form-group">
      <label for="inputCost" class="col-lg-2 control-label">Стоимость</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="inputCost" placeholder="100500" name="cost">
      </div>
    </div>
     </fieldset>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-primary" id="newTaskButton">Добавить</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

// форма новой задачи
$("#newTaskButton").click(function () {
    var form=$("#newTaskForm").serialize();
    $("#newTask").modal("hide");
    $("#newTask").on("hidden.bs.modal", function(form){
        newTask(form);
    });


});

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