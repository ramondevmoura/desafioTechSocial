<?php


use app\Controllers\AuthController;
use app\Controllers\OrderController;
use app\Controllers\ProductController;
use app\Controllers\UserController;
use app\Services\ProductService;
use Services\OrderService;
use Services\UserService;


require '../vendor/autoload.php';


// Inclui os arquivos das classes/models e Controllers
require_once __DIR__ . '/../app/Controllers/UserController.php';
require_once __DIR__ . '/../app/Services/UserService.php';
require_once __DIR__ . '/../app/Validators/UserValidator.php';
require_once __DIR__ . '/../app/Controllers/OrderController.php';
require_once __DIR__ . '/../app/Services/OrderService.php';
require_once __DIR__ . '/../app/Validators/OrderValidator.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Services/AuthService.php';
require_once __DIR__ . '/../app/Controllers/ProductController.php';
require_once __DIR__ . '/../app/Services/ProductService.php';
require_once __DIR__ . '/../app/Validators/ProductValidator.php';
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


// Instancia os serviços e controladores usuarios
$userService = new UserService($cryptoService);
$userValidator = new UserValidator();

// Instancia os serviços e controladores pedidos
$orderService = new OrderService($conn);
$orderValidator = new OrderValidator();

// Instancia os serviços e controladores de autenticação
$authService = new AuthService($cryptoService);

$productService = new ProductService($conn);
$productValidator = new ProductValidator();

// Rotas da aplicação

$route = $_GET['route'] ?? '';
$allowedRoutes = ['login','register','authenticate', 'home','users', 'orders', 'create_user','update_user', 'delete_user','create_order','update_order', 'delete_order', 'products', 'product_create', 'product_update','product_delete'];

if (!in_array($route, $allowedRoutes)) {
    http_response_code(404);
    echo json_encode(array('message' => 'Rota não encontrada'));
    exit;
}
switch ($route) {
    case 'login':
        include('login.php');
        break;
    case 'authenticate':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AuthController())->authenticateUser($authService);
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'home':
        include('home.php');
        break;
    case 'users':
        $userController = new UserController($userService, $userValidator);
        $userController->getAllUsers();
        break;
    case 'create_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'document' => $_POST['document'] ?? '',
                'phone_number' => $_POST['phone_number'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? '',
                'password' => $_POST['password'] ?? '',
            ];
            $userController = new UserController($userService, $userValidator);
            $userController->createUser($userData);
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'register':
        include('register.php');
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
        //rotas de manipulacao de pedidos
    case 'orders':
        $orderController = new OrderController($orderService, $orderValidator);
        $orderController->getAllOrders();
        break;
    case 'create_order':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderData = [
                'user_id' => $_GET['user_id'] ?? '',
                'description' => $_GET['description'] ?? '',
                'quantity' => $_GET['quantity'] ?? '',
                'price' => $_GET['price'] ?? '',
            ];
            $orderController = new OrderController($orderService, $orderValidator);
            $orderController->createOrder($orderData);
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'update_order':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém o ID do usuário a ser atualizado
            $orderId = $_GET['id'] ?? null;

            if ($orderId !== null) {
                $orderData = [
                    'description' => $_GET['description'] ?? '',
                    'quantity' => $_GET['quantity'] ?? '',
                    'price' => $_GET['price'] ?? '',
                ];
                $orderController = new OrderController($orderService, $orderValidator);
                $orderController->updateOrder($orderId, $orderData);
            } else {
                http_response_code(400); // Requisição inválida
                echo json_encode(['message' => 'ID do pedido não fornecido']);
            }
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'delete_order':
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Obtém o ID do usuário a ser excluído
            $orderId = $_GET['id'] ?? null;

            if ($orderId !== null) {
                $orderController = new OrderController($orderService, $orderValidator);
                $orderController->deleteOrder($orderId);
            } else {
                http_response_code(400); // Requisição inválida
                echo json_encode(['message' => 'ID do usuário não fornecido']);
            }
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'products':
        $productController = new ProductController($productService, $productValidator);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $productController->getAllProducts();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para criar um novo produto
        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'product_create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData = [
                'name' => $_GET['name'] ?? '',
                'price' => $_GET['price'] ?? '',
                'description' => $_GET['description'] ?? '',
            ];
            $productController = new ProductController($productService, $productValidator);
            $productController->createProduct($productData);
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'product_update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém o ID do usuário a ser atualizado
            $productId = $_GET['id'] ?? null;

            if ($productId !== null) {
                $productData = [
                    'name' => $_GET['name'] ?? '',
                    'price' => $_GET['price'] ?? '',
                    'description' => $_GET['description'] ?? '',
                ];
                $productController = new ProductController($productService, $productValidator);
                $productController->updateProduct($productId, $productData);
            } else {
                http_response_code(400); // Requisição inválida
                echo json_encode(['message' => 'ID do produto não fornecido']);
            }
        } else {
            http_response_code(405); // Método não permitido
            echo json_encode(['message' => 'Método não permitido']);
        }
        break;
    case 'product_delete':
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Obtém o ID do usuário a ser excluído
            $productId = $_GET['id'] ?? null;

            if ($productId !== null) {
                $productController = new ProductController($productService, $productValidator);
                $productController->deleteProduct($productId);
            } else {
                http_response_code(400); // Requisição inválida
                echo json_encode(['message' => 'ID do produto não fornecido']);
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

