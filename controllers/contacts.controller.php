<?php
// Contacts.Controller отвечает за отображение страниц Contacts

class ContactsController extends Controller{
    
        public function __construct($data = array()) {
            parent::__construct($data); // вызываем конструктор из родительского класса с атрибутом data в кот.храняться данные для представления
            $this->model = new Message();
        }

        public function index(){ //метод (установленный по умолчанию) index контроллера Contacts
            if($_POST){
                if($this->model->save($_POST)){
                    Session::setFlash('Thank You! Your message was sent successufully!');
                }
            }
        }
        
        public function admin_index(){
            $this->data = $this->model->getList();
        }
}
