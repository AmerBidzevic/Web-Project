<?php
require_once 'BaseDao.php';

class AuthDao extends BaseDao {

    public function __construct() {
        parent::__construct("users"); 
    }
    public function get_user_by_email($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function get_user_by_username($username) {
    error_log("Getting user by username: " . $username);

    $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
    $stmt = $this->connection->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    error_log("User fetched: " . print_r($user, true));
    return $user;
}

    public function query_unique($query, $params) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_admin_by_email($email) {
    $sql = "SELECT * FROM admins WHERE email = :email LIMIT 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

public function add_admin($admin) {
    $sql = "INSERT INTO admins (username, email, password, role) VALUES (:username, :email, :password, :role)";
    $stmt = $this->connection->prepare($sql);
    return $stmt->execute([
        'username' => $admin['username'],
        'email' => $admin['email'],
        'password' => $admin['password'],
        'role' => $admin['role']
    ]);
}

}


?>
