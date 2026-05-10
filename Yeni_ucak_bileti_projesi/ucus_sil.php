<?php
/**
 * Uçuş Silme
 * HATA DÜZELTMELERİ:
 * - GET ile silme işlemi → CSRF açığı! POST + token ile korundu
 * - ucuslar.php'deki silme linkini de POST form ile güncelleyin
 */
require_once 'auth_check.php';
require_once '../baglanti.php';

// Sadece POST isteğini kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ucuslar.php');
    exit();
}

// CSRF token kontrolü
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    header('Location: ucuslar.php?hata=csrf');
    exit();
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $stmt = $db->prepare("DELETE FROM ucuslar WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: ucuslar.php?silindi=1');
exit();
