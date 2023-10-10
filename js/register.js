$('#submit').click((event) => {
    event.preventDefault();

    $.ajax({
        url: '../php/register.php',
        type: 'POST',
        dataType: 'json',
        data: {
            firstname: $('#firstname').val(),
            lastname: $('#lastname').val(),
            birthdate: $('#birthdate').val(),
            email: $('#email').val(),
            pwd: $('#pwd').val()
        },
        success: (res) => {
            res.success ? window.location.replace('../html/login.html') : alert(res.error);
        }
    });
});