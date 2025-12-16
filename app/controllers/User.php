<?php
require_once BASE_PATH . '/app/models/M_User.php';

class User
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new M_User();
    }

    private function adminOnly()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASE_URL . "?controller=Auth&action=login");
            exit;
        }
    }

    public function userIndex()
    {
        $this->adminOnly();
        $users = $this->userModel->getAll();
        include BASE_PATH . '/app/views/admin/User/index.php';
    }

    public function userCreate()
    {
        $this->adminOnly();
        include BASE_PATH . '/app/views/admin/User/tambah.php';
    }

    public function userStore()
    {
        $this->adminOnly();
        $this->userModel->insert($_POST);
        header("Location: " . BASE_URL . "?controller=User&action=userIndex");
        exit;
    }
}
