<?php

return [
    '~^users/register$~' => [\Test\Controllers\UsersController::class, 'signUp'],
    '~^users/login$~' => [\Test\Controllers\UsersController::class, 'signIn'],
    '~^$~' => [\Test\Controllers\MainController::class, 'main'],
];