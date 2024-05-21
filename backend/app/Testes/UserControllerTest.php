<?php

use app\Controllers\UserController;
use Services\UserService;

require_once __DIR__ . '/../../app/Controllers/UserController.php';
require_once __DIR__ . '/../../app/Services/UserService.php';
require_once __DIR__ . '/../../app/Validators/UserValidator.php';
class UserControllerTest {
    public function testCreateUserValidData() {
        // Simula um serviço de usuário e um validador de usuário
        $cryptoService = new CryptoService('techSocialSecretKey');
        $userService = new UserService($cryptoService);
        $userValidator = new UserValidator();

        // Configura o controlador do usuário com os serviços simulados
        $userController = new UserController($userService, $userValidator);

        // Dados válidos do usuário
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'document' => '000.000.000-00',
            'phone_number' => "32999899099",
            'password' => 'password123'
        ];

        ob_start();
        $userController->createUser($userData);
        $output = ob_get_clean(); // Obtém a saída JSON

        // Verifica se a saída JSON contém a resposta esperada
        $expectedOutput = '{"success":true,"user":{"id":1,"first_name":"John","last_name":"Doe","email":"john@example.com"}}';
        $this->assertEqual($expectedOutput, $output);
    }

    public function testUpdateUserValidData() {
        // Simula um serviço de usuário e um validador de usuário
        $cryptoService = new CryptoService('techSocialSecretKey');
        $userService = new UserService($cryptoService);
        $userValidator = new UserValidator();

        // Configura o controlador do usuário com os serviços simulados
        $userController = new UserController($userService, $userValidator);

        // Dados válidos do usuário
        $userData = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'document' => '000.000.330-00',
            'phone_number' => "32499899099",
            'password' => 'newpassword123'
        ];

        ob_start(); // Captura a saída JSON
        $userController->updateUser(1, $userData);
        $output = ob_get_clean(); // Obtém a saída JSON

        // Verifica se a saída JSON contém a resposta esperada
        $expectedOutput = '{"success":true,"message":"Usuário atualizado com sucesso"}';
        $this->assertEqual($expectedOutput, $output);
    }

    // Função para comparar duas strings e verificar se são iguais
    private function assertEqual($expected, $actual) {
        if ($expected === $actual) {
            echo "Test Passed\n";
        } else {
            echo "Test Failed\nExpected: $expected\nActual: $actual\n";
        }
    }
}

// Executa os testes
$test = new UserControllerTest();
$test->testCreateUserValidData();
$test->testUpdateUserValidData();