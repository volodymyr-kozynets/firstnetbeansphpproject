<?php
// работает с блоками алерт-сообщений

class Session {
    
    protected static $flash_message; //содержит текст передаваемого сообщения
    
    public static function setFlash($message){ // устанавливает текст сообщения в свойство flash_message
        self::$flash_message = $message;
    }
    
    public static function hasFlash(){ //проверяет наличие послания для пользователя
        return !is_null(self::$flash_message);
    }
    
    public static function flash(){
        /*echo "<pre>";
        print_r(self::$flash_message);*/
        echo self::$flash_message;
        self::$flash_message = null;
    }
    
    public static function set($key, $value){ //запись данных в массив session по ключу
        $_SESSION[$key] = $value;
    }
    
    public static function get($key){ //получение данных из массива session, например логина авториз. пользователя
        if(isset($_SESSION[$key])){
            return $_SESSION[$key]; 
        }
        return null;
    }
    
    public static function delete($key){ //будет (unset) удалять значение по ключу из массива session
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]); 
        }
    }
    
    public static function destroy(){ //уничтожаем сессию при выходе пользователя из системы
        session_destroy();
    }
}
