<?php
require_once 'BaseService.php';
require_once __DIR__.'/../dao/UsersDao.php';

class UsersService extends BaseService {
    public function __construct() {
        parent::__construct(new UsersDao());
    }

    public function registerUser($username, $email, $password) {
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        return $this->dao->createBasicUser($username, $email, $password);
    }

    public function getAllUsers() {
        return $this->dao->getAll();
    }

    public function getUserById($id) {
        $user = $this->dao->getById($id);
        if (!$user) {
            throw new Exception("User not found");
        }
        return $user;
    }

    public function updateUser($id, $data) {
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        return $this->dao->update($id, $data);
    }

    public function deleteUser($id) {
        return $this->dao->delete($id);
    }

    public function getUserByEmail($email) {
        if (empty($email)) {
            throw new Exception("Email cannot be empty");
        }
        return $this->dao->getByEmail($email);
    }
}
?>