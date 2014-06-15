<?php
session_start();
require_once('../lib/mysql.php');
require_once('../lib/auth.php');
require_once('lib/lib.php');

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
    // взять задачу
    if ($_GET['action'] == 'take' && isset($_GET['task']) && $user['type'] == 2) {
        $tid = intval($_GET['task']);
        if ($tid > 0) {
            // получаем информацию по задаче
            $q=mysqli_query($main_db, 'SELECT * FROM `tasks` WHERE `performer`=0 AND `id`='.$tid.' LIMIT 1');
            if (mysqli_num_rows($q)>0){
                $task=mysqli_fetch_assoc($q);
                // забираем задачу
                mysqli_query($main_db, 'UPDATE `tasks`
                SET `performer`=' . $user['id'] . '
                WHERE `id`=' . $task['id'] . ' LIMIT 1');
                // получаем деньги
                mysqli_query($main_db, 'UPDATE `users`
                SET `money`=(`money`+' . $task['money_performer'] . ')
                WHERE `id`=' . $users['id'] . ' LIMIT 1');
            }
        }
        $action = 'my';
    }

    // добавление задачи для заказчиков
    if ($_GET['action'] == 'new' && $user['type'] == 1) {
        if (isset($_GET['title']) && isset($_GET['description']) && isset($_GET['cost'])) {
            $title = trim(mysqli_real_escape_string($main_db, $_GET['title']));
            $description = trim(mysqli_real_escape_string($main_db, $_GET['description']));
            $money_author = abs(floatval($_GET['cost']));   // деньги с заказчика
            $money_system = round($money_author * $system_percent / 100, 2);    // деньги системы
            $money_performer = $money_author - $money_system; // деньги исполнителю

            if ($user['money'] >= $money_author) { // а хватит ли у вас денег?

                // создаем задачу
                mysqli_query($main_db, 'INSERT INTO `tasks`
                SET `author`=' . $user['id'] . ',
                `title`="' . $title . '",
                `description`="' . $description . '",
                `money_author`=' . $money_author . ',
                `money_system`=' . $money_system . ',
                `money_performer`=' . $money_performer . '');

                // списываем деньги с заказчика
                if (mysqli_affected_rows($main_db) > 0) {
                    mysqli_query($main_db, 'UPDATE `users` SET `money`=(`money`-' . $money_author . ')
                    WHERE `id`=' . $user['id'] . ' LIMIT 1');
                }
            }

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

// все доступные задачи для исполнителей
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
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>';
    $q = mysqli_query($main_db, 'SELECT `id`, `title`, `author`, `money_performer`
        FROM `tasks` WHERE `performer`=0
        ORDER BY `id` DESC');

    while ($task = mysqli_fetch_assoc($q)) {
        echo '<tr>
                <td>' . $task['id'] . '</td>
                <td>' . $users_info[$task['author']] . '</td>
                <td>' . $task['title'] . '</td>
                <td>' . $task['money_performer'] . '</td>
                <td><button type="button" class="btn btn-success" onclick="takeTask(' . $task['id'] . ')">Выполнить</button></td>
            </tr>';
    }
    echo '
        </tbody>
    </table>
</div>';
}

// мои задачи
if ($action == 'my') {

    // мои задачи для заказчика
    if ($user['type'] == 1) {

        echo '
<h1 class="page-header">Мои задачи</h1>

<button type="button" class="btn btn-default bwork">Все</button>
<button type="button" class="btn btn-primary bwork0">Ожидают</button>
<button type="button" class="btn btn-success bwork1">В работе</button>
<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#newTaskModal">Новая задача</button>

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
        $q = mysqli_query($main_db, 'SELECT `id`, `title`, `performer`, `money_author`
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
                <td>' . $task['money_author'] . '</td>
            </tr>';
        }
        echo '
        </tbody>
    </table>
</div>

<div class="modal" id="newTaskModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
    $("#newTaskModal").modal("hide");
    newTask(form);
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

// мои задачи завершенные
$(".bwork1").click(function () {
    $(".work0").hide();
    $(".work1").show();
});
</script>

';
    }

    // мои задачи для исполнителя
    if ($user['type'] == 2) {

        echo '
<h1 class="page-header">Мои задачи</h1>

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
        <tbody>';
        $q = mysqli_query($main_db, 'SELECT `id`, `title`, `author`, `money_performer`
        FROM `tasks` WHERE `performer`=' . $user['id'] . '
        ORDER BY `id` DESC');

        while ($task = mysqli_fetch_assoc($q)) {
            echo '<tr>
                <td>' . $task['id'] . '</td>
                <td>' . $users_info[$task['author']] . '</td>
                <td>' . $task['title'] . '</td>
                <td>' . $task['money_performer'] . '</td>
            </tr>';
        }
        echo '
        </tbody>
    </table>
</div>


';
    }

}