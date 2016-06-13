<?php

//Конфигурационный файл приложения - содержит настройки по умолчанию, название приложения, параметры базы данных

Config::set('site_name', 'ЦОК_Накладная');

//Роуты. Имя роута => Префикс метода

Config::set('routes', array(
    'default' => '',
    'admin' => 'admin_'
));

Config::set('default_route', 'default');
Config::set('default_controller', 'pages');
Config::set('default_action', 'index');
Config::set('default_alias', 'about');

Config::set('db.host','localhost');
Config::set('db.user','root');
Config::set('db.password','');
Config::set('db.db_name','mvc');

Config::set('salt', 'z3dc8vd9m39m9cmcdkm10dc'); //спец.настройка - соль - строка со случайным набором символов - используется с генерацией хеша пароля

Config::set('cells', array(
    'A'=>'code',
    'B'=>'name',
    'C'=>'price'
    ));
