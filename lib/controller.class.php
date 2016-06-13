<?php

class Controller {
    
    protected $data; // содержит всю информацию кот.буд.передаваться из контроллера в представление
    
    protected $model; // для доступа к обьекту модели
    
    protected $params; // параметры полученные из строки запроса

    public function getData(){
        return $this->data;
    }
    
    public function getModel(){
        return $this->model;
    }
    
    public function getParams(){
        return $this->params;
    }
    
    public function __construct($data = array()){
        $this->data = $data; // записывает данные переданные атрибутом при создании обьекта класса Контроллер
        $this->params = App::getRouter()->getParams();
        
    }
}
