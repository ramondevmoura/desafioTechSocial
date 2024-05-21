<?php

namespace app\Controllers;

use AuthService;

class AuthController
{
    public function authenticateUser(AuthService $authService)
    {
        // Verifica se as credenciais de autenticação foram enviadas
        if (!isset($_GET['email']) || !isset($_GET['password'])) {
            http_response_code(400); // Requisição inválida
            echo json_encode(['success' => false, 'message' => 'Credenciais de autenticação não fornecidas']);
            return;
        }

        $email = $_GET['email'];
        $password = $_GET['password'];


        // Tenta autenticar o usuário
        $authenticated = $authService->authenticateUser($email, $password);

        if ($authenticated) {
            echo json_encode(['success' => true, 'message' => 'Usuário autenticado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Credenciais de autenticação inválidas']);
        }
    }
}
