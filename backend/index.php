<?php

// Carrega o autoload do Composer (se estiver usando)
// require __DIR__ . '/vendor/autoload.php';

//validação e sanitização da entrada

$route = $_GET['route'] ?? '';
$allowedRoutes = ['users', 'orders'];

if (!in_array($route, $allowedRoutes)) {
    http_response_code(404);
    echo json_encode(array('message' => 'Rota não encontrada'));
}

// Inclui os arquivos das classes/models e controllers
require_once '/var/www/html/controllers/UserController.php';
require_once '/var/www/html/controllers/OrderController.php';
require_once '/var/www/html/database/Database.php';


// Inicializa a conexão com o banco de dados
try {
    $db = new Database();
    $conn = $db->getConnection();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('message' => 'Erro ao conectar ao banco de dados'));
    exit;
}


// Rotas da aplicação
switch ($route) {
    case 'users':
        $controller = new UserController($conn);
        $controller->handle();
        break;
    case 'orders':
        $controller = new OrderController($conn);
        $controller->handle();
        break;
    default:
        // Rota padrão ou rota não encontrada
        http_response_code(404);
        echo json_encode(array('message' => 'Rota não encontrada'));
        break;
}
