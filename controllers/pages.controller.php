<?php

//Данный контролер Pages и его метод index установлены в файле config по умолчанию (т.е. если в URI запросе к localhost не указано ничего то по умолчанию будут вызван контроллер и его метод из config)
//Pages.controller отвечает за отображение простых страниц сайта
//Методы контроллеров должны быть public
//сами контроллеры ничего не выводят, задача контроллера собрать данные которые будут переданы представлению в свойстве $data

class PagesController extends Controller{
    
    public function __construct($data = array()){
        parent::__construct($data); // вызываем конструктор из родительского класса с атрибутом data в кот.храняться данные для представления
        $this->model = new Page();
        
    }

    public function index(){ //метод (установленный по умолчанию) index контроллера Pages будет выводить список всех страниц
        $this->data['pages'] = $this->model->getList(); //записываем свойство $data нашего контроллера
    }
    
    public function view(){ //метод view получает алиас страницы из параметров запроса (то что идет четвертое по счету в URI)
        $params = App::getRouter()->getParams();
        if(isset($params[0])){
            $alias = strtolower($params[0]);
            $this->data['view_page'] = $this->model->getByAlias($alias); //записываем свойство $data нашего контроллера

        }
    }
    
    public function admin_index(){
        $this->data['pages'] = $this->model->getList();
    }
    
    public function admin_add(){
        if($_POST){
            $result = $this->model->save($_POST);
            if($result){
                Session::setFlash('Page was saved.');
            }else{
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/pages/');
        }
    }

    public function admin_edit(){
        if($_POST){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if($result){
                Session::setFlash('Page was saved.');
            }else{
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/pages/');
        }
        if(isset($this->params[0])){ //проверяем передан ли id страницы в кач. параметра
            $this->data['page'] = $this->model->getById($this->params[0]);
        } else { //если параметр не задан выведен сообщение и перенаправим пользов на список страниц
            //Session::setFlash('Wrong page id.');
            Router::redirect('/admin/pages/');
        }
    }
    
    public function admin_delete(){
        if(isset($this->params[0])){
            $result = $this->model->delete($this->params[0]);
             if($result){
                Session::setFlash('Page was delete.');
            }else{
                Session::setFlash('Error.');
            }
        }
        Router::redirect('/admin/pages/');
    }
}
