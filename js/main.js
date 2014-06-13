
$('#all_tasks').click(function () {
    $.ajax({
        url: "ajax/tasks.php?action=all"
    }).done(function (data) {
        $('#content').html(data);
    });
});

$('#my_tasks').click(function () {
    $.ajax({
        url: "ajax/tasks.php?action=my"
    }).done(function (data) {
        $('#content').html(data);
    });
});


