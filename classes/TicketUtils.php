<?php
//класс с функциями для отображения заявки
class TicketUtils{
    const STAGES_TO_RU_NAMES = [
        'not assigned' => "Не назначен репетитор",
        'assigned' => "Назначен репетитор",
        'done' => "Успех"
    ];
    const ROLES_TO_RU_NAMES = [
        'admin' => "Администратор",
        'call' => "Колл центр",
        'teacher' => "Преподаватель"
    ];

    //вернет последний этап заявки 
    public static function getCurrentStage($ticketId){
        global $db;

        $query = "SELECT stage
                FROM ticket_stages
                WHERE
                    ticket_id = $ticketId
                ORDER BY create_date DESC";
        $stage = $db->getOne($query);

        return $stage;
    }

    //вернет текущего ответственного по заявке 
    public static function getCurrentStaffName($ticketId){
        global $db;

        $query = "  SELECT 
                        u.last_name,
                        u.first_name,
                        u.middle_name
                    FROM tickets AS t
                    JOIN users AS u ON u.id = t.staff_id
                    WHERE
                        t.id = $ticketId";
        $userFio = $db->getRow($query);
        
        if ($userFio){
            return implode(' ', $userFio);
        } else {
            return "Сотрудник не назначен";
        }
    }

    //вернет текущего ученика, указанного в заявке
    public static function getCurrentStudentInfo($ticketId){
        global $db;

        $query = "  SELECT s.*
                    FROM tickets AS t
                    JOIN student AS s ON s.id = t.student_id
                    WHERE
                        t.id = $ticketId";
        return $db->getRow($query);
    }

    //вернет текущего клиента, указанного в заявке 
    public static function getCurrentClients($ticketId){
        global $db;

        $query = "  SELECT c.*
                    FROM tickets_clients AS tc
                    JOIN clients AS c ON c.id = tc.client_id
                    WHERE
                        tc.ticket_id = $ticketId";
        return $db->getAll($query);
    }

    //вернет текущий комментарий к заявке
    public static function getCurrentComments($ticketId){
        global $db;

        $query = "  SELECT c.*, u.last_name, u.first_name, u.middle_name, r.name AS role_name
                    FROM comments AS c
                    JOIN users AS u ON u.id = c.user_id
                    JOIN user_roles AS ur ON u.id = ur.user_id
                    JOIN roles AS r ON r.id = ur.role_id
                    WHERE
                        c.ticket_id = $ticketId
                    ORDER BY create_date DESC";
        return $db->getAll($query);
    }

    //вернет инфу по заявке
    public static function getCurrentTicketInfo($ticketId){
        global $db;

        $query = "  SELECT c.name, t.comp_id
                    FROM tickets AS t
                    JOIN competencies AS c ON c.id = t.comp_id
                    WHERE
                        t.id = $ticketId";
        return $db->getRow($query);
    }

    //вернет репетиторов по компетеции 
    public static function getRepetitorsByCompId($compId){
        global $db;

        $query = "  SELECT u.*
                    FROM user_competencies AS uc
                    JOIN users AS u ON uc.user_id = u.id
                    WHERE
                        uc.comp_id = $compId";
        return $db->getAll($query);
    }

    //вернет репетиторов по компетеции 
    public static function getCurrentOfferedUser($ticketId){
        global $db;

        $query = "  SELECT user_id
                    FROM ticket_offers
                    WHERE
                        ticket_id = $ticketId";
        return $db->getOne($query);
    }
}
?>