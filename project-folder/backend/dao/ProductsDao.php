<?php 
require_once 'BaseDao.php';

class ProductsDao extends BaseDao{
    public function __construct(){
        parent::__construct("products");
    }

    public function createBasicProduct($name, $price) {
        return $this->insert([
            'name' => $name,
            'price' => $price
        ]);
    }

    public function getByName($name) {
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE name LIKE :name");
        $stmt->bindValue(':name', "%$name%");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllProducts() {
        return $this->getAll();
    }

    public function getFeaturedProducts($limit = 8) {
    $stmt = $this->connection->prepare("SELECT * FROM products WHERE featured = 1 LIMIT :limit");
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

public function getRecentProducts($limit = 8) {
    $stmt = $this->connection->prepare("SELECT * FROM products ORDER BY release_date DESC LIMIT :limit");
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
public function createProduct($data) {
    error_log("createProduct data: " . json_encode($data));
    return $this->insert([
        'name' => $data['name'],
        'price' => $data['price'],
        'description' => $data['description'] ?? null,
        'stock_quantity' => $data['stock']
    ]);

}
}
?>