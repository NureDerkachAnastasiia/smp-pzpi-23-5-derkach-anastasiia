<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header>
    <style>
        .main-nav {
            background-color: #fff;
            padding: 15px 0;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-family: sans-serif;
        }

        .main-nav a {
            margin: 0 30px;
            text-decoration: none;
            color: #000;
            font-size: 16px;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .main-nav a.active {
            color: #007bff;
            border: 1px solid #007bff;
        }

        .main-nav a:hover {
            color: #555;
        }
    </style>

    <nav class="main-nav">
        <a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Головна</a>
        <a href="products.php" class="<?= $currentPage === 'products.php' ? 'active' : '' ?>">Товари</a>
        <a href="cart.php" class="<?= $currentPage === 'cart.php' ? 'active' : '' ?>">Кошик</a>
    </nav>
</header>