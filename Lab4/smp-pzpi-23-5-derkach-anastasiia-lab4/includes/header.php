<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
$isLoggedIn = isset($_SESSION['userName']);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Сайт</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: sans-serif;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        .main-nav {
            background-color: #fff;
            padding: 15px 0;
            text-align: center;
            border-bottom: 1px solid #ddd;
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
</head>
<body>
<div class="page-wrapper">
    <header>
        <nav class="main-nav">
            <a href="main.php?page=index" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Головна</a>
            <a href="main.php?page=products" class="<?= $currentPage === 'products.php' ? 'active' : '' ?>">Товари</a>
            <a href="main.php?page=cart" class="<?= $currentPage === 'cart.php' ? 'active' : '' ?>">Кошик</a>

            <?php if ($isLoggedIn): ?>
                <a href="main.php?page=profile" class="<?= $currentPage === 'profile.php' ? 'active' : '' ?>">Профіль</a>
                <a href="logout.php">Вихід</a>
            <?php else: ?>
                <a href="main.php?page=login" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">Вхід</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>