<?php
//отвечает за соединение с базой данных
//создает обьект подключения mysqli
//главная задача выполнять запросы от базы данных и получать их результаты
class DB {
    
    protected $connection; 
    
    public function __construct($host, $user, $password, $db_name){
        $this->connection = new mysqli($host, $user, $password, $db_name);
        
        if(mysqli_connect_error()){
            throw new Exception('Could not connect to DB');
        }
    }
    
    public function query($sql) { //метод с запросом к БД в параметрах метода
        if(!$this->connection){
            return false;
        }
        $result = $this->connection->query($sql);//
        
        if(mysqli_error($this->connection)){
            throw new Exception(mysqli_error($this->connection));
        }
        if(is_bool($result)){
            return $result;
        }
        $data = array();
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;//возвращаем свойство с результатом ответа от БД
    }
    
    public function escape($str){
        return mysqli_escape_string($this->connection, $str);
    }
}
