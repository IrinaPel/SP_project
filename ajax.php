<?php
    ob_clean();
    include "classes/Ajax.php";
    header('Content-type: application/json');
    echo json_encode(
        call_user_func_array(
            ['Ajax', $_POST['method']], [$_POST]
        )
    );
    die();
    // посмотреть Ajax.php (постороитель запросв)
?>
