<?php
/**
 * Класс User - модель для работы с пользователями
 */
class User
{
    /**
    * Регистрация пользователя 
    * @param string $name Имя
    * @param string $password Пароль
    * @param string $login Логин
    * @param string $email E-mail
    * @param string $country Страна
    * @param integer $birthday Дата Рождения
    * @return boolean Результат выполнения метода
    */
    public static function register($name, $password, $login, $email, $country, $birthday)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'INSERT INTO user (name, password, login, email, country, birthday) '
                . 'VALUES (:name, :password, :login, :email, :country, :birthday)';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $hashPassword = md5($password);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $hashPassword, PDO::PARAM_STR);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':country', $country, PDO::PARAM_STR);
        $result->bindParam(':birthday', $birthday, PDO::PARAM_INT);
        return $result->execute();
    }
     /**
     * Выбор списка стран из базы
     * @return array Массив с названиями стран
     */
    public static function getCountries()
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "SELECT * FROM net_country ORDER BY name_ru ASC";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    /**
     * Проверяем существует ли пользователь с заданными $email и $password или с $login и $password
     * @param string $login E-mail или Логин
     * @param string $password Пароль
     * @return mixed : integer user id or false
     */
    public static function checkUserData($login, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            // Текст запроса к БД
            $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';
            $result = $db->prepare($sql);
            $result->bindParam(':email', $login, PDO::PARAM_STR);
        } else {
            // Текст запроса к БД
            $sql = 'SELECT * FROM user WHERE login = :login AND password = :password';
            // Получение результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':login', $login, PDO::PARAM_STR);
        }
        $hashPassword = md5($password);
        $result->bindParam(':password', $hashPassword, PDO::PARAM_STR);
        $result->execute();
        // Обращаемся к записи
        $user = $result->fetch();
        if ($user) {
            // Если запись существует, возвращаем id пользователя
            return $user['id'];
        }
        return false;
    }
    /**
     * Запоминаем пользователя
     * @param integer $userId id пользователя
     */
    public static function auth($userId)
    {
        // Записываем идентификатор пользователя в сессию
        $_SESSION['user'] = $userId;
    }
    /**
     * Возвращает идентификатор пользователя, если он авторизирован.
     * Иначе перенаправляет на страницу входа
     * @return string Идентификатор пользователя
     */
    public static function checkLogged()
    {
        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header("Location: /CodeIt/user/login");
    }
    /**
     * Проверяет является ли пользователь гостем
     * @return boolean Результат выполнения метода
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }
    /**
     * Проверяет имя: не меньше, чем 2 символа
     * @param string $name Имя
     * @return boolean Результат выполнения метода
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }
     /**
     * Проверяет логин: не меньше, чем 5 символов
     * @param string $login Логин
     * @return boolean Результат выполнения метода
     */
    public static function checkLogin($login)
    {
        if (strlen($login) >= 5) {
            return true;
        }
        return false;
    }
    /**
     * Проверяет пароль: не меньше, чем 6 символов
     * @param string $password Пароль
     * @return boolean Результат выполнения метода
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }
    /**
     * Проверяет email
     * @param string $email E-mail
     * @return boolean Результат выполнения метода
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    /**
     * Проверяет дату Рождения
     * @param string $birthday Дата Рождения
     * @return boolean Результат выполнения метода
     */
    public static function checkBirthday($birthday)
    {
        if (filter_var($birthday, FILTER_VALIDATE_REGEXP, array(
            'options'=>array(
                'regexp'=>'/(\d{4})[-|.](0\d|1[012])[-|.]([0-2]\d|3[01])/')))) {
            return true;
        }
        return false;
    }
    /**
     * Проверяет не занят ли email другим пользователем
     * @param type $email E-mail
     * @return boolean Результат выполнения метода
     */
    public static function checkEmailExists($email)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn())
            return true;
        return false;
    }
    /**
     * Проверяет не занят ли login другим пользователем
     * @param type $login login
     * @return boolean Результат выполнения метода
     */
    public static function checkLoginExists($login)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'SELECT COUNT(*) FROM user WHERE login = :login';
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn())
            return true;
        return false;
    }
    /**
     * Возвращает пользователя с указанным id
     * @param integer $id id пользователя
     * @return array Массив с информацией о пользователе
     */
    public static function getUserById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'SELECT * FROM user WHERE id = :id';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
}