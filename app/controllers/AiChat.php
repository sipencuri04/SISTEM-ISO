<?php

require_once BASE_PATH . '/app/services/AiService.php';

class AiChat
{
    private $aiService;

    public function __construct()
    {
        // Cek Admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASE_URL . "?controller=Auth&action=login");
            exit;
        }

        $this->aiService = new AiService();
    }

    public function index()
    {
        include BASE_PATH . '/app/views/admin/ai/chat.php';
    }

    public function ask()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $question = $input['question'] ?? '';

        if (empty($question)) {
            echo json_encode(['error' => 'Pertanyaan wajib diisi']);
            exit;
        }

        try {
            $answer = $this->aiService->ask($question);
            echo json_encode(['answer' => $answer]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
