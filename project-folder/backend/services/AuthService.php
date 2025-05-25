<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
    private $auth_dao;

    public function __construct() {
        $this->auth_dao = new AuthDao();
        parent::__construct($this->auth_dao);
    }

    public function register($entity) {  
        try {
            if (empty($entity['email']) || empty($entity['password']) || empty($entity['username'])) {
                return ['success' => false, 'error' => 'Email, password, and username are required.'];
            }

            if (!filter_var($entity['email'], FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'error' => 'Invalid email format.'];
            }

            $email_exists = $this->auth_dao->get_user_by_email($entity['email']);
            if ($email_exists) {
                return ['success' => false, 'error' => 'Email already registered.'];
            }

            $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);
            $result = parent::add($entity);

            if (!$result) {
                return ['success' => false, 'error' => 'Failed to register user.'];
            }

            unset($entity['password']);
            return ['success' => true, 'data' => $entity];

        } catch (Exception $e) {
            error_log("AuthService::register error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function registerAdmin($entity) {
        $entity['role'] = 'admin';
        return $this->register($entity);
    }

    public function login($entity) {  
        try {
            if (empty($entity['email']) || empty($entity['password'])) {
                return ['success' => false, 'error' => 'Email and password are required.'];
            }

            $user = $this->auth_dao->get_user_by_email($entity['email']);
            
            if (!$user) {
                error_log("Login failed: User not found");
                return ['success' => false, 'error' => 'Invalid email or password.'];
            }

            if (!password_verify($entity['password'], $user['password'])) {
                error_log("Password verification failed for user: " . $entity['email']);
                return ['success' => false, 'error' => 'Invalid email or password.'];
            }

            $userData = [
                'id' => $user['id'],
                'email' => $user['email'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            $jwt_payload = [
                'user' => $userData,
                'iat' => time(),
                'exp' => time() + (60 * 60 * 24) 
            ];

            $token = JWT::encode(
                $jwt_payload,
                Config::JWT_SECRET(),
                'HS256'
            );

            return [
                'success' => true, 
                'data' => [
                    'user' => $userData,
                    'token' => $token
                ]
            ];

        } catch (Exception $e) {
            error_log("AuthService::login error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Login processing failed'];
        }
    }
}