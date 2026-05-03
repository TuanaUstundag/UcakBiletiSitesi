<?php
require_once 'auth_check.php';
require_once '../baglanti.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $db->prepare("DELETE FROM ucuslar WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
}

header('Location: ucuslar.php');
exit();
?>