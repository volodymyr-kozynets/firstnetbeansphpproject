<?php

class Load extends Model{
    
    public function save($data){
        $code = $this->db->escape($data['A']);
        $name= $this->db->escape($data['B']);
        $price = $this->db->escape($data['C']);
        $sql = "
            insert into pricelist
            set code = '{$code}',
                name = '{$name}',
                price = '{$price}'
        ";
        return $this->db->query($sql); //возвращаем результат запроса к БД  
    }
    
}
