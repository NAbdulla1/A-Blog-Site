<?php

namespace Blog\models;
class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $profile_pic_path;
    public $isAdmin;

    public function __construct($id, $name, $email, $password, $profile_pic_path, $isAdmin = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->profile_pic_path = $profile_pic_path;
        $this->isAdmin = $isAdmin;
    }
}