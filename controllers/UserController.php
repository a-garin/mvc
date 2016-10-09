<?php

class UserController
{

    public function actionRegister()
    {
        // иницилизируем переменные пустыми строками
        $name = '';
        $email = '';
        $password = '';
        $result = false;
        
        //Проверям POST submit  на сущусвование
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // иницилизируем переменную как ошибок НЕТ
            $errors = false;
            
            //Передаем переменные статистическим методам класса User
            //Если false, то у нас ошибка, выводим сообщение об ошибке
            
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            //если email сущесвует (true), то ошибка
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }
            
            // Если ошибок нет, вызываем статистический метод register класса User  и передаем параметры регистрации
            if ($errors == false) {
                //результат в переменной $result, булево значение
                $result = User::register($name, $email, $password);
            }

        }


        require_once(ROOT . '/views/user/register.php');

        return true;
    }

}
