<?php

require_once __DIR__ . '/../Security/ CryptoService.php';
require_once __DIR__ . '/../Models/User.php';
class AuthService
{
    private $cryptoService;

    public function __construct(CryptoService $cryptoService)
    {
        $this->cryptoService = $cryptoService;
    }

    public function authenticateUser($email, $password)
    {
        $encryptedEmail = $this->cryptoService->encrypt($email);

        $user = User::where('email', $encryptedEmail)->first();

        if ($user) {
            $decryptedEmail = $this->cryptoService->decrypt($user->email);

            // Verifica se a senha corresponde à senha armazenada
            if (password_verify($password, $user->password)) {
                // Inicia a sessão e armazena o ID do usuário
                session_start();
                $_SESSION['user_id'] = $user->id;
                return true;
            }
        }

        return false; // Usuário não encontrado ou senha incorreta
    }


}