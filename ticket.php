<?php
    $ticketId = $_GET['ticket_id'];
    include "classes/TicketUtils.php";
    $currentStage = TicketUtils::getCurrentStage($ticketId);
    $currentStageName = TicketUtils::STAGES_TO_RU_NAMES[$currentStage];
    $currentStaffName = TicketUtils::getCurrentStaffName($ticketId);
    $currentStudent = TicketUtils::getCurrentStudentInfo($ticketId);
    $currentClients = TicketUtils::getCurrentClients($ticketId);
    $currentComments = TicketUtils::getCurrentComments($ticketId);
    $currentTicketInfo = TicketUtils::getCurrentTicketInfo($ticketId);
    $currentReps = TicketUtils::getRepetitorsByCompId($currentTicketInfo['comp_id']);
    $currentOfferedUserId = TicketUtils::getCurrentOfferedUser($ticketId);
    include "views/ticket.html";
?>