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
            header("Location: " . BASE_URL_INDEX . "?controller=Auth&action=login");
            exit;
        }
    }

    // Alias for userIndex (for cleaner URLs)
    public function index()
    {
        $this->userIndex();
    }

    public function userIndex()
    {
        $this->adminOnly();
        $users = $this->userModel->getAll();
        include BASE_PATH . '/app/views/admin/user/index.php';
    }

    // Alias methods for cleaner URLs
    public function create() { $this->userCreate(); }
    public function store() { $this->userStore(); }
    public function edit() { $this->userEdit(); }
    public function update() { $this->userUpdate(); }
    public function delete() { $this->userDelete(); }

    public function userCreate()
    {
        $this->adminOnly();
        include BASE_PATH . '/app/views/admin/user/tambah.php';
    }

    public function userStore()
    {
        $this->adminOnly();
        $this->userModel->insert($_POST);
        header("Location: " . BASE_URL_INDEX . "?controller=User&action=userIndex");
        exit;
    }

    public function userEdit()
{
    $this->adminOnly();

    if (!isset($_GET['id'])) {
        header("Location: " . BASE_URL_INDEX . "?controller=User&action=userIndex");
        exit;
    }

    $id = $_GET['id'];
    $user = $this->userModel->getById($id);

    if (!$user) {
        header("Location: " . BASE_URL_INDEX . "?controller=User&action=userIndex");
        exit;
    }

    include BASE_PATH . '/app/views/admin/user/edit.php';
}


public function userUpdate()
{
    $this->adminOnly();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->userModel->update($_POST);
    }

    header("Location: " . BASE_URL_INDEX . "?controller=User&action=userIndex");
    exit;
}

public function userDelete()
{
    $this->adminOnly();

    if (!isset($_GET['id'])) {
        header("Location: " . BASE_URL_INDEX . "?controller=User&action=userIndex");
        exit;
    }

    $id = $_GET['id'];
    $this->userModel->delete($id);

    header("Location: " . BASE_URL_INDEX . "?controller=User&action=userIndex");
    exit;
}















}
