<?php
require_once 'BaseService.php';
require_once __DIR__.'/../dao/TransactionsDao.php';

class TransactionsService extends BaseService {
    public function __construct() {
        parent::__construct(new TransactionsDao());
    }

    public function createTransaction($userId, $productId) {
        if ($userId <= 0 || $productId <= 0) {
            throw new Exception("Invalid user or product ID");
        }
        return $this->dao->createBasicTransaction($userId, $productId);
    }

    public function getAllTransactions() {
        return $this->dao->getAll();
    }

    public function getTransactionById($id) {
        $transaction = $this->dao->getById($id);
        if (!$transaction) {
            throw new Exception("Transaction not found");
        }
        return $transaction;
    }

    public function updateTransaction($id, $data) {
        $allowedStatuses = ['pending', 'completed', 'failed', 'refunded'];
        if (isset($data['status']) && !in_array($data['status'], $allowedStatuses)) {
            throw new Exception("Invalid transaction status");
        }
        return $this->dao->update($id, $data);
    }

    public function deleteTransaction($id) {
        return $this->dao->delete($id);
    }

    public function getUserTransactions($userId) {
        if ($userId <= 0) {
            throw new Exception("Invalid user ID");
        }
        return $this->dao->getByUserId($userId);
    }
}
?>