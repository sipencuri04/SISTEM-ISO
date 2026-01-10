# 🔧 FIX: Deprecated htmlspecialchars() Warning

## Masalah
**PHP 8.1+ Deprecated Warning:**
```
Deprecated: htmlspecialchars(): Passing null to parameter #1 ($string) 
of type string is deprecated
```

Muncul di beberapa halaman ketika data database memiliki nilai NULL.

## Root Cause
PHP 8.1+ **tidak menerima null** sebagai parameter ke `htmlspecialchars()`.

**Sebelum (PHP < 8.1):**
```php
<?= htmlspecialchars($doc['field']) ?>  // OK jika null
```

**Sekarang (PHP 8.1+):**
```php
<?= htmlspecialchars($doc['field']) ?>  // ❌ Error jika null!
```

## Solusi

Gunakan **null coalescing operator** (`??`) untuk provide default value:

```php
// ✅ BENAR
<?= htmlspecialchars($doc['field'] ?? '') ?>
<?= htmlspecialchars($doc['field'] ?? '-') ?>
<?= htmlspecialchars($doc['field'] ?? 'Default') ?>
```

## Files yang Sudah Diperbaiki

### 1. admin/history/index.php

**Fixed lines:**
- Line 51: `htmlspecialchars($doc['kode_dokumen'] ?? '')`
- Line 54: `htmlspecialchars($doc['judul_baru'] ?? $doc['nama_dokumen'] ?? '')`
- Line 57: `htmlspecialchars($doc['pengaju'] ?? '-')`
- Line 62: `htmlspecialchars($doc['versi'] ?? 'V1.0')`
- Line 65: `htmlspecialchars($doc['departemen'] ?? '-')`
- Line 66: `htmlspecialchars($doc['jenis_pengajuan'] ?? '-')`
- Line 80: `date(...) : '-'` for created_at

## Pattern to Follow

### For Optional Fields
```php
<?= htmlspecialchars($data['optional_field'] ?? '-') ?>
```

### For Required Fields with Fallback
```php
<?= htmlspecialchars($data['field'] ?? '') ?>
```

### For Fields with Multiple Fallbacks
```php
<?= htmlspecialchars($data['field1'] ?? $data['field2'] ?? 'Default') ?>
```

### For Dates
```php
<?= isset($data['date']) ? date('d M Y', strtotime($data['date'])) : '-' ?>
```

## Search & Replace Command

To find all potential issues:

```powershell
# Find files with htmlspecialchars that might need fixing
Get-ChildItem -Path "d:\laragon\www\SISTEM-ISO\app\views" -Recurse -Filter "*.php" | 
Select-String -Pattern "htmlspecialchars\(\\\$[^)]+\)"
```

## Common Fields to Check

These database fields are often NULL and should always have `??` fallback:

```php
// User fields
'nama' ?? ''
'email' ?? ''
'departemen' ?? '-'

// Document fields  
'judul_lama' ?? '-'
'judul_baru' ?? ''
'deskripsi_perubahan' ?? ''
'dampak_perubahan' ?? ''
'revisi_lama' ?? '-'
'pengaju' ?? '-'

// Dates
'created_at' - always use isset() check
'updated_at' - always use isset() check
```

## Testing

After fix, check:
1. ✅ No deprecated warnings in browser console
2. ✅ No warnings shown on page
3. ✅ All fields display correctly (empty or with dash)
4. ✅ Search still works
5. ✅ Table renders properly

## Verification Checklist

- [x] admin/history/index.php - All htmlspecialchars() fixed
- [ ] Other view files - Need to check and fix if needed

---

**Status:** FIXED for admin/history/index.php
**Date:** 2026-01-10 09:14
**PHP Version:** Compatible with PHP 8.1+
