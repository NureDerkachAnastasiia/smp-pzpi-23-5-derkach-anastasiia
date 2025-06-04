<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Ласкаво просимо</title>
    <style>
        body { font-family: sans-serif; padding: 20px; text-align: center; }
        .welcome { margin-top: 50px; }
        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php if (isset($_GET['paid']) && $_GET['paid'] == 1): ?>
    <p style="background: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 4px;">
        Дякуємо за покупку! Ви можете продовжити перегляд товарів.
    </p>
<?php endif; ?>
<div class="welcome">
    <h1>Ласкаво просимо до нашого магазину!</h1>
    <p>Натисніть кнопку нижче, щоб переглянути доступні товари.</p>
    <a href="products.php" class="btn">До товарів</a>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>