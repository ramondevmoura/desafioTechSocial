<?php

namespace app\Controllers;

use Services\UserService;
use UserValidator;

class UserController
{
    private $userService;
    private $userValidator;

    public function __construct(UserService $userService, UserValidator $userValidator)
    {
        $this->userService = $userService;
        $this->userValidator = $userValidator;
    }

    public function getAllUsers()
    {
        $users = $this->userService->getAllUsers();

        // Verifique se há usuários retornados
        if ($users) {
            echo json_encode(['success' => true, 'users' => $users]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhum usuário encontrado']);
        }
    }

    public function createUser(array $data)
    {

        // Valida os dados do usuário
        if (!$this->userValidator->validateUserData($data)) {
            echo json_encode(['success' => false, 'message' => 'Dados do usuário inválidos']);
            return;
        }

        // Tenta criar o usuário
        $user = $this->userService->createUser($data);


        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao criar usuário']);
        }
    }
}