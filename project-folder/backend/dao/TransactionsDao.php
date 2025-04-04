<?php
require_once 'BaseDao.php';

class TransactionsDao extends BaseDao {
    public function __construct() {
        parent::__construct("transactions");
    }

    public function createBasicTransaction($userId, $productId) {
        $price = $this->getProductPrice($productId);
        
        $transaction = [
            'user_id' => $userId,
            'product_id' => $productId,
            'purchase_date' => date('Y-m-d H:i:s'),
            'payment_method' => 'credit_card',
            'amount' => $price,
            'payment_status' => 'completed'
        ];
        
        return $this->insert($transaction);
    }

    private function getProductPrice($productId) {
        $sql = "SELECT price FROM products WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $productId]);
        return $stmt->fetchColumn();
    }

    public function getByUserId($userId) {
        $sql = "SELECT * FROM transactions WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>