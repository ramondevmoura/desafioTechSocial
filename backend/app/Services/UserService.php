<?php

namespace Services; // Adicione o namespace

use User;

require_once __DIR__ . '/../Models/User.php';
class UserService
{

    public function getAllUsers()
    {
        return User::all();
    }
    public function createUser($userData)
    {
        try {
            return User::create($userData);
        } catch (\Exception $e) {
            error_log('Erro ao criar usuário: ' . $e->getMessage());
            var_dump($e->getMessage());
            return false;
        }
    }
}