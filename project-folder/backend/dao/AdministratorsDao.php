<?php
require_once 'BaseDao.php';
require_once 'UsersDao.php';

class AdministratorsDao extends BaseDao {
    public function __construct() {
        parent::__construct("admins");
    }

    public function createBasicAdmin($userId) {
        $userDao = new UsersDao();
        $user = $userDao->getById($userId);
        
        if (!$user) {
            throw new Exception("User not found with ID: $userId");
        }

        return $this->insert([
            'user_id' => $userId,
            'email' => $user['email'],
            'role' => 'admin',
            'permissions' => ''
        ]);
    }

    public function getByUserId($userId) {
        $stmt = $this->connection->prepare("SELECT * FROM admins WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAdmins() {
        return $this->getAll();
    }
}
?>