<?php
require_once __DIR__ . '/db/db.php';
$db = initDB(__DIR__ . '/db/shop.db');

session_start();
$sessionId = session_id();

$action = $_POST['action'] ?? '';

if ($action === 'add' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = (int) ($_POST['quantity'] ?? 1);

    $stmt = $db->prepare("SELECT id, quantity FROM cart WHERE session_id = :sid AND product_id = :pid");
    $stmt->bindValue(':sid', $sessionId, SQLITE3_TEXT);
    $stmt->bindValue(':pid', $productId, SQLITE3_INTEGER);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result) {
        $newQty = $result['quantity'] + $quantity;
        $update = $db->prepare("UPDATE cart SET quantity = :qty WHERE id = :id");
        $update->bindValue(':qty', $newQty, SQLITE3_INTEGER);
        $update->bindValue(':id', $result['id'], SQLITE3_INTEGER);
        $update->execute();
    } else {
        $insert = $db->prepare("INSERT INTO cart (session_id, product_id, quantity) VALUES (:sid, :pid, :qty)");
        $insert->bindValue(':sid', $sessionId, SQLITE3_TEXT);
        $insert->bindValue(':pid', $productId, SQLITE3_INTEGER);
        $insert->bindValue(':qty', $quantity, SQLITE3_INTEGER);
        $insert->execute();
    }

    header("Location: products.php");
    exit;

} elseif ($action === 'remove' && isset($_POST['product_id'])) {
    $stmt = $db->prepare("DELETE FROM cart WHERE session_id = :sid AND product_id = :pid");
    $stmt->bindValue(':sid', $sessionId, SQLITE3_TEXT);
    $stmt->bindValue(':pid', $_POST['product_id'], SQLITE3_INTEGER);
    $stmt->execute();

} elseif ($action === 'clear') {
    $stmt = $db->prepare("DELETE FROM cart WHERE session_id = :sid");
    $stmt->bindValue(':sid', $sessionId, SQLITE3_TEXT);
    $stmt->execute();
}

header("Location: cart.php");
exit;