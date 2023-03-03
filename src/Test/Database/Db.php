<?php

namespace Test\Database;

Class Db
{

    static public function createUser($login, $password, $email, $name)
    {
        $json = file_get_contents(__DIR__ . '/db.json');
        $data = json_decode($json, true);
        $id = count($data);
        $newUser = array(
            'id'       => $id,
            'login'    => $login,
            'password' => $password,
            'email'    => $email,
            'name'     => $name
        );
        $data[] = $newUser;
        $finaldata = json_encode($data);
        file_put_contents(__DIR__ . '/db.json',$finaldata);

    }

    static public function readUser($id)
    {
        $json = file_get_contents(__DIR__. '/db.json');
        $data = json_decode($json, true);
        $userData = $data[$id];
        return $userData;
        
    }

    static public function updateUser($id, $type, $newInfo)
    {
        $json = file_get_contents(__DIR__. '/db.json');
        $data = json_decode($json, true);
        $data[$id][$type] = $newInfo;
        $finaldata = json_encode($data);
        file_put_contents(__DIR__. '/db.json',$finaldata);
    }

    static public function deleteUser($id)
    {
        $json = file_get_contents(__DIR__ . '/db.json');
        $data = json_decode($json, true);
        unset($data[$id]);
        $finaldata = json_encode($data);
        file_put_contents(__DIR__. '/db.json',$finaldata);
    }

    static public function uniquenessCheck($type, $info)
    {
        $json = file_get_contents(__DIR__ . '/db.json');
        $data = json_decode($json, true);
        $id   = count($data);
        foreach ($data as $userCard)
        {
            if ($userCard[$type] == $info)
            {
                return false;
            }
        }
        return true;
    }

    static public function getPassword($type, $info)
    {
        $json = file_get_contents(__DIR__ . '/db.json');
        $data = json_decode($json, true);
        $id   = count($data);
        foreach ($data as $userCard)
        {
            if ($userCard[$type] == $info)
            {
                return $userCard['password'];
            }
        }
    }
}