<?php

class ReportController extends Controller {
    
        public function __construct($data = array()) {
            parent::__construct($data); // вызываем конструктор из родительского класса с атрибутом data в кот.храняться данные для представления
            $this->model = new Report();
        }
        
        public function index(){
            
        }
}

