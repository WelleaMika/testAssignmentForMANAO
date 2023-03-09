<?php

namespace Test\Controllers;

use Test\View\View;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }


    public function main()
    {
        if(!isset($_COOKIE['login']))
        {
            header("Location: /users/login");
            die();
        }
        
            $name = $_COOKIE['login'];

        $this->view->renderHtml('main/main.php', ['name' => $name], 'Hello');
    }

}
