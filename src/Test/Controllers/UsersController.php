<?php

namespace Test\Controllers;

use Test\Exceptions\InvalidArgumentException;
use Test\Models\Users\User;
use Test\View\View;

class UsersController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function signUp()
    {
    if (!empty($_POST && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
        try {
            $user = User::signUp($_POST);
        } catch (InvalidArgumentException $e) {
            $place = User::$place;
            print_r(json_encode(['text' => $place,'message' => $e->getMessage()]));
            return ;
        }
    }
    $this->view->renderHtml('users/signUp.php', ['name' => 'User'], 'Sign Up');
    }

    public function signIn()
    {
        if(isset($_COOKIE['login'])) 
        {
            header("Location: /");
            die();
        }
        if (!empty($_POST && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            try {
                $user = User::signIn($_POST);
            } catch (InvalidArgumentException $e) {
                $place = User::$place;
                print_r(json_encode(['text' => $place,'message' => $e->getMessage()]));
                return ;
            }
        }
    $this->view->renderHtml('users/signIn.php', ['name' => 'User'], 'Sign In');
    }
}