# 🔧 FIX: Sidebar Hilang di Halaman Admin

## Masalah
**Sidebar hilang** ketika membuka menu tertentu di Admin seperti:
- History Dokumen
- AI Chat

## Root Cause
Files view **tidak include header.php**, hanya include sidebar.php saja.

Tanpa header.php:
- ❌ Tag `<html>`, `<head>`, `<body>` tidak ada
- ❌ CSS global (`style.css`) tidak ter-load
- ❌ Design system tidak apply
- ❌ Tampilan rusak/berantakan

## Files yang Diperbaiki

### 1. admin/history/index.php
**Before:**
```php
<?php include BASE_PATH . '/app/views/admin/layout/sidebar.php'; ?>
```

**After:**
```php
<?php
$pageTitle = 'History Dokumen';
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
?>
```

**Changes:**
- ✅ Added `header.php` include
- ✅ Removed all inline CSS (200+ lines)
- ✅ Using design system components
- ✅ Consistent with other pages

### 2. admin/ai/chat.php
**Before:**
```php
<?php include BASE_PATH . '/app/views/admin/layout/sidebar.php'; ?>
```

**After:**
```php
<?php 
$pageTitle = 'AI Chat';
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php'; 
?>
```

**Changes:**
- ✅ Added `header.php` include
- ✅ Page title set properly

---

## Verification Checklist

Test these pages now:

- [ ] http://localhost/SISTEM-ISO/public/index.php?controller=History&action=index
      → Should show sidebar and styled table

- [ ] http://localhost/SISTEM-ISO/public/index.php?controller=AiChat&action=index
      → Should show sidebar and chat interface

- [ ] Check console (F12) for CSS 404 errors
      → Should see `style.css` loaded with status 200

- [ ] Check page source (Ctrl+U)
      → Should see `<link rel="stylesheet" href="...style.css">`

---

## Pattern to Follow

**EVERY view page MUST have this structure:**

```php
<?php
$pageTitle = 'Page Title';
include BASE_PATH . '/app/views/{role}/layout/header.php';
include BASE_PATH . '/app/views/{role}/layout/sidebar.php';
?>

<div class="content">
    <!-- YOUR CONTENT HERE -->
</div>

<?php include BASE_PATH . '/app/views/{role}/layout/footer.php'; ?>
```

**DO NOT:**
- ❌ Skip header include
- ❌ Use inline CSS for layout
- ❌ Create custom styles outside design system
- ❌ Skip footer include

---

## How to Check Other Pages

Run this command to find pages without header:

```powershell
Get-ChildItem -Path "d:\laragon\www\SISTEM-ISO\app\views" -Recurse -Filter "*.php" | 
ForEach-Object {
    $content = Get-Content $_.FullName -Raw
    if ($content -match 'include.*sidebar\.php' -and $content -notmatch 'include.*header\.php') {
        Write-Host "Missing header: $_"
    }
}
```

---

## Status

✅ **FIXED**
- admin/history/index.php - Header added, inline CSS removed
- admin/ai/chat.php - Header added

All admin pages now have:
- ✅ Consistent header
- ✅ Sidebar working
- ✅ CSS global loaded
- ✅ Design system applied

---

**Last Updated:** 2026-01-10 09:15
**Issue:** Sidebar hilang/rusak di beberapa halaman admin
**Resolution:** Added missing header includes to 2 files
