<?php 
$pageTitle = 'AI Chat';
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php'; 
?>

<style>
/* Chat Container */
.chat-container {
    max-width: 900px;
    margin: 0 auto;
    height: calc(100vh - 120px);
    display: flex;
    flex-direction: column;
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

/* Chat Header */
.chat-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header .title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chat-header .icon {
    font-size: 24px;
    background: var(--primary-soft);
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.chat-header h1 {
    font-size: 18px;
    margin: 0;
}

.chat-header p {
    font-size: 13px;
    color: var(--text-secondary);
    margin: 2px 0 0;
}

.status-badge {
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    background: var(--primary-soft);
    color: var(--primary);
}

/* Chat Box */
.chat-box {
    flex: 1;
    padding: 24px;
    background: var(--bg-main);
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

.message .avatar {
    width: 36px;
    height: 36px;
    background: var(--primary-soft);
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
    line-height: 1.6;
}

.message.ai .text {
    background: var(--bg-card);
    color: var(--text-primary);
    border-top-left-radius: 4px;
}

.message.user .text {
    background: var(--primary);
    color: white;
    border-top-right-radius: 4px;
}

/* Typing Indicator */
.typing-indicator {
    display: flex;
    gap: 4px;
    padding: 12px 16px;
    background: var(--bg-card);
    border-radius: 14px;
    border-top-left-radius: 4px;
    width: fit-content;
}

.typing-dot {
    width: 6px;
    height: 6px;
    background: var(--text-secondary);
    border-radius: 50%;
    animation: typing 1.4s infinite ease-in-out both;
}

.typing-dot:nth-child(1) { animation-delay: -0.32s; }
.typing-dot:nth-child(2) { animation-delay: -0.16s; }

@keyframes typing {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}

/* Input Area */
.input-area {
    padding: 20px;
    background: var(--bg-card);
    border-top: 1px solid var(--border-color);
    display: flex;
    gap: 12px;
}

#userInput {
    flex: 1;
    padding: 14px 20px;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    font-size: 14px;
    outline: none;
    background: var(--bg-main);
    color: var(--text-primary);
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
    display: flex;
    align-items: center;
    gap: 8px;
}

#sendBtn:hover {
    background: var(--primary-dark);
}

#sendBtn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>

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
            <div class="status-badge">Online</div>
        </div>

        <div class="chat-box" id="chatBox">
            <!-- Welcome Message -->
            <div class="message ai">
                <div class="avatar">🤖</div>
                <div class="text">
                    Halo! 👋 Saya AI Assistant lokal yang bisa membantu Anda dengan data sistem.<br><br>
                    <strong>Contoh pertanyaan:</strong><br>
                    • Bantuan<br>
                    • Berapa dokumen yang menunggu approval?<br>
                    • Siapa user dari departemen Engineering?<br>
                    • Status dokumen ISO-001?
                </div>
            </div>
        </div>

        <div class="input-area">
            <input type="text" id="userInput" placeholder="Ketik pertanyaan Anda di sini..." autocomplete="off">
            <button onclick="sendMessage()" id="sendBtn">
                <span>➤</span> Kirim
            </button>
        </div>

    </div>
</div>

<script>
const chatBox = document.getElementById('chatBox');
const userInput = document.getElementById('userInput');
const sendBtn = document.getElementById('sendBtn');

// Enter key to send
userInput.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        sendMessage();
    }
});

function sendMessage() {
    const text = userInput.value.trim();
    if (!text) return;

    // Add user message
    addMessage(text, 'user');
    userInput.value = '';
    userInput.disabled = true;
    sendBtn.disabled = true;

    // Show loading
    const loadingId = addLoading();

    // Send to backend
    const url = '<?= BASE_URL_INDEX ?>?controller=AiChat&action=ask';
    
    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ question: text })
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            return response.text().then(text => {
                console.error('Non-JSON response:', text);
                throw new Error('Server mengembalikan response bukan JSON. Kemungkinan ada PHP error.');
            });
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        removeLoading(loadingId);
        
        if (data.error) {
            addMessage("❌ " + data.error, 'ai');
        } else if (data.answer) {
            addMessage(data.answer, 'ai');
        } else {
            addMessage("❌ Response tidak valid dari server.", 'ai');
            console.error('Invalid data:', data);
        }
    })
    .catch(err => {
        removeLoading(loadingId);
        console.error('Error details:', err);
        addMessage("❌ Terjadi kesalahan: " + err.message + "\n\n💡 Buka console (F12) untuk detail error.", 'ai');
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

<?php include BASE_PATH . '/app/views/admin/layout/footer.php'; ?>
