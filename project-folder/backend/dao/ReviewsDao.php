<?php
require_once 'BaseDao.php';

class ReviewsDao extends BaseDao {
    public function __construct() {
        parent::__construct("reviews");
    }

    public function createBasicReview($userId, $productId, $rating, $comment = null) {
        $data = [
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $rating,
            'comment' => $comment,
            'review_date' => date('Y-m-d H:i:s')
        ];
        
        return $this->insert($data);
    }

    public function getByProductId($productId) {
        $stmt = $this->connection->prepare("SELECT * FROM reviews WHERE product_id = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function getByUserId($userId) {
        $stmt = $this->connection->prepare("SELECT * FROM reviews WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>