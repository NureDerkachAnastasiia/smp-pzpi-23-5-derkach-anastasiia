<footer>
    <style>
        footer {
            margin-top: 50px;
            text-align: center;
            color: #888;
            font-family: sans-serif;
            font-size: 13px;
        }

        footer a {
            color: #888;
            text-decoration: none;
            margin: 0 10px;
            font-size: 13px;
        }

        footer a:hover {
            text-decoration: underline;
        }

        footer hr {
            margin: 30px 0 10px;
            border: none;
            border-top: 1px solid #ddd;
        }
    </style>

    <hr>
    <p>
        <a href="index.php">Головна</a> |
        <a href="products.php">Товари</a> |
        <a href="cart.php">Кошик</a>
    </p>
    <p>&copy; <?= date('Y') ?> Прості покупки</p>
</footer>