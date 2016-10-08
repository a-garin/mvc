<?php

class Db
{
    
    public static function getConnection ()
    {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include ($paramsPath);
        
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";

        // при использовании PDO исполуезтся ООП подход
        //созадем объект класса PDO, передаем парам. для соединения
        // при помщи объекта будем объекта $db будем общаться с БД
        //$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $db = new PDO($dsn, $params['user'], $params['password']);

        //if ($db->connect_errno) { die('Ошибка соединения: ' . $db->connect_error); }else{echo 'Connect true';}
        
        //надо использовать кодировку
        $db->exec("set names utf8");
        
        return $db;
    }
    
}