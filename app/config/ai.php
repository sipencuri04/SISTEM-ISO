<?php

return [
    // PENTING: Ganti dengan API Key Anda (Contoh: Google Gemini API Key)
    'api_key' => 'ISI_API_KEY_DISINI', 
    
    // Model yang digunakan (contoh: gemini-pro)
    'model' => 'gemini-pro',
    
    // Endpoint API (Default untuk Google Gemini)
    // Jika menggunakan OpenAI, ganti menjadi: https://api.openai.com/v1/chat/completions
    'api_url' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key='
];
