<?php
//для работы с авторизацией

class User extends Model {
    
    public function getByLogin($login){ //получаем логин пользователя из базы данных
        $login = $this->db->escape($login);
        $sql = "select * from users where login = '{$login}'";
        $result = $this->db->query($sql);
        if(isset($result[0])){
            return $result[0];
        }
        return false;
    }
    
}
