<?php

class PricelistsController extends Controller {
    
    public function __construct($data = array()) {
        parent::__construct($data); // вызываем конструктор из родительского класса с атрибутом data в кот.храняться данные для представления
        $this->model = new Pricelist();
    }
        
    public function index(){
        if($_REQUEST){
                $this->model->save($_POST);
        }
            $this->data = $this->model->getList();
    }
        
    public function delete(){
        if(isset($this->params[0])){
            $result = $this->model->delete($this->params[0]);
            if($result){
                Session::setFlash('Item was delete.');
            }else{
                Session::setFlash('Error.');
                }
        }
        Router::redirect('/default/pricelists/');
    }
    
    public function alldelete(){
        $this->model->alldelete();
        Router::redirect('/default/pricelists/');
    }

        public function edit(){
        if($_REQUEST){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if($result){
                Session::setFlash('Item was saved.');
            }else{
                Session::setFlash('Error.');
            }
            Router::redirect('/default/pricelists/');
        }
        if(isset($this->params[0])){ //проверяем передан ли id страницы в кач. параметра
            $this->data['item'] = $this->model->getById($this->params[0]);
        } else { //если параметр не задан выведен сообщение и перенаправим пользов на список страниц
            //Session::setFlash('Wrong page id.');
        Router::redirect('/default/pricelists/');
        }
    }
}