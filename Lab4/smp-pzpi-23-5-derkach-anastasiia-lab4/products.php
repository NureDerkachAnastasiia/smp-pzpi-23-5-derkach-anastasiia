<?php
require_once __DIR__ . '/db/db.php';
$db = initDB(__DIR__ . '/db/shop.db');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sessionId = session_id();

$result = $db->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Товари</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        form { display: inline; margin: 0; }
        .button {
            background-color: #007BFF;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>


<h1>Виберіть товари</h1>

<table>
    <tr>
        <th>Назва</th>
        <th>Ціна</th>
        <th>Кількість</th>
        <th></th>
    </tr>

    <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= number_format($row['price'], 2) ?> грн</td>
            <td>
                <form method="post" action="cart_actions.php">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                    <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
            </td>
            <td>
                    <button type="submit" class="button">Додати</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>


</body>
</html>