<?php
/**
 * AI Chat Test Script
 * Test LocalAiService directly
 */

// Initialize
define('BASE_PATH', __DIR__ . '/..');
require_once BASE_PATH . '/app/config/database.php';
require_once BASE_PATH . '/app/services/LocalAiService.php';

header('Content-Type: text/plain; charset=utf-8');

echo "=== AI CHAT TEST ===\n\n";

// Test database connection
echo "1. Testing database connection...\n";
try {
    echo "   Database variable: " . (isset($db) ? 'EXISTS' : 'NOT FOUND') . "\n";
    if (isset($db)) {
        $stmt = $db->query("SELECT COUNT(*) FROM users");
        $count = $stmt->fetchColumn();
        echo "   ✅ Database OK! Found $count users.\n";
    }
} catch (Exception $e) {
    echo "   ❌ Database error: " . $e->getMessage() . "\n";
    exit;
}

echo "\n2. Initializing LocalAiService...\n";
try {
    $aiService = new LocalAiService($db);
    echo "   ✅ AI Service initialized!\n";
} catch (Exception $e) {
    echo "   ❌ AI Service error: " . $e->getMessage() . "\n";
    exit;
}

echo "\n3. Testing queries...\n\n";

$testQuestions = [
    'Hai',
    'Bantuan',
    'Berapa dokumen yang menunggu approval?',
    'Berapa total user?',
    'Siapa user dari departemen Engineering?',
];

foreach ($testQuestions as $question) {
    echo "Q: $question\n";
    try {
        $answer = $aiService->ask($question);
        echo "A: $answer\n";
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
    echo "\n" . str_repeat('-', 60) . "\n\n";
}

echo "=== TEST COMPLETE ===\n";
