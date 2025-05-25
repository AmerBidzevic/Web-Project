<?php
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authentication, Authorization");
header("Access-Control-Allow-Credentials: true");

if (Flight::request()->method == 'OPTIONS') {
    http_response_code(200);
    exit();
}

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    public function verifyToken($token = null) {
        $token = $token ?? $this->getAuthToken();
        
        if (!$token) {
            Flight::halt(401, "Missing authentication header");
        }
        
        try {
            $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
            Flight::set('user', $decoded_token->user);
            Flight::set('jwt_token', $token);
            return true;
        } catch (Exception $e) {
            Flight::halt(401, "Invalid token: " . $e->getMessage());
        }
    }

    private function getAuthToken() {
        $request = Flight::request();
        
        if ($request->getHeader('Authentication')) {
            return $request->getHeader('Authentication');
        }
        
        $authHeader = $request->getHeader('Authorization');
        if ($authHeader && preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    public function authorizeRole($requiredRole) {
        $user = Flight::get('user');
        if ($user->role !== $requiredRole) {
            Flight::halt(403, 'Access denied: insufficient privileges');
        }
    }

    public function authorizeRoles($roles) {
        $user = Flight::get('user');
        if (!in_array($user->role, $roles)) {
            Flight::halt(403, 'Forbidden: role not allowed');
        }
    }

    public function authorizePermission($permission) {
        $user = Flight::get('user');
        if (!in_array($permission, $user->permissions)) {
            Flight::halt(403, 'Access denied: permission missing');
        }
    }   
    public function isAdmin() {
    $user = Flight::get('user');
    return isset($user->role) && $user->role === 'admin';
    }
}