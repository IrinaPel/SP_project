//функция работы с сессией на бэке
function login(login, pass){
    $.ajax({
        method: "POST",
        url: "http://localhost:8888/ajax",
        data: { "method": "auth", "login": login, "pass": pass},
        dataType: "json",
    })
    .done(function( data ) {
        if (data.success){
            window.location.href = '/main';
        } else {
            alert('Неправильная комбинация логина и пароля');
        }
    });
}

function logout(){
    $.ajax({
        method: "POST",
        url: "http://localhost:8888/ajax",
        data: { "method": "logout"},
        dataType: "json",
    })
    .done(function( data ) {
        if (data.success){
            window.location.href = '/main';
        }
    });
}