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

    public function actionLogin()
    {
        $email = '';
        $password = '';

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            // Валидация полей
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            // Проверяем существует ли пользователь
            $userId = User::checkUserData($email, $password);

            //если пользователя не сущесвует
            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                // Если данные правильные, запоминаем пользователя (сессия) - передаем его индификатор
                User::auth($userId);

                // Перенаправляем пользователя в закрытую часть - кабинет 
                header("Location: /cabinet/");
            }

        }

        require_once(ROOT . '/views/user/login.php');

        return true;
    }

    /**
     * Удаляем данные о пользователе из сессии
     */
    public function actionLogout()
    {
        session_start();
        unset($_SESSION["user"]);
        header("Location: /");
    }


}
