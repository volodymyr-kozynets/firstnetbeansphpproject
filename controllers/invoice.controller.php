<?php


class InvoiceController extends Controller{
        
        public function __construct($data = array()) {
            parent::__construct($data); // вызываем конструктор из родительского класса с атрибутом data в кот.храняться данные для представления
            //require_once(ROOT.DS.'models'.DS.'invoice.php');
            $this->model = new Invoice();
        }
        
        public function index(){
            
        }
}
