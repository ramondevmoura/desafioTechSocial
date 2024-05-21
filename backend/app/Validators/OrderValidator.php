<?php

class OrderValidator
{
    public function validateOrderData(array $data)
    {
        // Verifica se a quantidade e o preço são números positivos
        if (!isset($data['quantity']) || !isset($data['price']) ||
            !is_numeric($data['quantity']) || !is_numeric($data['price']) ||
            $data['quantity'] <= 0 || $data['price'] <= 0) {
            return false;
        }

        return true;
    }
}