<?php
class Ajax{
    /** АННОТАЦИЯ ВЫГЛЯДИТ ТАК
     * auth for user
     * @param $login - string
     */
    public static function auth($data){
        global $db;
        $login = $data['login'];
        $pass = $data['pass'];
        $hashPass = hash("sha256", $pass);
        $query = "  SELECT login 
                    FROM users 
                    WHERE 
                        login = '$login' 
                        AND password = '$hashPass'";
        $value = $db->getOne($query);
        if ($value){
            //todo добавить в сессию роль тогда сможем контроллировать функционал в заявисимости от нее 
            $_SESSION["login"] = $value;
            return ['success' => true];
        } else {
            $_SESSION["login"] = false;
            return ['success' => false];
        }
    }
}
?>