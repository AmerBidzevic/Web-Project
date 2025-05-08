<?php
require_once 'BaseService.php';
require_once __DIR__.'/../dao/AdministratorsDao.php';
require_once __DIR__.'/../dao/UsersDao.php';

class AdministratorsService extends BaseService {
    private $usersDao;

    public function __construct() {
        parent::__construct(new AdministratorsDao());
        $this->usersDao = new UsersDao();
    }

    public function createAdmin($userId) {
        $user = $this->usersDao->getById($userId);

        if (!$user) {
            throw new Exception("User does not exist");
        }

        $existingAdmin = $this->dao->getByUserId($userId);
        if ($existingAdmin) {
            throw new Exception("User is already an administrator");
        }

        return $this->dao->createBasicAdmin($userId);
    }

    public function getAllAdmins() {
        return $this->dao->getAll();
    }

    public function getAdminById($id) {
        $admin = $this->dao->getById($id);
        if (!$admin) {
            throw new Exception("Admin not found");
        }
        return $admin;
    }

    public function updateAdmin($id, $data) {
        $allowedRoles = ['admin', 'superadmin'];
        if (isset($data['role']) && !in_array($data['role'], $allowedRoles)) {
            throw new Exception("Invalid admin role");
        }
        return $this->dao->update($id, $data);
    }

    public function deleteAdmin($id) {
        return $this->dao->delete($id);
    }
}
?>