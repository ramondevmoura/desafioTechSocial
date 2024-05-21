<?php

// Carrega o autoload do Composer (se estiver usando)

use app\Controllers\UserController;
use Services\UserService;


require '../vendor/autoload.php';

$route = $_GET['route'] ?? '';
$allowedRoutes = ['users', 'orders', 'create_user'];

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

// Instancia os serviços e controladores
$userService = new UserService($conn);
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
                'password' => $_GET['password'] ?? '',
            ];
            $userController = new UserController($userService, $userValidator);
            $userController->createUser($userData);
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;

    default:
        // Rota padrão ou rota não encontrada
        http_response_code(404);
        echo json_encode(array('message' => 'Rota não encontrada'));
        break;
}
