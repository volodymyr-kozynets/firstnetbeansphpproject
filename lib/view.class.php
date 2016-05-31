<?php
//Класс который будет отвечать за работу с представлениями
//Обьекты класса View будут создаваться во всех слуаях когда нам нужно будет использовать представление (передавать в них данные и получать готовый HTML код)
class View {
    
    protected $data; //хранение данных перед. от контроллеров в представление
    
    protected $path; //содержит путь к текущему файлу представления
    
    protected static function getDefaultViewPath(){ //Определяет путь к шаблону на основании названий роута, контроллера и экшена из обьекта Router
        $router = App::getRouter(); //получаем роутер
        if(!$router){
            throw new Exception('Unknown type of router '.$router);
        }
        $controller_dir = $router->getController(); //получаем контроллер и именуем им директорию в которой будет находится файл шаблона
        //название HTML шаблона будет совпадать с назв. метода контроллера и будет начинаться с префикса метода
        $template_name = $router->getMethodPrefix().$router->getAction().'.html';
        return $path = VIEWS_PATH.DS.$controller_dir.DS.$template_name; //возвращаем полный путь к файлу шаблона
    }

    public function __construct($data = array(), $path = null){
        if(!$path){
            $path = self::getDefaultViewPath(); //записывается название шаблона по умолчанию если он не был задан при создании обьекта View
        }
        if(!file_exists($path)){ //проверяем существование файла шаблона
            throw new Exception('Template file is not found in path '.$path);
        }
        $this->path = $path; //записываем название файла шаблона в переменную если оно было указано при создании класса View
        $this->data = $data;
    }
    
    public function render(){ //метод создания шаблона, возвращает HTML код
        $data = $this->data; //важно что эта переменная будет видна в самом шаблоне, это связывающее звено между контроллером и самим шаблоном
        
        ob_start(); //включаем буфферизацию вывода, что бы получить готовый HTML шаблон в буффере
        include($this->path); //указываем путь к шаблону
        $content = ob_get_clean(); //HTML код записан в переменную content

        return $content;
    }
}
