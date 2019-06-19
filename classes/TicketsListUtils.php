<?php
//класс с функциями для фильтра заявок на бэке
class TicketsListUtils{
    //вернет все заявки 
    public static function getAll(){
        global $db;
        $query = "SELECT 
                    t.id,
                    t.create_date,
                    c.name,
                    s.last_name as student_last_name, 
                    s.first_name as student_first_name, 
                    s.middle_name as student_middle_name,
                    s.age,
                    s.gender,
                    cur_staff.last_name as rep_last_name, 
                    cur_staff.first_name as rep_first_name, 
                    cur_staff.middle_name as rep_middle_name,
                    cur_staff.id as rep_id,
                    creator.last_name as creator_last_name, 
                    creator.first_name as creator_first_name, 
                    creator.middle_name as creator_middle_name,
                    comm.id as comm_id,
                    comm.comment_text,
                    ts.stage
                FROM tickets as t
                JOIN student as s ON t.student_id = s.id
                JOIN competencies as c ON t.comp_id = c.id
                LEFT JOIN users as cur_staff ON t.staff_id = cur_staff.id
                JOIN users as creator ON t.creator_id = creator.id
                LEFT JOIN (
                    SELECT MAX(id) as id, ticket_id 
                    FROM comments
                    GROUP BY ticket_id 
                ) as last_comment ON t.id = last_comment.ticket_id
                LEFT JOIN comments as comm ON last_comment.id = comm.id 
                LEFT JOIN (
                    SELECT MAX(id) as id, ticket_id 
                    FROM ticket_stages
                    GROUP BY ticket_id 
                ) as last_stage ON t.id = last_stage.ticket_id
                LEFT JOIN ticket_stages as ts ON last_stage.id = ts.id 
                ORDER BY t.create_date DESC";
        return $db->getAll($query);
    }

    public static function getUnassgned(){
        global $db;

        $subQuery = "SELECT comp_id
                FROM user_competencies 
                WHERE
                    user_id = ".$_SESSION['userId'];

        $query = "SELECT 
                    t.id,
                    t.create_date,
                    c.name,
                    s.last_name as student_last_name, 
                    s.first_name as student_first_name, 
                    s.middle_name as student_middle_name,
                    s.age,
                    s.gender,
                    cur_staff.last_name as rep_last_name, 
                    cur_staff.first_name as rep_first_name, 
                    cur_staff.middle_name as rep_middle_name,
                    cur_staff.id as rep_id,
                    creator.last_name as creator_last_name, 
                    creator.first_name as creator_first_name, 
                    creator.middle_name as creator_middle_name,
                    comm.id as comm_id,
                    comm.comment_text,
                    ts.stage
                FROM tickets as t
                JOIN student as s ON t.student_id = s.id
                JOIN competencies as c ON t.comp_id = c.id
                LEFT JOIN users as cur_staff ON t.staff_id = cur_staff.id
                JOIN users as creator ON t.creator_id = creator.id
                LEFT JOIN (
                    SELECT MAX(id) as id, ticket_id 
                    FROM comments
                    GROUP BY ticket_id 
                ) as last_comment ON t.id = last_comment.ticket_id
                LEFT JOIN comments as comm ON last_comment.id = comm.id 
                LEFT JOIN (
                    SELECT MAX(id) as id, ticket_id 
                    FROM ticket_stages
                    GROUP BY ticket_id 
                ) as last_stage ON t.id = last_stage.ticket_id
                LEFT JOIN ticket_stages as ts ON last_stage.id = ts.id 
                WHERE c.id IN ($subQuery)
                    AND t.staff_id = 0
                ORDER BY t.create_date DESC";
        return $db->getAll($query);
    }

    public static function getWait(){
        global $db;

        $subQuery = "SELECT comp_id
                FROM user_competencies 
                WHERE
                    user_id = ".$_SESSION['userId'];

        $subQueryWait = "SELECT ticket_id
                FROM ticket_offers 
                WHERE
                    user_id = ".$_SESSION['userId'];

        $query = "SELECT 
                    t.id,
                    t.create_date,
                    c.name,
                    s.last_name as student_last_name, 
                    s.first_name as student_first_name, 
                    s.middle_name as student_middle_name,
                    s.age,
                    s.gender,
                    cur_staff.last_name as rep_last_name, 
                    cur_staff.first_name as rep_first_name, 
                    cur_staff.middle_name as rep_middle_name,
                    cur_staff.id as rep_id,
                    creator.last_name as creator_last_name, 
                    creator.first_name as creator_first_name, 
                    creator.middle_name as creator_middle_name,
                    comm.id as comm_id,
                    comm.comment_text,
                    ts.stage
                FROM tickets as t
                JOIN student as s ON t.student_id = s.id
                JOIN competencies as c ON t.comp_id = c.id
                LEFT JOIN users as cur_staff ON t.staff_id = cur_staff.id
                JOIN users as creator ON t.creator_id = creator.id
                LEFT JOIN (
                    SELECT MAX(id) as id, ticket_id 
                    FROM comments
                    GROUP BY ticket_id 
                ) as last_comment ON t.id = last_comment.ticket_id
                LEFT JOIN comments as comm ON last_comment.id = comm.id 
                LEFT JOIN (
                    SELECT MAX(id) as id, ticket_id 
                    FROM ticket_stages
                    GROUP BY ticket_id 
                ) as last_stage ON t.id = last_stage.ticket_id
                LEFT JOIN ticket_stages as ts ON last_stage.id = ts.id 
                WHERE c.id IN ($subQuery)
                    AND t.id IN ($subQueryWait)
                    AND t.staff_id = 0
                ORDER BY t.create_date DESC";

        return $db->getAll($query);
    }

    public static function getMe(){
        global $db;

        $subQuery = "SELECT comp_id
                FROM user_competencies 
                WHERE
                    user_id = ".$_SESSION['userId'];

        $query = "SELECT 
                    t.id,
                    t.create_date,
                    c.name,
                    s.last_name as student_last_name, 
                    s.first_name as student_first_name, 
                    s.middle_name as student_middle_name,
                    s.age,
                    s.gender,
                    cur_staff.last_name as rep_last_name, 
                    cur_staff.first_name as rep_first_name, 
                    cur_staff.middle_name as rep_middle_name,
                    cur_staff.id as rep_id,
                    creator.last_name as creator_last_name, 
                    creator.first_name as creator_first_name, 
                    creator.middle_name as creator_middle_name,
                    comm.id as comm_id,
                    comm.comment_text,
                    ts.stage
                FROM tickets as t
                JOIN student as s ON t.student_id = s.id
                JOIN competencies as c ON t.comp_id = c.id
                LEFT JOIN users as cur_staff ON t.staff_id = cur_staff.id
                JOIN users as creator ON t.creator_id = creator.id
                LEFT JOIN (
                    SELECT MAX(id) as id, ticket_id 
                    FROM comments
                    GROUP BY ticket_id 
                ) as last_comment ON t.id = last_comment.ticket_id
                LEFT JOIN comments as comm ON last_comment.id = comm.id 
                LEFT JOIN (
                    SELECT MAX(id) as id, ticket_id 
                    FROM ticket_stages
                    GROUP BY ticket_id 
                ) as last_stage ON t.id = last_stage.ticket_id
                LEFT JOIN ticket_stages as ts ON last_stage.id = ts.id 
                WHERE c.id IN ($subQuery)
                    AND t.staff_id = ".$_SESSION['userId']."
                ORDER BY t.create_date DESC";

        return $db->getAll($query);
    }
}
?>