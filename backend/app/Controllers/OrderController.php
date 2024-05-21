<?php

namespace app\Controllers;

use OrderValidator;
use Services\OrderService;

class OrderController
{
    private $orderService;
    private $orderValidator;

    public function __construct(OrderService $orderService, OrderValidator $orderValidator)
    {
        $this->orderService = $orderService;
        $this->orderValidator = $orderValidator;

    }

    public function getAllOrders()
    {
        $orders = $this->orderService->getAllOrders();

        // Verifique se há pedidos retornados
        if ($orders) {
            echo json_encode(['success' => true, 'orders' => $orders]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhum pedido encontrado']);
        }
    }

    public function createOrder(array $data)
    {
        // Valida os dados do pedido
        if (!$this->orderValidator->validateOrderData($data)) {
            echo json_encode(['success' => false, 'message' => 'Dados do pedido inválidos']);
            return;
        }

        // Tenta criar o pedido
        $order = $this->orderService->createOrder($data);

        if ($order) {
            echo json_encode(['success' => true, 'order' => $order]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao criar pedido']);
        }
    }

    public function updateOrder($id, array $data)
    {

        // Valida os dados do usuário
        if (!$this->orderValidator->validateOrderData($data)) {
            echo json_encode(['success' => false, 'message' => 'Dados do usuário inválidos']);
            return;
        }


        // Tenta atualizar o usuário
        $success = $this->orderService->updateOrder($id, $data);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Pedido atualizado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar pedido']);
        }
    }

    public function deleteOrder($id)
    {
        // Tenta excluir o usuário
        $success = $this->orderService->deleteOrder($id);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Pedido excluído com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao excluir pedido']);
        }
    }
}
