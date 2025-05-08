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

}
?>