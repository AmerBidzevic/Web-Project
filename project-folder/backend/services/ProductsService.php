<?php
require_once __DIR__.'/BaseService.php';
require_once __DIR__.'/../dao/ProductsDao.php';

class ProductsService extends BaseService {
    public function __construct() {
        parent::__construct(new ProductsDao());
    }

    public function createProduct($data) {
    $name = $data['name'] ?? null;
    $price = $data['price'] ?? null;
    $description = $data['description'] ?? null;
    $stock = $data['stock'] ?? null;
    $status = $data['status'] ?? 'Active';

    if (empty($name)) {
        throw new Exception("Product name cannot be empty");
    }
    if ($price === null || $price <= 0) {
        throw new Exception("Price must be positive");
    }
    if ($stock === null || $stock < 0) {
        throw new Exception("Stock must be zero or positive");
    }

    return $this->dao->createProduct([
    "name" => $name,
    "price" => $price,
    "description" => $description,
    "stock" => $stock
]);
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
    if (isset($data['stock'])) {
        $data['stock_quantity'] = $data['stock'];
        unset($data['stock']);
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
    public function getFeaturedProducts($limit = 8) {
    return $this->dao->getFeaturedProducts($limit);
    }

    public function getRecentProducts($limit = 8) {
        return $this->dao->getRecentProducts($limit);
    }
    
}
?>