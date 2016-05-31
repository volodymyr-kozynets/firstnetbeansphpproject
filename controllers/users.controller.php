<?php
//взаимодействует с моделью User

class UsersController extends Controller {
    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new User();
    }
    
    public function admin_login(){ //выводит и обрабатывает форму логин
        if($_POST && isset($_POST['login']) && isset($_POST['password'])){
            $user = $this->model->getByLogin($_POST['login']);
            $hash = md5(Config::get('salt').$_POST['password']);
            if( $user && $user['is_active'] && $hash == $user['password'] ){ //проверяем правильность введенного логина и пароля и что пользователь прошел аутентификацию
                Session::set('login', $user['login']);
                Session::set('role', $user['role']);
            }
            Router::redirect('/admin/');
        }
    }
    
    public function admin_logout(){ //данный метод не требует View-файла admin_logout.html так как он ничего не выводит
        Session::destroy();
        Router::redirect('/admin/');
    }
}
