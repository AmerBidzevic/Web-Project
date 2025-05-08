<?php
require_once 'BaseService.php';
require_once __DIR__.'/../dao/ProductsDao.php';

class ProductsService extends BaseService {
    public function __construct() {
        parent::__construct(new ProductsDao());
    }

    public function createProduct($name, $price) {
        if (empty($name)) {
            throw new Exception("Product name cannot be empty");
        }
        if ($price <= 0) {
            throw new Exception("Price must be positive");
        }
        return $this->dao->createBasicProduct($name, $price);
    }

    public function getAllProducts() {
        return $this->dao->getAll();
    }

    public function getProductById($id) {
        $product = $this->dao->getById($id);
        if (!$product) {
            throw new Exception("Product not found");
        }
        return $product;
    }

    public function updateProduct($id, $data) {
        if (isset($data['price']) && $data['price'] <= 0) {
            throw new Exception("Price must be positive");
        }
        return $this->dao->update($id, $data);
    }

    public function deleteProduct($id) {
        return $this->dao->delete($id);
    }

    public function searchProducts($name) {
        if (strlen($name) < 2) {
            throw new Exception("Search term must be at least 2 characters");
        }
        return $this->dao->getByName($name);
    }
}
?>