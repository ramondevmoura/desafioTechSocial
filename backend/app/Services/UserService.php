<?php

namespace Services;

use CryptoService;
use User;

require_once __DIR__ . '/../Security/ CryptoService.php';
require_once __DIR__ . '/../Models/User.php';

class UserService
{
    private $cryptoService;

    public function __construct(CryptoService $cryptoService)
    {
        $this->cryptoService = $cryptoService;
    }

    public function getAllUsers()
    {
        // Recupera todos os usuários do banco de dados
        $users = User::all();

        // Descriptografa os dados sensíveis de cada usuário
        foreach ($users as $user) {
            $user->email = $this->cryptoService->decrypt($user->email);
            $user->document = $this->cryptoService->decrypt($user->document);
            $user->phone_number = $this->cryptoService->decrypt($user->phone_number);
        }

        return $users;
    }

    public function createUser($userData)
    {
        // Criptografa os dados sensíveis antes de persisti-los no banco de dados
        $userData['password'] = $this->cryptoService->encryptPassword($userData['password']);
        $userData['email'] = $this->cryptoService->encrypt($userData['email']);
        $userData['document'] = $this->cryptoService->encrypt($userData['document']);
        $userData['phone_number'] = $this->cryptoService->encrypt($userData['phone_number']);

        try {
            // Tenta criar o usuário
            return User::create($userData);
        } catch (\Exception $e) {
            // Em caso de erro, registre-o e retorne falso
            error_log('Erro ao criar usuário: ' . $e->getMessage());
            var_dump($e->getMessage());
            return false;
        }
    }

    public function updateUser($id, $userData)
    {
        try {
            // Encontra o usuário pelo ID
            $user = User::find($id);

            // Verifica se o usuário foi encontrado
            if ($user) {
                // Atualiza os dados do usuário
                $user->update($userData);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            error_log('Erro ao atualizar usuário: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($id)
    {
        try {
            // Encontra o usuário pelo ID
            $user = User::find($id);

            // Verifica se o usuário foi encontrado
            if ($user) {
                // Exclui o usuário
                $user->delete();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            error_log('Erro ao excluir usuário: ' . $e->getMessage());
            return false;
        }
    }
}
