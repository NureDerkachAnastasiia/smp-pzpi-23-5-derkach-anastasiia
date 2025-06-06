<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page = $_GET['page'] ?? 'products';

require_once __DIR__ . '/includes/header.php';

if (!isset($_SESSION['userName']) && $page !== 'login') {
    require_once 'page404.php';
} else {
    switch ($page) {
        case 'index':
            require_once 'index.php';
            break;
        case 'cart':
            require_once 'cart.php';
            break;
        case 'profile':
            require_once 'profile.php';
            break;
        case 'products':
            require_once 'products.php';
            break;
        case 'login':
            require_once 'login.php';
            break;
        default:
            require_once 'page404.php';
            break;
    }
}

require_once __DIR__ . '/includes/footer.php';