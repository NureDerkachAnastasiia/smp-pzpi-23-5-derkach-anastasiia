<?php
require_once __DIR__ . '/db/db.php';
$db = initDB(__DIR__ . '/db/shop.db');

session_start();
$sessionId = session_id();

// Очищаем корзину
$stmt = $db->prepare("DELETE FROM cart WHERE session_id = :sid");
$stmt->bindValue(':sid', $sessionId, SQLITE3_TEXT);
$stmt->execute();

// Перенаправление на главную с параметром
header("Location: index.php?paid=1");
exit;