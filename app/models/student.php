<?php


require_once '../app/models/database.php';
require_once 'user.php';

class etudiant extends user {

    public function __construct($status, $id_user, $nom, $prenom, $email, $password, $type) {
        parent::__construct($status, $id_user, $nom, $prenom, $email, $password, $type);
    }

    public static function getAllUsers($conn) {
        $getUsers = $conn->prepare("SELECT COUNT(*) as total FROM users INNER JOIN role ON users.role = role.id_role WHERE role.name = 'student' AND users.statut = 'active'");
        if ($getUsers->execute()) {
            return $getUsers->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}
