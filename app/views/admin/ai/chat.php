<?php include BASE_PATH . '/app/views/admin/layout/sidebar.php'; ?>

<div class="content">
    <div class="chat-container">
        
        <div class="chat-header">
            <div class="title">
                <span class="icon">🤖</span>
                <div>
                    <h1>AI Assistant ISO</h1>
                    <p>Tanyakan apa saja tentang data sistem</p>
                </div>
            </div>
            <div class="status-badge online">Online</div>
        </div>

        <div class="chat-box" id="chatBox">
            <!-- Pesan Pembuka -->
            <div class="message ai">
                <div class="avatar">🤖</div>
                <div class="text">
                    Halo! Saya AI Assistant Admin. Saya memiliki akses ke data user dan dokumen ISO terbaru. <br><br>
                    Contoh pertanyaan:
                    <ul>
                        <li>Ada berapa dokumen yang menunggu approval?</li>
                        <li>Siapa user dari departemen HR?</li>
                        <li>Apa status dokumen QA-005?</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="input-area">
            <input type="text" id="userInput" placeholder="Ketik pertanyaan Anda di sini..." autocomplete="off">
            <button onclick="sendMessage()" id="sendBtn">
                <span class="icon">➤</span> Kirim
            </button>
        </div>

    </div>
</div>

<style>
    /* VARIABLES */
    :root {
        --primary: #4F46E5;
        --secondary: #64748B;
        --bg-chat: #F8FAFC;
        --bg-user: #4F46E5;
        --bg-ai: #FFFFFF;
        --border: #E2E8F0;
    }

    body {
        background-color: #F1F5F9;
        font-family: 'Inter', sans-serif;
    }

    .chat-container {
        max-width: 900px;
        margin: 0 auto;
        height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    /* HEADER */
    .chat-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
    }

    .chat-header h1 {
        font-size: 18px;
        font-weight: 700;
        margin: 0;
        color: #1E293B;
    }

    .chat-header p {
        font-size: 13px;
        color: var(--secondary);
        margin: 2px 0 0;
    }

    .chat-header .title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chat-header .icon {
        font-size: 24px;
        background: #EEF2FF;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .status-badge {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }
    
    .status-badge.online {
        background: #DCFCE7;
        color: #166534;
    }

    /* CHAT BOX */
    .chat-box {
        flex: 1;
        padding: 24px;
        background: var(--bg-chat);
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .message {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        max-width: 80%;
        animation: fadeIn 0.3s ease;
    }

    .message.user {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .message.ai .avatar {
        width: 36px;
        height: 36px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .message.user .avatar {
        display: none;
    }

    .message .text {
        padding: 14px 18px;
        border-radius: 14px;
        font-size: 14px;
        line-height: 1.5;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .message.ai .text {
        background: var(--bg-ai);
        color: #334155;
        border-top-left-radius: 4px;
        border: 1px solid var(--border);
    }

    .message.user .text {
        background: var(--bg-user);
        color: white;
        border-top-right-radius: 4px;
    }
    
    .message ul {
        margin: 8px 0 0 16px;
        padding: 0;
    }

    /* INPUT AREA */
    .input-area {
        padding: 20px;
        background: white;
        border-top: 1px solid var(--border);
        display: flex;
        gap: 12px;
    }

    #userInput {
        flex: 1;
        padding: 14px 20px;
        border: 1px solid var(--border);
        border-radius: 12px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }

    #userInput:focus {
        border-color: var(--primary);
    }

    #sendBtn {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #sendBtn:hover {
        background: #4338CA;
    }

    #sendBtn:disabled {
        background: #A5B4FC;
        cursor: not-allowed;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* LOADING TYPING INDICATOR */
    .typing-indicator {
        display: flex;
        gap: 4px;
        padding: 12px 16px;
        background: white;
        border-radius: 14px;
        border-top-left-radius: 4px;
        width: fit-content;
        border: 1px solid var(--border);
    }
    
    .typing-dot {
        width: 6px;
        height: 6px;
        background: #94A3B8;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out both;
    }
    
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }
    
    @keyframes typing {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }

</style>

<script>
const chatBox = document.getElementById('chatBox');
const userInput = document.getElementById('userInput');
const sendBtn = document.getElementById('sendBtn');

userInput.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    sendMessage();
  }
});

function sendMessage() {
    const text = userInput.value.trim();
    if (!text) return;

    // 1. Tambah chat User
    addMessage(text, 'user');
    userInput.value = '';
    userInput.disabled = true;
    sendBtn.disabled = true;

    // 2. Tampilkan Loading
    const loadingId = addLoading();

    // 3. Kirim ke Backend
    fetch('<?= BASE_URL ?>?controller=AiChat&action=ask', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ question: text })
    })
    .then(response => response.json())
    .then(data => {
        removeLoading(loadingId);
        if (data.error) {
            addMessage("Error: " + data.error, 'ai');
        } else {
            addMessage(data.answer, 'ai');
        }
    })
    .catch(err => {
        removeLoading(loadingId);
        addMessage("Terjadi kesalahan koneksi.", 'ai');
        console.error(err);
    })
    .finally(() => {
        userInput.disabled = false;
        sendBtn.disabled = false;
        userInput.focus();
    });
}

function addMessage(text, type) {
    const div = document.createElement('div');
    div.className = `message ${type}`;
    
    const avatar = type === 'ai' ? '<div class="avatar">🤖</div>' : '';
    
    // Convert newlines to breaks for AI responses
    const formattedText = text.replace(/\n/g, '<br>');
    
    div.innerHTML = `
        ${avatar}
        <div class="text">${formattedText}</div>
    `;
    
    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function addLoading() {
    const id = 'loading-' + Date.now();
    const div = document.createElement('div');
    div.className = 'message ai';
    div.id = id;
    div.innerHTML = `
        <div class="avatar">🤖</div>
        <div class="typing-indicator">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        </div>
    `;
    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
    return id;
}

function removeLoading(id) {
    const el = document.getElementById(id);
    if (el) el.remove();
}
</script>
