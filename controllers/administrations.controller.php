<?php

class AdministrationsController extends Controller{
    
    public static $to;
    public static $subject;
    public static $message;
    public static $headers;

    public function __construct($data = array()) {
            parent::__construct($data); // вызываем конструктор из родительского класса с атрибутом data в кот.храняться данные для представления
            $this->model = new Administration();
        }
    
    public function addusers() {
        if($_POST){
            if($this->model->saveUser($_POST)){
                    Session::setFlash('Пользователь добавлен!');
                    self::$to = $_POST['newemail'];
                    self::$subject = 'New User';
                    self::$message = '
                            <html>
                                <title>'.self::$subject.'</title>
                            <head>
                            </head>
                            <body>
                            <p style="font-weight:bold">New user - 
                            '.$_POST['newlogin'].'
                            was added!</p>
                            <p>Details: 
                            '.$_POST['newfullname'].'<br/>
                            '.$_POST['newemail'].'<br/>
                            '.$_POST['newrole'].'<br/>
                            '.$_POST['newpassword'].'</p>
                            </body>
                            </html>
                            ';
                    self::$headers = "Content-type: text/html; charset=utf-8 \r\n";
                    self::$headers .= "From: zenonbambolino@bestplace.in.ua \r\n";
                    mail(self::$to,  self::$subject,  self::$message,  self::$headers);
            }
        }
    }
    
    public function editusers() {
        $this->data = $this->model->getUsersList();
    }
    
    public function delete(){
        if(isset($this->params[0])){
            $result = $this->model->deleteUser($this->params[0]);
            if($result){
                Session::setFlash('Item was delete.');
            }else{
                Session::setFlash('Error.');
                }
        }
        Router::redirect('/administrations/editusers/');
    }
    
    public function edit(){
        if($_REQUEST){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->saveUser($_POST, $id);
            if($result){
                Session::setFlash('User was saved.');
            }else{
                Session::setFlash('Error.');
            }
            Router::redirect('/administrations/editusers/');
        }
        if(isset($this->params[0])){ //проверяем передан ли id страницы в кач. параметра
            $this->data['item'] = $this->model->getById($this->params[0]);
        } else { //если параметр не задан выведен сообщение и перенаправим пользов на список страниц
            //Session::setFlash('Wrong page id.');
        Router::redirect('/administrations/editusers/');
        }
    }
}
