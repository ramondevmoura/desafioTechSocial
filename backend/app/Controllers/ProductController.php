<?php

namespace app\Controllers;

use app\Services\ProductService;
use ProductValidator;

class ProductController
{
    private $productService;
    private $productValidator;

    public function __construct(ProductService $productService, ProductValidator $productValidator)
    {
        $this->productService = $productService;
        $this->productValidator = $productValidator;
    }

    public function getAllProducts()
    {
        $products = $this->productService->getAllProducts();

        // Verifique se há produtos retornados
        if ($products) {
            echo json_encode(['success' => true, 'products' => $products]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhum produto encontrado']);
        }
    }

    public function createProduct(array $data)
    {
        // Valida os dados do produto
        if (!$this->productValidator->validateProductData($data)) {
            echo json_encode(['success' => false, 'message' => 'Dados do produto inválidos']);
            return;
        }

        // Tenta criar o produto
        $product = $this->productService->createProduct($data);

        if ($product) {
            echo json_encode(['success' => true, 'product' => $product]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao criar produto']);
        }
    }

    public function updateProduct($id, array $data)
    {
        // Valida os dados do produto
        if (!$this->productValidator->validateProductData($data)) {
            echo json_encode(['success' => false, 'message' => 'Dados do produto inválidos']);
            return;
        }

        // Tenta atualizar o produto
        $success = $this->productService->updateProduct($id, $data);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Produto atualizado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar produto']);
        }
    }

    public function deleteProduct($id)
    {
        // Tenta excluir o produto
        $success = $this->productService->deleteProduct($id);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Produto excluído com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao excluir produto']);
        }
    }
}
