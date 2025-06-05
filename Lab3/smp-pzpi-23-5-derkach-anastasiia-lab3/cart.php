<?php
require_once __DIR__ . '/db/db.php';
$db = initDB(__DIR__ . '/db/shop.db');

session_start();
$sessionId = session_id();
$query = "
    SELECT
        c.product_id,
        p.name,
        p.price,
        c.quantity,
        (p.price * c.quantity) AS total
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.session_id = :sid
";

$stmt = $db->prepare($query);
$stmt->bindValue(':sid', $sessionId, SQLITE3_TEXT);
$result = $stmt->execute();

$items = [];
$totalSum = 0;

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $items[] = $row;
    $totalSum += $row['total'];
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кошик</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        .actions form { display: inline; margin: 0; }
        .clear-btn { margin-top: 20px; }
        .button {
            background-color: #dc3545;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .button:hover {
            background-color: #a71d2a;
        }

        .button-pay {
            background-color: #007bff;
        }

        .button-pay:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<h1>Ваш кошик</h1>

<?php if (empty($items)): ?>
    <p>Кошик порожній.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Назва</th>
            <th>Ціна</th>
            <th>Кількість</th>
            <th>Сума</th>
            <th>Дія</th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= number_format($item['price'], 2) ?> грн</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['total'], 2) ?> грн</td>
                <td class="actions">
                    <form method="post" action="cart_actions.php">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                        <button type="submit" class="button">Видалити</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Разом:</strong></td>
            <td><strong><?= number_format($totalSum, 2) ?> грн</strong></td>
            <td></td>
        </tr>
    </table>

    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
        <form method="post" action="cart_actions.php">
            <input type="hidden" name="action" value="clear">
            <button type="submit" class="button button-danger">Очистити кошик</button>
        </form>

        <form method="post" action="checkout.php">
            <button type="submit" class="button button-pay">Оплатити</button>
        </form>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>

</body>
</html>
