
    $('#tasks_list').click(function () {
        $.ajax({
            url: "ajax/tasks.php"
        }).done(function (data) {
            $('#content').html(data);
        });
    });


