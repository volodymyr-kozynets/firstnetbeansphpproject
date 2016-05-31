<?php
//для работы с контактной формой

class Message extends Model{
    
    public function save($data, $id = null){ //добавляет или обновляет данные в табл. messages
        if(!isset($data['name']) || !isset($data['email']) || !isset($data['message'])){ //проверяем заполнены ли все поля формы
            return false;
        }
        
        //подготавливаем данные перед записью в БД
        $id = (int)$id; //приводим переменную к целому числу
        $name = $this->db->escape($data['name']);
        $email= $this->db->escape($data['email']);
        $message = $this->db->escape($data['message']);
        
        if( !$id ){ //если id не задано то будет добавлена запись
            $sql = "
                insert into messages
                set name = '{$name}',
                    email = '{$email}',
                    message = '{$message}'
            ";
        } else { //если id задано то будет обновлена запись с заданным id
            $sql = "
                update messages
                set name = '{$name}',
                    email = '{$email}',
                    message = '{$message}'
                where id = {$id}
            ";
        }
        return $this->db->query($sql); //возвращаем результат запроса к БД  
    }
    
    public function getList(){
        $sql = "select * from messages where 1";
        return $this->db->query($sql);
    }
}
