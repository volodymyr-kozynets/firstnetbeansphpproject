<?php

class Pricelist extends Model{
    
    public function save($data, $id = null){ //добавляет или обновляет данные в табл. messages
        if(!isset($data['code']) || !isset($data['name']) || !isset($data['price'])){ //проверяем заполнены ли все поля формы
            return false;
        }
        
        //подготавливаем данные перед записью в БД
        $id = (int)$id; //приводим переменную к целому числу
        $code = $this->db->escape($data['code']);
        $name= $this->db->escape($data['name']);
        $price = $this->db->escape($data['price']);
        
        if( !$id ){ //если id не задано то будет добавлена запись
            $sql = "
                insert into pricelist
                set code = '{$code}',
                    name = '{$name}',
                    price = '{$price}'
            ";
        } else { //если id задано то будет обновлена запись с заданным id
            $sql = "
                update pricelist
                set code = '{$code}',
                    name = '{$name}',
                    price = '{$price}'
                where id = {$id}
            ";
        }
        return $this->db->query($sql); //возвращаем результат запроса к БД 
    }
    
    public function delete($id){
            $id = (int)$id;
                $sql = "
                    delete from pricelist where id = {$id};
                ";
            return $this->db->query($sql);
    }
    
    public function alldelete(){
                $sql = "
                    delete from pricelist where 1;
                ";
            return $this->db->query($sql);
    }

    public function getList() {
        $sql = "select * from pricelist where 1";
        return $this->db->query($sql);
    }
    
    public function getById($id){ //получает елемент по id в БД
        $id = (int)$id;
        $sql = "select * from pricelist where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;//если запрашиваемые данные есть в таблице возвращаем их если нет то возвращаем null
    }
}
