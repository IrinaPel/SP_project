<?php
    include "classes/TicketsListUtils.php";
    include "classes/TicketUtils.php";
    if ($_SESSION['userRole'] == 'teacher'){
        if ($_GET['ticketList'] == '' || $_GET['ticketList'] == 'unassigned'){
            $tickets = TicketsListUtils::getUnassgned();
        } else if ($_GET['ticketList'] == 'wait') {
            $tickets = TicketsListUtils::getWait();
        } else if ($_GET['ticketList'] == 'me'){
            $tickets = TicketsListUtils::getMe();
        }
    } else {
        $tickets = TicketsListUtils::getAll();
    }
    include "views/tickets_list.html";
?>