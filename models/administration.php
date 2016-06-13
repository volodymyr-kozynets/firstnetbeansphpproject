<?php

class Administration extends Model{
    
    public function getUsersList() {
        $sql = "select * from users where 1";
        return $this->db->query($sql);
    }
    
    public function saveUser($data, $id = null){ //добавляет или обновляет данные в табл. users
        if(!isset($data['newlogin']) || !isset($data['newfullname']) || !isset($data['newemail']) || !isset($data['newrole']) || !isset($data['newpassword'])){ //проверяем заполнены ли все поля формы
            return false;
        }
        
        //подготавливаем данные перед записью в БД
        $id = (int)$id; //приводим переменную к целому числу
        $newlogin = $this->db->escape($data['newlogin']);
        $newfullname = $this->db->escape($data['newfullname']);
        $newemail = $this->db->escape($data['newemail']);
        $newrole = $this->db->escape($data['newrole']);
        $newpassword = $this->db->escape($data['newpassword']);
        $newpassword = Config::get('salt').$newpassword;
        
        if( !$id ){ //если id не задано то будет добавлена запись
            $sql = "
                insert into users
                set login = '{$newlogin}',
                    fullname = '{$newfullname}',
                    email = '{$newemail}',
                    role = '{$newrole}',
                    password = md5('{$newpassword}');
            ";
        } else { //если id задано то будет обновлена запись с заданным id
            $sql = "
                update users
                set login = '{$newlogin}',
                    fullname = '{$newfullname}',
                    email = '{$newemail}',
                    role = '{$newrole}',
                    password = md5('{$newpassword}')
                where id = {$id}
            ";
        }
        return $this->db->query($sql); //возвращаем результат запроса к БД 
    }
    
    public function deleteUser($id){
            $id = (int)$id;
                $sql = "
                    delete from users where id = {$id};
                ";
            return $this->db->query($sql);
    }
        
    public function getById($id){ //получает елемент по id в БД
        $id = (int)$id;
        $sql = "select * from users where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;//если запрашиваемые данные есть в таблице возвращаем их если нет то возвращаем null
    }
}
