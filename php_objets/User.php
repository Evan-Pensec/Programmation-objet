<?php
class User {
    public $username;
    public $password;
    public $admin;
    
    public function __construct($username, $password, $admin = 0) {
        $this->username = $username;
        $this->password = $password;
        $this->admin = $admin;
    }
    
    public static function authenticate($username, $password) {
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM user WHERE user = :username AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        $user = $stmt->fetch();
        
        if ($user) {
            return new User($user['user'], $user['password'], $user['admin']);
        }
        return null;
    }
}
?>