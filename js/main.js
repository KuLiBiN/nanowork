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

// все мои задачи
$('.bwork').click(function () {
    $('.work0').show();
    $('.work1').show();
});


// мои задачи ожидающие
$('.bwork').click(function () {
    $('.work0').show();
    $('.work1').hide();
});


// все мои задачи завершенные
$('.bwork').click(function () {
    $('.work0').hide();
    $('.work1').show();
});




