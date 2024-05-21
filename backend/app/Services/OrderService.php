<?php

namespace Services;
use Order;

require_once __DIR__ . '/../Models/Order.php';

class OrderService
{
    public function getAllOrders()
    {
        // Recupera todos os usuários do banco de dados
        $orders = Order::all();

        return $orders;
    }

    public function createOrder($orderData)
    {

        try {
            // Tenta criar o usuário
            return Order::create($orderData);
        } catch (\Exception $e) {
            // Em caso de erro, registre-o e retorne falso
            error_log('Erro ao criar usuário: ' . $e->getMessage());
            return false;
        }
    }

    public function updateOrder($id, $orderData)
    {
        try {
            // Encontra o usuário pelo ID
            $order = Order::find($id);

            // Verifica se o usuário foi encontrado
            if ($order) {
                // Atualiza os dados do usuário
                $order->update($orderData);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            error_log('Erro ao atualizar usuário: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteOrder($id)
    {
        try {
            // Encontra o usuário pelo ID
            $order = Order::find($id);

            // Verifica se o usuário foi encontrado
            if ($order) {
                // Exclui o usuário
                $order->delete();
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