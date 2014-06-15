// главная страница
$('#index').click(function () {
    $.ajax({
        url: "ajax/index.php"
    }).done(function (data) {
        $('#content').html(data);
    });
});

// все задачи
$('#all_tasks').click(function () {
    $.ajax({
        url: "ajax/tasks.php?action=all"
    }).done(function (data) {
        $('#content').html(data);
    });
});

// мои задачи
$('#my_tasks').click(function () {
    $.ajax({
        url: "ajax/tasks.php?action=my"
    }).done(function (data) {
        $('#content').html(data);
    });
});

// новая задача
function newTask(form) {
    $.ajax({
        url: "ajax/tasks.php?action=new&" + form
    }).done(function (data) {
        $('#content').html(data);
    });
}

// взять задачу
function takeTask(tid) {
    $.ajax({
        url: "ajax/tasks.php?action=take&task=" + tid
    }).done(function (data) {
        $('#content').html(data);
    });
}

// обновление денег
function refreshMoney(money){
    $("#money").html(money);
}