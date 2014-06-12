<?php

require_once('../lib/mysql.php');

?>

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
