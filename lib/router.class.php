<?php
// Класс диспетчера (роутера) приложения, парсит uri запрос

class Router {
    
    protected $uri;
    
    protected $controller;
    
    protected $action;
    
    protected $params;
    
    protected $route;
    
    protected $method_prefix;

    public function __construct($uri){
        $this->uri = urldecode(trim($uri, '/'));
        
        // Получение настроек по умолчанию из настроек в файле config.php
        $routes = Config::get('routes');
        $this->route = Config::get('default_route');
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->controller = Config::get('default_controller');
        $this->action = Config::get('default_action');
        $this->params = Config::get('default_alias');
        
        // Разбираем uri и убираем лишние символы
        $uri_parts = explode('?', $this->uri);
        
        // Get path like /controller/action/param1/param2
        $path = $uri_parts[0];
        
        $path_parts = explode('/', $path); //Получили массив из разобранных елем. uri
                
        if(count($path_parts)){
            
            //Получаем и присваиваем route через первый елемент uri
            //Проверяем совпадает ли значение из массива uri со значением routes записанным в настройках config 
            //Если совпадает то записываем первый елемент uri как свойство $route и в $method_prefix
            if(in_array(strtolower(current($path_parts)), array_keys($routes))){
                $this->route = strtolower(current($path_parts)); //admin или default
                $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : ''; // проверяем установлен ли в config значение routes
                array_shift($path_parts); //сдвигаем метку текущего елем.массива на следующий елем.
                
            }
            //Получаем и присваиваем controller через второй елемент uri
            if(current($path_parts)){
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts); //сдвигаем
            }
            //Получаем и присваиваем action через третий елемент uri
            if(current($path_parts)){
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts); //сдвигаем
            }
            //Все остальные елементы uri рассматриваем как доп.параметрsы
            /*if(current($path_parts)){
                $this->params = strtolower(current($path_parts));
                array_shift($path_parts); //сдвигаем
            }*/
            $this->params = $path_parts;
        }
    }
    
    public static function redirect($location){ // функция перенаправления с аргументом в кот.содерж. адрес цели
        header("Location: $location");
    }

    public function getUri(){
        return $this->uri;
    }
    public function getController(){
        return $this->controller;
    }
    public function getAction(){
        return $this->action;
    }
    public function getParams(){
        return $this->params;
    }
    public function getRoute(){
        return $this->route;
    }
    public function getMethodPrefix(){
        return $this->method_prefix;
    }
}
