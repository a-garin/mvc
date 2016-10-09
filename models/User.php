<?php

class User
{
    public static function register($name, $email, $password) {
        
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO user (name, email, password) '
                . 'VALUES (:name, :email, :password)';
        
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        
        // выполняем запрос, и возвращаем результат, булево значение
        return $result->execute();
    }
    
    /**
     * Проверяет имя: не меньше, чем 2 символа
     */
    public static function checkName($name) {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }
    
    /**
     * Проверяет имя: не меньше, чем 6 символов
     */
    public static function checkPassword($password) {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }
    
    /**
     * Проверяет email
     */
    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    
    public static function checkEmailExists($email) {
        
        $db = Db::getConnection();
        
        // подгатовлденный запрос. Не передаем прямо наш параметр, а используем специальный лайсхолдер
        //Для избежания sql инекций
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';
        
        $result = $db->prepare($sql);
        
        // плэйсхорлдер заменен нашим параметром
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        //проверка, есть ли записи
        if($result->fetchColumn())
            return true;
        return false;
    }
    
}