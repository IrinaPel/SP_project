<?php
    global $db;
    $query = "SELECT * FROM competencies";
    $comps = $db->getAll($query);
    


    include "views/create_ticket.html";
?>
