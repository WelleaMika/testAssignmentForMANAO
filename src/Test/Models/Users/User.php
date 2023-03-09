<?php


namespace Test\Models\Users;

use Test\Exceptions\InvalidArgumentException;
use Test\Database\Db;

        /*
        Так как в задании не указано, что mbstring подключен,
        дальнейшая проверка включает в себя проверку
        на отсутсивие кирилицы. Чтобы можно было 
        проверить длину строки.

        В случае если mbstring был бы подключен, то проверка на 
        кирилицу была бы убрана, а функции strlen заменены на
        mb_strlen.
        */

class User
{
    public static $place = '';

    public static function signUp(array $userData)
    {

        $login           = $userData['login'];
        $password        = $userData['password'];
        $confirmPassword = $userData['confirmPassword'];
        $email           = $userData['email'];
        $name            = $userData['name'];

        $email           = strtolower($email);
        $domain          = strstr($email, '@');
        $numbersOfPoint  = substr_count($domain, '.');
        $numbersOfAt     = substr_count($domain, '@');

        if (empty($login)) {
            self::$place = 'loginError';
            throw new InvalidArgumentException('Not transmitted login');
        } elseif (str_replace(' ', '', $login)!=$login) {
            self::$place = 'loginError';
            throw new InvalidArgumentException('Spaces in login are not allowed');
        } elseif (preg_match("/[А-Яа-яЁё]/", $login)) {
            self::$place = 'loginError';
            throw new InvalidArgumentException('Cyrillic in login are not allowed');
        } elseif (strlen($login) < 6) {
            self::$place = 'loginError';
            throw new InvalidArgumentException('Length of login too short. <br> Minimum 6 characters');
        } elseif (!Db::uniquenessCheck('login', $login)) {
            self::$place = 'loginError';
            throw new InvalidArgumentException('A user with this login already exists');
        }

        if (empty($password)) {
            self::$place = 'passwordError';
            throw new InvalidArgumentException('Not transmitted password');
        } elseif (str_replace(' ', '', $password) != $password) {
            self::$place = 'passwordError';
            throw new InvalidArgumentException('Spaces in password are not allowed');
        } elseif (preg_match("/[А-Яа-яЁё]/", $password)) {
            self::$place = 'passwordError';
            throw new InvalidArgumentException('Cyrillic in password are not allowed');
        } elseif (strlen($password) < 6) {
            self::$place = 'passwordError';
            throw new InvalidArgumentException('Length of password too short. <br> Minimum 6 characters');
        } elseif (preg_match("/[A-Za-z]/", $password) XOR preg_match("/[0-9]/", $password)) {
            self::$place = 'passwordError';
            throw new InvalidArgumentException('Password must contain at least 1 letter and 1 digit');
        } elseif (preg_match("/[^a-zA-Z0-9]/", $password)) {
            self::$place = 'passwordError';
            throw new InvalidArgumentException('Password must contain only numbers and letters');
        }

        if (empty($confirmPassword)) {
            self::$place = 'confirmPasswordError';
            throw new InvalidArgumentException('Not transmitted password');
        } elseif ($confirmPassword != $password) {
            self::$place = 'confirmPasswordError';
            throw new InvalidArgumentException('The passwords don\'t match');
        }

        if (empty($email)) {
            self::$place = 'emailError';
            throw new InvalidArgumentException('Not transmitted email');
        } elseif (str_replace(' ', '', $email) != $email) {
            self::$place = 'emailError';
            throw new InvalidArgumentException('Spaces in email are not allowed');
        } elseif (!$domain) {
            self::$place = 'emailError';
            throw new InvalidArgumentException('Domain is not specified');
        } elseif ($numbersOfPoint !== 1 || $numbersOfAt !== 1) {
            self::$place = 'emailError';
            throw new InvalidArgumentException('The domain is not specified correctly');
        } elseif (!Db::uniquenessCheck('email', $email)) {
            self::$place = 'emailError';
            throw new InvalidArgumentException('A user with this email already exists');
        }

        if (empty($name)) {
            self::$place = 'nameError';
            throw new InvalidArgumentException('Not transmitted name');
        }elseif (str_replace(' ', '', $name) != $name) {
            self::$place = 'nameError';
            throw new InvalidArgumentException('Spaces in name are not allowed');
        } elseif (preg_match("/[А-Яа-яЁё]/", $name)) {
            self::$place = 'nameError';
            throw new InvalidArgumentException('Cyrillic in name are not allowed');
        } elseif (preg_match("/[^a-zA-Z]/", $name)) {
            self::$place = 'nameError';
            throw new InvalidArgumentException('Unacceptable characters in the name');
        } elseif (strlen($name) < 2 || strlen($name) > 15) {
            self::$place = 'nameError';
            throw new InvalidArgumentException('The length of the name is incorrect. <br> min 2 char,max 15 char');
        }
        
        $password = sha1($password . 'manao');
        Db::createUser
        (
            $login,
            $password,
            $email,
            $name,
        );
        self::$place = 'result';
        throw new InvalidArgumentException('successfully');
        
    }

    public static function signIn(array $userData)
    {
        $login    = $userData['login'];
        $password = $userData['password'];
        $hashPass = sha1($password . 'manao');
        
        if (empty($login)) {
            self::$place = 'loginError';
            throw new InvalidArgumentException('Not transmitted login');
        } elseif (Db::uniquenessCheck('login', $login)) {
            self::$place = 'loginError';
            throw new InvalidArgumentException('The user with this login does not exist');
        }
        
        if (empty($hashPass)) {
            self::$place = 'passwordError';
            throw new InvalidArgumentException('Not transmitted login');
        } elseif (Db::getPassword('login', $login) !== $hashPass) {
            self::$place = 'passwordError';
            throw new InvalidArgumentException('The password does not match');
        }
        self::setCookie($login, $hashPass);
        self::$place = 'main';
        throw new InvalidArgumentException();
    }
    public static function setCookie($login, $password)
    {
        session_start();
        $_SESSION['login']    = $login;
        $_SESSION['password'] = $password;
        setcookie('login', $login, 0, '/');
        setcookie('password', $password, 0, '/');
    }
}
