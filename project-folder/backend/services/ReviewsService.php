<?php
require_once 'BaseService.php';
require_once __DIR__.'/../dao/ReviewsDao.php';

class ReviewsService extends BaseService {
    public function __construct() {
        parent::__construct(new ReviewsDao());
    }

    public function createReview($userId, $productId, $rating, $comment = null) {
        if ($rating < 1 || $rating > 5) {
            throw new Exception("Rating must be between 1 and 5");
        }
        return $this->dao->createBasicReview($userId, $productId, $rating, $comment);
    }

    public function getAllReviews() {
        return $this->dao->getAll();
    }

    public function getReviewById($id) {
        $review = $this->dao->getById($id);
        if (!$review) {
            throw new Exception("Review not found");
        }
        return $review;
    }

    public function updateReview($id, $data) {
        if (isset($data['rating']) && ($data['rating'] < 1 || $data['rating'] > 5)) {
            throw new Exception("Rating must be between 1 and 5");
        }
        return $this->dao->update($id, $data);
    }

    public function deleteReview($id) {
        return $this->dao->delete($id);
    }

    public function getProductReviews($productId) {
        if ($productId <= 0) {
            throw new Exception("Invalid product ID");
        }
        return $this->dao->getByProductId($productId);
    }
}
?>