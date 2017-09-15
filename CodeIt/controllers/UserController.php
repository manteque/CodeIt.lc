<?php
/**
 * Контроллер UserController
 */
class UserController
{
    /**
     * Action для страницы "Регистрация"
     */
    public function actionRegister()
    {
        $countries = User::getCountries();
        // Переменные для формы
        $country = false;
        $birthday = false;
        $login = false;
        $name = false;
        $email = false;
        $password1 = false;
        $password2 = false;
        $result = false;
        $agree = false;
        // Обработка формы
        if (isset($_POST['submit'])) {

            // Если форма отправлена 
            // Получаем данные из формы
            $name = $_POST['name'];
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            $login = $_POST['login'];
            $email = $_POST['email'];
            $country = $_POST['country'];
            $birthday  = $_POST['birthday'];

            // Флаг ошибок
            $errors = false;
            // Валидация полей
            if (!isset($_POST['agree'])) {
                $errors[] = 'Вы должны принять условия соглашения';
            }
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkPassword($password1)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if ($password1 != $password2) {
                $errors[] = 'Пароли должны совпадать';
            }
            if (!User::checkLogin($login)) {
                $errors[] = 'Login не должен быть короче 5-ти символов';
            }
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
             if (!User::checkBirthday($birthday)) {
                $errors[] = 'Неправильная дата';
            }
            if (User::checkLoginExists($login)) {
                $errors[] = 'Такой Login уже используется';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }
            
            if ($errors == false) {
                // Если ошибок нет
                $birthday = strtotime($_POST['birthday']);
                // Регистрируем пользователя
                $result = User::register($name, $password1, $login, $email, $country, $birthday);
                 // Проверяем существует ли пользователь
                $userId = User::checkUserData($login, $password1);

                User::auth($userId);
                // Перенаправляем пользователя в закрытую часть - кабинет 
                header("Location: ../user/cabinet");
            }
        }
        // Подключаем вид
        require_once(ROOT . '/views/user/register.php');
        return true;
    }
    /**
     * Action для страницы "Вход на сайт"
     */
    public function actionLogin()
    {
        // Переменные для формы
        $login = false;
        $password = false;
        
        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена 
            // Получаем данные из формы
            $login = $_POST['login'];
            $password = $_POST['password'];
            // Флаг ошибок
            $errors = false;
            // Валидация полей
            if (!User::checkLogin($login)) {
                $errors[] = 'Неправильный логин или email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if ($errors == false) {
                // Проверяем существует ли пользователь
                $userId = User::checkUserData($login, $password);
                if ($userId == false) {
                    // Если данные неправильные - показываем ошибку
                    $errors[] = 'Неправильные данные для входа на сайт';
                } else {
                    // Если данные правильные, запоминаем пользователя (сессия)
                    User::auth($userId);
                    // Перенаправляем пользователя в закрытую часть - кабинет 
                    header("Location: ../user/cabinet");
                }
            }
        }
        // Подключаем вид
        require_once(ROOT . '/views/user/login.php');
        return true;
    }
    /**
     * Action для страницы "Кабинет пользователя"
     */
    public function actionCabinet()
    {
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
        // Подключаем вид
        require_once(ROOT . '/views/user/cabinet.php');
        return true;
    }


    /**
     * Удаляем данные о пользователе из сессии
     */
    public function actionLogout()
    {
        // Удаляем информацию о пользователе из сессии
        unset($_SESSION["user"]);
        // Перенаправляем пользователя на главную страницу
        require_once(ROOT . '/views/user/login.php');
        return true;
    }
}