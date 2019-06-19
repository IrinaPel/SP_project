<?php
    $page = explode('/', $_SERVER["REQUEST_URI"])[1];
    if ($page == '' || $page == 'main'){
        include 'views/main.html';
    } else if ($page == 'auth'){
        include 'views/auth.html';
    } else if ($page == 'tickets_list'){
        include 'tickets_list.php';
    } else if ($page == 'create_ticket'){
        include 'create_ticket.php';
    } else if ($page == 'ticket'){
        include 'ticket.php';
    } else if ($page == 'ajax'){
        include 'ajax.php';
    } else {//сюда попадаем если кривая ссылка (валим 404 ошибку)
        http_response_code(404);
        include 'views/404.html';
    }

    
?>