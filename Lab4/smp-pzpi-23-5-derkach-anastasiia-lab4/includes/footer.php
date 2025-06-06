    </main>
    <footer>
        <style>
            footer {
                text-align: center;
                color: #888;
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
            <a href="main.php?page=index">Головна</a> |
            <a href="main.php?page=products">Товари</a> |
            <a href="main.php?page=cart">Кошик</a>
        </p>
        <p>&copy; <?= date('Y') ?> Прості покупки</p>
    </footer>
</div> 
</body>
</html>