<?php
/**
 * Helper Functions untuk Sistem ISO
 * Digunakan di semua view pages
 */

/**
 * Safe htmlspecialchars untuk PHP 8.1+
 * Handles null values automatically
 * 
 * @param mixed $string - String or null
 * @param int $flags - htmlspecialchars flags
 * @param string $fallback - Default value jika null
 * @return string
 */
function e($string, $fallback = '', $flags = ENT_QUOTES | ENT_HTML5) {
    if ($string === null || $string === '') {
        return $fallback;
    }
    return htmlspecialchars($string, $flags, 'UTF-8');
}

/**
 * Safe nl2br + htmlspecialchars
 * 
 * @param mixed $string
 * @param string $fallback
 * @return string
 */
function eNL($string, $fallback = '-') {
    if ($string === null || $string === '') {
        return $fallback;
    }
    return nl2br(e($string, $fallback));
}

/**
 * Format tanggal dengan safe handling
 * 
 * @param mixed $date
 * @param string $format
 * @param string $fallback
 * @return string
 */
function formatDate($date, $format = 'd M Y', $fallback = '-') {
    if (empty($date)) {
        return $fallback;
    }
    try {
        return date($format, strtotime($date));
    } catch (Exception $e) {
        return $fallback;
    }
}

/**
 * Format tanggal dengan waktu
 * 
 * @param mixed $datetime
 * @param string $fallback
 * @return string
 */
function formatDateTime($datetime, $fallback = '-') {
    return formatDate($datetime, 'd M Y H:i', $fallback);
}

/**
 * Get badge class based on status
 * 
 * @param string $status
 * @return string
 */
function getBadgeClass($status) {
    $status = strtolower($status ?? '');
    
    if (strpos($status, 'disetujui') !== false || strpos($status, 'selesai') !== false) {
        return 'success';
    } elseif (strpos($status, 'ditolak') !== false) {
        return 'danger';
    } elseif (strpos($status, 'menunggu') !== false) {
        return 'warning';
    } else {
        return 'info';
    }
}

/**
 * Render status badge
 * 
 * @param string $status
 * @return string
 */
function statusBadge($status) {
    $class = getBadgeClass($status);
    return '<span class="badge ' . $class . '">' . e($status, '-') . '</span>';
}
