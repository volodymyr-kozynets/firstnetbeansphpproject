<?php

// App отвечает за обработку запросов и вызывает необходимый контроллер и методы контроллеров

class App {

    protected static $router; // свойство для работы с обьектом роутера
    
    public static $db; //свойство через кот.можем получать доступ к базе данных из любого места приложения

    public static function getRouter(){
        return self::$router;
    }
    
    //метод Run контроллера App, вызывает заданные в URI контроллер и метод
    public static function run($uri){ // run отвечает за обработку запросов к приложению
        self::$router = new Router($uri); // и получает обьект роутера с распарсенным uri

        self::$db = new DB(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));//создаем подключение к БД во время включения приложения
        
        $controller_class = ucfirst(self::$router->getController()).'Controller'; // из обекта созданного классом роутер получаем тип используемого контроллера (грубо говоря получаем тип контроллера из распарсенного URI)
        $controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());
        
        //Проверяем выполнение пользователем входя в систему
        //При каждом запросе к роуту admin необходимо проверять имеет ли пользователь на это право
        /*$layout = self::$router->getRoute();
        if( $layout == 'admin' && Session::get('role') !='admin'){
            if( $controller_method !='admin_login' ){
                Router::redirect('/admin/users/login');
            }
        }*/
        $layout = self::$router->getRoute();
        if(empty(Session::get('login')) && empty(Session::get('role'))){
            if( $controller_method !='admin_login' ){
                Router::redirect('/admin/users/login');
            }
        }
        $adminlayout = self::$router->getController();
        if($adminlayout == 'administrations' && Session::get('role') != 'superadmin'){
                Router::redirect('/default/');
        }
        
        //В Зависимости от заданного имени контроллера в URI, создаем соответствующий обьект (напр. если контроллер был Pages то создается обьект класса Pages)
        $controller_object = new $controller_class();
        if(method_exists($controller_object, $controller_method)){ //проверяем существование метода у заданного контроллера и записываем его в переменную $view_path
            $view_path = $controller_object->$controller_method();//получаем название файла представления на основании того какие кнтроллер и метод использован
            $view_object = new View($controller_object->getData(), $view_path);//создаем обьект класса View с переданным ему в кач.аргументов данные из метода (файла HTML шаблона) вызываевомого котнроллера и названием файла шаблона
            $content = $view_object->render(); //ниже по коду используется как 'content'
        } else {
            throw new Exception('Method '.$controller_method.' of class '.$controller_class.'does not exist');
        }
        
        //выводим главный шаблон представления ("главных" может быть несколько и зависит от имени роутера)
        //шаблон будет выведен при запуске метода Run класса App
        $layout_path = VIEWS_PATH.DS.$layout.'.html';
        $layout_view_object = new View(compact('content'), $layout_path);// создаем обьект с параметрами: content и путем к файлу главного шаблона
        echo $layout_view_object->render(); //выводим с помощью рендера полученный HTML код
        //таким образом мы сложили "бутерброд" - $layout_view_object из вложенных друг в друга обьектов view
        //а потом методом echo render() вывели содержимое данного обьекта
    }
}
