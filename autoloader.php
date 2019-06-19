<?php
//глобальные штуки, которые используются во всем коде 
    session_start();
    include "classes/DB.php";
    try{
        //глобальный коннект к БД
        $db = new DB();
    } catch(Exception $e){
        error_log($e->getMessage());
        die();
    }// отборазить ошибку или залогировать можно error.log
?>