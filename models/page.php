<?php
//необходим для работы с текстовыми страницами
//создаем методы запросов к БД
//контроллер pages.controller, php может обращаться к этой модели и получать данные

class Page extends Model{
    
    public function getList($only_published = false){ //получает список всех опубикованных страниц
        $sql = "select * from pages where 1";
        if($only_published){
            $sql .= "and is_published = 1";
        }
        return $this->db->query($sql);
    }
    
    public function getByAlias($alias){ //получает страницу по названию $alias
        $alias = $this->db->escape($alias);
        $sql = "select * from pages where alias = '{$alias}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;//если запрашиваемые данные есть в таблице возвращаем их если нет то возвращаем null
    }
    
    public function getById($id){ //получает страницу по id в БД
        $id = (int)$id;
        $sql = "select * from pages where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;//если запрашиваемые данные есть в таблице возвращаем их если нет то возвращаем null
    }
    
    public function save($data, $id = null){
        if(!isset($data['alias']) || !isset($data['title']) || !isset($data['content'])){ //проверяем заполнены ли все поля формы
            return false;
        }
        
        //подготавливаем данные перед записью в БД
        $id = (int)$id; //приводим переменную к целому числу
        $alias = $this->db->escape($data['alias']);
        $title= $this->db->escape($data['title']);
        $content = $this->db->escape($data['content']);
        $is_published = isset($data['is_published']) ? 1 : 0;
        
        if( !$id ){ //если id не задано то будет добавлена запись
            $sql = "
                insert into pages
                set alias = '{$alias}',
                    title = '{$title}',
                    content = '{$content}',
                    is_published = {$is_published}
            ";
        } else { //если id задано то будет обновлена запись с заданным id
            $sql = "
                update pages
                set alias = '{$alias}',
                    title = '{$title}',
                    content = '{$content}',
                    is_published = {$is_published}
                where id = {$id}
            ";
        }
        return $this->db->query($sql); //возвращаем результат запроса к БД  
    }
    
    public function delete($id){
        $id = (int)$id;
            $sql = "
                delete from pages where id = {$id};
            ";
        return $this->db->query($sql);
    }
}

