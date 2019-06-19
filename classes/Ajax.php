<?php
class Ajax{
    const ROLES_TO_RU_NAMES = [
        'admin' => "Администратор",
        'call' => "Колл центр",
        'teacher' => "Преподаватель"
    ];

    /** АННОТАЦИЯ 
     * auth for user
     * @param $login - string
     */
    public static function auth($data){
        global $db;
        $login = trim($data['login']);
        $pass = $data['pass'];
        $hashPass = hash("sha256", $pass);
        $query = "  SELECT u.login, u.first_name, u.id, r.name as roleName
                    FROM users as u
                    LEFT JOIN user_roles as ur on ur.user_id = u.id
                    LEFT JOIN roles as r ON r.id = ur.role_id
                    WHERE 
                        login = '$login' 
                        AND password = '$hashPass'";
        $value = $db->getRow($query);
        if ($value){
            //todo добавить в сессию роль тогда сможем контроллировать функционал в заявисимости от нее 
            $_SESSION["login"] = $value['login'];
            $_SESSION["userName"] = $value['first_name'];
            $_SESSION["userId"] = $value['id'];
            $_SESSION["userRole"] = $value['roleName'];
            return ['success' => true];
        } else {
            self::clearUserSessionData();
            return ['success' => false];
        }
    }
    
    public static function logout($data){
        self::clearUserSessionData();
        return ['success' => true];
    }

    private static function clearUserSessionData(){
        $_SESSION["login"] = false;
        $_SESSION["userName"] = false;
        $_SESSION["userId"] = false;
        $_SESSION["userRole"] = false;
    }

    public static function createTicket($data){
        global $db;
        $query = "INSERT INTO student 
        (last_name, first_name, middle_name, age, gender)
            VALUES('{$data['student_last_name']}',
            '{$data['student_name']}',
            '{$data['student_middle_name']}',
            '{$data['student_age']}',
            '{$data['student_gender']}')";
        
        $db->query($query);

        $studentId = $db->insertId();

        $query = "INSERT INTO tickets 
        (creator_id, staff_id, comp_id, student_id)
            VALUES({$_SESSION['userId']},
            0,
            '{$data['subject']}',
            '{$studentId}')";

        $db->query($query);

        $ticketId = $db->insertId();

        $query = "INSERT INTO clients
        (last_name, first_name, middle_name, phone)
            VALUES('{$data['client_last_name']}',
            '{$data['client_name']}',
            '{$data['client_middle_name']}',
            '{$data['client_phone']}')";
        
        $db->query($query);

        $clientId = $db->insertId();


        $query = "INSERT INTO tickets_clients
        (ticket_id, client_id)
            VALUES($ticketId, $clientId)";
        
        $db->query($query);

        $query = "INSERT INTO ticket_stages
        (stage, ticket_id)
            VALUES('not assigned', $ticketId)";
        
        $db->query($query);

        $comment = trim($data["comment"]);
        if ($comment){
            $query = "INSERT INTO comments
            (ticket_id, comment_text, user_id)
                VALUES($ticketId, '$comment', {$_SESSION['userId']})";
            
            $db->query($query);
        }

        return ['success' => true, 'ticketId' => $ticketId];
    }

    public static function addCommentToTicket($data){
        global $db;

        $text = trim($data['commentText']);
        $ticketId = $data['ticketId'];

        if ($text){
            $query = "INSERT INTO comments
            (ticket_id, comment_text, user_id)
                VALUES($ticketId, '$text', {$_SESSION['userId']})";
            
            $db->query($query);

            $query = "  SELECT c.*, u.last_name, u.first_name, u.middle_name, r.name as role_name
                    FROM comments AS c
                    JOIN users AS u ON u.id = c.user_id
                    JOIN user_roles AS ur ON u.id = ur.user_id
                    JOIN roles AS r ON r.id = ur.role_id
                    WHERE
                        c.ticket_id = $ticketId
                    ORDER BY create_date DESC";
            $lastComment = $db->getRow($query);
            $fioDate = $lastComment['last_name'] . ' ' 
                    . $lastComment['first_name'] . ' ' 
                    . $lastComment['middle_name'] . ' ' .
                    ' - '. self::ROLES_TO_RU_NAMES[$lastComment['role_name']] . ' '
                    . " (" . $lastComment['create_date'] . ")";

            return ['success' => true, 'comment' => ['creatorRow' => $fioDate, 'text' => $lastComment['comment_text']]];
        } else {
            return ['success' => false];
        }
    }

    public static function addTicketOffer($data){
        global $db;

        $userId = $data['userId'];
        $ticketId = $data['ticketId'];

        if ($userId){
            $query = "REPLACE INTO ticket_offers
            (ticket_id, user_id)
                VALUES($ticketId, $userId)";
            
            $db->query($query);

            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

    public static function rejectTicketOffer($data){
        global $db;

        $ticketId = $data['ticketId'];

        $query = "UPDATE ticket_offers SET user_id = 0 WHERE ticket_id = $ticketId";
        
        $db->query($query);

        return ['success' => true];
    }

    public static function acceptTicketOffer($data){
        global $db;

        $ticketId = $data['ticketId'];

        $query = "INSERT INTO ticket_stages(ticket_id, stage) VALUES($ticketId, 'assigned')";
        
        $db->query($query);

        $query = "UPDATE tickets SET staff_id = ".$_SESSION['userId']." WHERE id = $ticketId";

        $db->query($query);

        return ['success' => true];
    }

    public static function closeTicket($data){
        global $db;

        $ticketId = $data['ticketId'];

        $query = "INSERT INTO ticket_stages(ticket_id, stage) VALUES($ticketId, 'done')";

        $db->query($query);

        return ['success' => true];
    }

    public static function reopenTicket($data){
        global $db;

        $ticketId = $data['ticketId'];

        $query = "INSERT INTO ticket_stages(ticket_id, stage) VALUES($ticketId, 'not assigned')";
        
        $db->query($query);

        $query = "UPDATE tickets SET staff_id = 0 WHERE id = $ticketId";

        $db->query($query);

        $query = "UPDATE ticket_offers SET user_id = 0 WHERE ticket_id = $ticketId";
        
        $db->query($query);

        return ['success' => true];
    }
}
?>