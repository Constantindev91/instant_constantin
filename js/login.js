const urlParams = new URLSearchParams(window.location.search);
const action = urlParams.get('action') || null;

if (action == "logout") {
    localStorage.removeItem("admin");
    localStorage.setItem("connected", false);

    $.ajax({
        url: '../flux/logout.php',
        type: 'GET',
        dataType: 'json',
        success: (res) => {
            if (res.success) console.log("Déconnecté");       
        }
    });
}

$('#submit').click((event) => {
    event.preventDefault();

    $.ajax({
        url: '../flux/login.php',
        type: 'POST',
        dataType: 'json',
        data: {
            email: $('#email').val(),
            pwd: $('#pwd').val()
        },
        success: (res) => {
            if (res.success) {
                localStorage.setItem('connected', true);
                localStorage.setItem('admin', res.admin);
                window.location.replace('../html/home.html') 
            } else alert(res.error);
        }
    });
});