
<?php

class ProductValidator
{
    public function validateProductData($productData)
    {
        // Validação básica para campos obrigatórios
        if (empty($productData['name']) || empty($productData['price']) || empty($productData['description'])) {
            return false;
        }
        return true;
    }
}