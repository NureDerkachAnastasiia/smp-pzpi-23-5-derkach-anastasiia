<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($login && $password) {
        $credentials = require 'credential.php';

        if ($login === $credentials['userName'] && $password === $credentials['password']) {
            $_SESSION['userName'] = $login;
            $_SESSION['loginTime'] = date('Y-m-d H:i:s');
            header('Location: main.php?page=products');
            exit;
        } else {
            $error = 'Невірне ім’я користувача або пароль.';
        }
    } else {
        $error = 'Будь ласка, заповніть всі поля.';
    }
}
?>

<style>
    .form-container {
        max-width: 400px;
        margin: 40px auto;
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        font-family: sans-serif;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-container label {
        display: block;
        margin-bottom: 12px;
        font-weight: bold;
    }

    .form-container input {
        width: 100%;
        padding: 8px;
        margin-top: 4px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-container button {
        width: 100%;
        margin-top: 20px;
        background-color: #007BFF;
        color: white;
        padding: 10px;
        font-weight: bold;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-container button:hover {
        background-color: #0056b3;
    }

    .error {
        color: red;
        margin-bottom: 10px;
        text-align: center;
    }
</style>

<div class="form-container">
    <h2>Вхід</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Ім’я користувача:
            <input type="text" name="login" required>
        </label>
        <label>Пароль:
            <input type="password" name="password" required>
        </label>
        <button type="submit">Увійти</button>
    </form>
</div>