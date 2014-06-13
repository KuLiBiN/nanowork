$('#tasks_list').click(function () {
    $.ajax({
        url: "ajax/tasks.php"
    }).done(function (data) {
        $('#content').html(data);
    });
});

$.ajax({
    url: "ajax/menu.php"
}).done(function (data) {
    $('#menu').html(data);
});