<?php
    ob_start();
    session_start();
    include "classes/DB.php";
    try{
        $db = new DB();
    } catch(Exception $e){
        var_dump ($e);
    }
?>