<?php

class Model {
    
    protected $db; //свойство для доступа к БД
    
    public function __construct(){
        $this->db = App::$db;
    }
}
