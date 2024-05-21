<?php

// Carrega o autoload do Composer (se estiver usando)

use app\Controllers\UserController;
use Services\UserService;


require '../vendor/autoload.php';

$route = $_GET['route'] ?? '';
$allowedRoutes = ['users', 'orders', 'create_user','update_user', 'delete_user'];

if (!in_array($route, $allowedRoutes)) {
    http_response_code(404);
    echo json_encode(array('message' => 'Rota não encontrada'));
    exit;
}

// Inclui os arquivos das classes/models e Controllers
require_once __DIR__ . '/../app/Controllers/UserController.php';
require_once __DIR__ . '/../app/Services/UserService.php';
require_once __DIR__ . '/../app/Validators/UserValidator.php';
require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../database/database-config.php';
require_once __DIR__ . '/../database/eloquent.php';

// Inicializa a conexão com o banco de dados
try {
    $db = new Database(DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $conn = $db->getConnection();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('message' => 'Erro ao conectar ao banco de dados'));
    exit;
}
$cryptoService = new CryptoService('techSocialSecretKey');


// Instancia os serviços e controladores
$userService = new UserService($cryptoService);
$userValidator = new UserValidator();

// Rotas da aplicação
switch ($route) {
    case 'users':
        $userController = new UserController($userService, $userValidator);
        $userController->getAllUsers();
        break;
    case 'orders':
        $orderController = new OrderController($conn);
        $orderController->getAllOrders();
        break;
    case 'create_user':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userData = [
                'first_name' => $_GET['first_name'] ?? '',
                'last_name' => $_GET['last_name'] ?? '',
                'email' => $_GET['email'] ?? '',
                'document' => $_GET['document'] ?? '',
                'phone_number' => $_GET['phone_number'] ?? '',
            ];
            $userController = new UserController($userService, $userValidator);
            $userController->createUser($userData);
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'update_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém o ID do usuário a ser atualizado
            $userId = $_GET['id'] ?? null;

            if ($userId !== null) {
                $userData = [
                    'first_name' => $_GET['first_name'] ?? '',
                    'last_name' => $_GET['last_name'] ?? '',
                    'email' => $_GET['email'] ?? '',
                    'document' => $_GET['document'] ?? '',
                    'phone_number' => $_GET['phone_number'] ?? '',
                ];
                var_dump($userData);
                $userController = new UserController($userService, $userValidator);
                $userController->updateUser($userId, $userData);
            } else {
                http_response_code(400); // Requisição inválida
                echo json_encode(['message' => 'ID do usuário não fornecido']);
            }
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'delete_user':
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Obtém o ID do usuário a ser excluído
            $userId = $_GET['id'] ?? null;

            if ($userId !== null) {
                $userController = new UserController($userService, $userValidator);
                $userController->deleteUser($userId);
            } else {
                http_response_code(400); // Requisição inválida
                echo json_encode(['message' => 'ID do usuário não fornecido']);
            }
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    default:
        // Rota padrão ou rota não encontrada
        http_response_code(404);
        echo json_encode(['message' => 'Rota não encontrada']);
        break;
}

