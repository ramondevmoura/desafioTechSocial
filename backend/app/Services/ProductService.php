<?php


namespace app\Services;
require_once __DIR__ . '/../Models/Product.php';

use Product;

class ProductService
{

    public function getAllProducts()
    {

        $products = Product::all();

        return $products;
    }
    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($data);
            return $product;
        }
        return null;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}
