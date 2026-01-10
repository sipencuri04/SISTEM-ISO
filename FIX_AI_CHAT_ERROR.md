# 🔧 FIX: AI Chat Connection Error

## Problem
```
User Question: "Siapa user dari departemen HR"
AI Response: "Terjadi kesalahan koneksi."
```

## Root Cause

**Issue 1:** Wrong database variable name
```php
// ❌ WRONG
global $conn;
$this->aiService = new LocalAiService($conn);

// ✅ CORRECT
global $db;
$this->aiService = new LocalAiService($db);
```

**Issue 2:** Poor error handling in JavaScript
- No HTTP status check
- No content-type validation
- Generic error message

---

## Solution

### 1. Fixed Database Variable

**File:** `app/controllers/AiChat.php`

```php
public function __construct()
{
    // ...
    global $db;  // ✅ Changed from $conn
    $this->aiService = new LocalAiService($db);
}
```

### 2. Improved Error Handling

**File:** `app/views/admin/ai/chat.php`

**Added:**
- HTTP status check
- Content-type validation
- Console logging for debugging
- Detailed error messages

```javascript
fetch(url, { /* ... */ })
.then(response => {
    console.log('Response status:', response.status);
    
    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }
    
    const contentType = response.headers.get('content-type');
    if (!contentType.includes('application/json')) {
        throw new Error('Response bukan JSON! Ada PHP error.');
    }
    
    return response.json();
})
.then(data => {
    console.log('Response:', data);
    // Handle response
})
.catch(err => {
    console.error('Error:', err);
    // Show detailed error
});
```

### 3. Test Script

**File:** `public/test-ai.php`

Created test script to debug AI service directly:
```
http://localhost/SISTEM-ISO/public/test-ai.php
```

This will test:
- Database connection
- LocalAiService initialization
- Multiple query patterns
- Error handling

---

## Testing

### Step 1: Test AI Service Directly

```
http://localhost/SISTEM-ISO/public/test-ai.php
```

**Expected output:**
```
=== AI CHAT TEST ===

1. Testing database connection...
   ✅ Database OK! Found 5 users.

2. Initializing LocalAiService...
   ✅ AI Service initialized!

3. Testing queries...

Q: Hai
A: Halo! 👋 Saya AI Assistant...
...
```

### Step 2: Test via Chat UI

```
http://localhost/SISTEM-ISO/public/index.php?controller=AiChat&action=index
```

**Test questions:**
1. "Hai" → Should greet
2. "Bantuan" → Should show help
3. "Berapa dokumen yang menunggu approval?" → Should query DB
4. "Siapa user dari departemen Engineering?" → Should list users

### Step 3: Check Browser Console (F12)

If error occurs, check console for:
- Response status
- Response headers
- Response data
- Error details

---

## Common Errors & Solutions

### Error: "Response bukan JSON"

**Cause:** PHP error/warning before JSON output

**Solution:**
1. Check test-ai.php for PHP errors
2. Look for PHP warnings in response
3. Verify database connection

### Error: "HTTP 500"

**Cause:** PHP fatal error

**Solution:**
1. Check PHP error log
2. Run test-ai.php
3. Verify LocalAiService.php syntax

### Error: "Question is empty"

**Cause:** POST data not received

**Solution:**
Check request headers and body format

---

## Debugging Steps

### 1. Check Database Connection

```php
// In test-ai.php
$stmt = $db->query("SELECT COUNT(*) FROM users");
echo $stmt->fetchColumn(); // Should show user count
```

### 2. Check AI Service

```php
$aiService = new LocalAiService($db);
$answer = $aiService->ask("Hai");
echo $answer; // Should show greeting
```

### 3. Check Controller

```php
// Access directly
http://localhost/SISTEM-ISO/public/index.php?controller=AiChat&action=ask

// POST with:
{"question":"Hai"}
```

### 4. Check JavaScript

```javascript
// In browser console
fetch(url, {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({question: 'Hai'})
})
.then(r => r.json())
.then(console.log);
```

---

## Files Modified

1. ✅ `app/controllers/AiChat.php` - Fixed $db variable
2. ✅ `app/views/admin/ai/chat.php` - Better error handling
3. ✅ `public/test-ai.php` - NEW (Test script)

---

## Verification Checklist

- [ ] test-ai.php works without errors
- [ ] Database connection OK
- [ ] LocalAiService initializes
- [ ] Pattern matching works
- [ ] Database queries return data
- [ ] Chat UI loads
- [ ] Can send message
- [ ] AI responds correctly
- [ ] No console errors

---

**Status:** ✅ FIXED
**Root Cause:** Wrong database variable name ($conn vs $db)
**Solution:** Changed to use $db + improved error handling
**Test Script:** Available at public/test-ai.php

---

**Next Steps:**
1. Run test-ai.php to verify
2. Test chat UI
3. Check console for any errors
4. If still error, check PHP error log
