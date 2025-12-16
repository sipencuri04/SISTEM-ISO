<?php
require_once BASE_PATH . '/app/models/M_User.php';

class Auth {

    private $userModel;

    public function __construct() {
        $this->userModel = new M_User();
    }

    public function login() {
        include BASE_PATH . '/app/views/auth/login.php';
    }

    public function auth() {
        $user = $this->userModel->getUserByUsername($_POST['username']);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = [
                'id'         => $user['id'],
                'nama'       => $user['nama'],
                'username'   => $user['username'],
                'role'       => $user['role'],
                'departemen' => $user['departemen']
            ];

            header("Location: index.php?controller=Dashboard&action=index");
            exit;
        }

        header("Location: index.php?controller=Auth&action=login&error=1");
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?controller=Auth&action=login");
        exit;
    }
}
