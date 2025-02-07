<?php

session_start();

class user {

    protected $id_user;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $password;
    protected $type;
    protected $status;

    public function __construct($status = null, $id_user = null, $nom = null, $prenom = null, $email = null, $password = null, $type = null) {
        $this->id_user = $id_user;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->type = $type;
        $this->status = $status;
    }

    public static function login($e, $p, $conn) {
        $checkEmail = $conn->prepare("SELECT * FROM users INNER JOIN role ON users.role = role.id_role WHERE email = :email");
        $checkEmail->bindParam(":email", $e);
        if ($checkEmail->execute() && $checkEmail->rowCount() === 1) {
            $getUser = $checkEmail->fetch(PDO::FETCH_ASSOC);
            if (password_verify($p, $getUser['password'])) {
                
                if ($getUser['statut'] === 'active') {
                    $_SESSION['id'] = $getUser['id_user'];
                    $_SESSION['role'] = $getUser['id_role'];
                    if ($_SESSION['role'] == 3) {
                        header('Location: http://localhost/youdemy2/public/catalogue');
                    } else if ($_SESSION['role'] == 2) {
                        header('Location: http://localhost/youdemy2/public/teacher/dashboard');
                    } else if ($_SESSION['role'] == 1) {
                        header('Location: http://localhost/youdemy2/public/admin/dashboard');
                    } else {
                        unset($_SESSION['id']);
                        unset($_SESSION['role']);
                        $_SESSION['logError'] = 'Error try again!';
                        header('Location: Location: http://localhost/youdemy2/public/login');
                    }
                    
                } else {
                    $_SESSION['logError'] = 'Account is not confirmed yet!';
                    header('Location: http://localhost/youdemy2/public/login');
                }
            } else {
                $_SESSION['logError'] = 'Invalid password!';
                header('Location: http://localhost/youdemy2/public/login');
            }
        } else {
            $_SESSION['logError'] = 'Invalid information!';
            header('Location: http://localhost/youdemy2/public/login');
        }
    }

    public function getID() {
        return $this->id_user;
    }
    public function getNom() {
        return $this->nom;
    }
    public function getPrenom() {
        return $this->prenom;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getType() {
        return $this->type;
    }

    public function signup($r, $conn) {
        $getPass = password_hash($this->password, PASSWORD_DEFAULT);
    
        // Check if email already exists
        $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = :getEmail");
        $checkEmail->bindParam(":getEmail", $this->email, PDO::PARAM_STR);
        if ($checkEmail->execute() && $checkEmail->rowCount() === 0) {
            
            // Remove id_user from the INSERT statement
            $addUser = $conn->prepare("INSERT INTO users(nom, prenom, email, password, role, statut)
            VALUES(:getLName, :getFName, :getEmail, :getPass, :getRole, :getStatus)");

            // Bind parameters
            $addUser->bindParam(":getLName", $this->nom, PDO::PARAM_STR);
            $addUser->bindParam(":getFName", $this->prenom, PDO::PARAM_STR);
            $addUser->bindParam(":getEmail", $this->email, PDO::PARAM_STR);
            $addUser->bindParam(":getPass", $getPass, PDO::PARAM_STR);
            $addUser->bindParam(":getRole", $this->type, PDO::PARAM_INT);
            $addUser->bindParam(":getStatus", $this->status, PDO::PARAM_STR);

            // Execute the query
            if ($addUser->execute()) {
                if ($r === 'teacher') {
                    $_SESSION['success'] = 'Your account has been created, wait for verification!';
                    header('Location: http://localhost/youdemy2/public/login');
                } else if ($r === 'student') {
                    $_SESSION['id'] = $conn->lastInsertId();  // Store the auto-generated id_user
                    $_SESSION['role'] = $this->type;
                    header('Location: http://localhost/youdemy2/public/catalogue');
                } else {
                    header('Location: http://localhost/youdemy2/public/login');
                }
            } else {
                $_SESSION['Error'] = 'Failed to sign up, try again later!';
                header('Location: http://localhost/youdemy2/public/login');
            }            
        } else {
            $_SESSION['Error'] = 'This email already exists!';
            header('Location: http://localhost/youdemy2/public/login');
        }
    }

    public static function getUsers($conn, $filter) {
        if ($filter && $filter === "teachers") {
            $getUsers = $conn->prepare("SELECT * FROM users INNER JOIN role ON users.role = role.id_role WHERE name != 'admin' AND name = 'teacher'");
        } elseif ($filter && $filter === "students") {
            $getUsers = $conn->prepare("SELECT * FROM users INNER JOIN role ON users.role = role.id_role WHERE name != 'admin' AND name = 'student'");
        } else {
            $getUsers = $conn->prepare("SELECT * FROM users INNER JOIN role ON users.role = role.id_role WHERE name != 'admin'");
        }
        
        if ($getUsers->execute()) {
            return $getUsers;
        } else {
            return null;
        }
    }

    public function manageUser($id, $status, $conn) {
        $this->id_user = $id;
        $this->status = $status;
        $changeStatus = $conn->prepare("UPDATE users SET statut = :getStatus WHERE id_user = :getID");
        $changeStatus->bindParam(":getStatus", $this->status);
        $changeStatus->bindParam(":getID", $this->id_user);
        if ($changeStatus->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function removeUser($id, $conn) {
        $this->id_user = $id;
        $changeStatus = $conn->prepare("DELETE FROM users WHERE id_user = :getID");
        $changeStatus->bindParam(":getID", $this->id_user);
        if ($changeStatus->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function totalCountUsers($conn) {
        $getUsers = $conn->prepare("SELECT Count(*) as total FROM users INNER JOIN role ON users.role = role.id_role WHERE name != 'admin' AND statut = 'active'");
        if ($getUsers->execute()) {
            return $getUsers->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public static function totalCountTeacher($conn) {
        $getUsers = $conn->prepare("SELECT Count(*) as total FROM users INNER JOIN role ON users.role = role.id_role WHERE name = 'teacher' AND statut = 'active'");
        if ($getUsers->execute()) {
            return $getUsers->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}
