<?php

$dbPath = __DIR__ . '/shop.db';
function initDB(string $dbPath): SQLite3 {
    
    global $dbPath;

    $db = new SQLite3($dbPath);

    $db->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        price REAL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS cart (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        session_id TEXT,
        product_id INTEGER,
        quantity INTEGER DEFAULT 1,
        FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
    )");

    $count = $db->querySingle("SELECT COUNT(*) FROM products");
    if ($count == 0) {
        $db->exec("INSERT INTO products (name, price) VALUES
            ('Молоко пастеризоване', 12),
            ('Хліб чорний', 9),
            ('Сир білий', 21),
            ('Сметана 20%', 25),
            ('Кефір 1%', 19),
            ('Вода газована', 18),
            ('Печиво \"Весна\"', 14)
        ");
    }

    return $db;
}
