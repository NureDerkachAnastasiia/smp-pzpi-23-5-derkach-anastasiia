<?php

$MIN_QUANTITY = 0;
$MAX_QUANTITY = 100;
$MIN_AGE = 7;
$MAX_AGE = 150;

$json = file_get_contents("products.json");
$products = json_decode($json, true);

function showMainMenuHeader() {
    echo "################################\n";
    echo "# ПРОДОВОЛЬЧИЙ МАГАЗИН \"ВЕСНА\" #\n";
    echo "################################\n";
}

function showMainMenu(){
    echo "1 Вибрати товари\n";
    echo "2 Отримати підсумковий рахунок\n";
    echo "3 Налаштувати свій профіль\n";
    echo "0 Вийти з програми\n";
}
function input($prompt){
    echo $prompt;
    return trim(fgets(STDIN));
}
function showProducts($products) {
    echo "№  НАЗВА                 ЦІНА\n";
    foreach ($products as $num => $item) {
        echo "{$num}  {$item['name']}";
        $spaces = 22 - My_strlen($item['name']);
        for ($f = 0; $f < $spaces; $f++) {
            echo " ";
        }
        echo $item['price'] . "\n";
    }
    echo "   -----------\n";
    echo "0  ПОВЕРНУТИСЯ\n";
}
function showCart($cart, $products) {
    if(empty($cart)) {
        echo "КОШИК ПОРОЖНІЙ\n";
        return;
    }
    echo "У КОШИКУ:\n";
    echo "НАЗВА                 КІЛЬКІСТЬ\n";
    foreach ($cart as $id => $qty) {
        echo $products[$id]["name"];
        $spaces = 22 - My_strlen($products[$id]["name"]);
        for ($f = 0; $f < $spaces; $f++) {
            echo " ";
        }
        echo $qty . "\n";
    }
}
function handleBuy(&$cart, $products){
    global $MIN_QUANTITY, $MAX_QUANTITY;
    while(true) {
        showProducts( $products);
        $choice = input("Виберіть товар: ");
        if(!is_numeric($choice)) {
            echo "ПОМИЛКА! Вкажіть число\n";
            continue;
        }
        $choice = (int) $choice;
        if($choice === 0) {
            break;
        }
        if(!array_key_exists($choice, $products)){
            echo "ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНИЙ НОМЕР ТОВАРУ\n";
            continue;
        }
        echo "Вибрано: {$products[$choice]['name']}\n";
        echo "Введіть кількість штук: ";
        $qty = trim(fgets(STDIN));
        if(!is_numeric($qty)) {
            echo "ПОМИЛКА! Введіть число\n";
            continue;
        }
        $qty = (int) $qty;
        if($qty < $MIN_QUANTITY || $qty >= $MAX_QUANTITY) {
            echo "ПОМИЛКА! Кількість повинна бути більше {$MIN_QUANTITY} і менше {$MAX_QUANTITY}\n";
            continue;
        }
        if($qty === 0){
            echo "ВИДАЛЯЮ ТОВАР З КОШИКА\n";
            unset($cart[$choice]);
        } else {
            $cart[$choice] = $qty;
        }
        showCart($cart, $products);
    }
}
function My_strlen($str)
{
    $len = strlen($str);
    $count = 0;
    for ($i = 0; $i < $len; $i++) {
        $char = ord($str[$i]);
        if ($char <= 127) {
            $count++;
        } elseif ($char >> 5 == 0b110) {
            $i += 1;
            $count++;
        } elseif ($char >> 4 == 0b1110) {
            $i += 2;
            $count++;
        } elseif ($char >> 3 == 0b11110) {
            $i += 3;
            $count++;
        } else {
            continue;
        }
    }
    return $count;
}
showMainMenuHeader();
while(true){
    showMainMenu();
    $cmd = input("Введіть команду: ");
    switch($cmd){
    case "1":
            handleBuy($cart, $products);
            break;
    case "2":
            if(empty($cart)){
                echo "КОШИК ПОРОЖНІЙ\n";
            } else {
                echo "№  НАЗВА                 ЦІНА  КІЛЬКІСТЬ  ВАРТІСТЬ\n";
                $i = 1;
                $total = 0;
                foreach ($cart as $id => $qty) {
                    $name = $products[$id]["name"];
                    $price = $products[$id]["price"];
                    $lineTotal = $price * $qty;
                    $total += $lineTotal;
                    echo $i . "  ";
                    echo $name;
                    $spaces = 22 - My_strlen($name);
                    for ($f = 0; $f < $spaces; $f++) {
                        echo " ";
                    }
                    echo $price . "    ";
                    if(strlen((string)$price) == 1){
                        echo " ";
                    }
                    echo $qty . "         ";
                    if(strlen((string)$qty) == 1){
                        echo " ";
                    }
                    echo $lineTotal . "\n";
                    $i++;
                }
                echo "РАЗОМ ДО CПЛАТИ: $total\n";
            }
            break;
    case "3":
            while(true){
                $name = input("Введіть ім'я: ");
                if(strlen($name) < 1){
                    echo "ПОМИЛКА! Ім'я повинно містити хоча б одну літеру\n";
                    continue;
                }
                break;
            }
            while(true){
                $age = input("Введіть вік: ");
                if(!is_numeric($age) || $age < 7 || $age > 150){
                    echo "ПОМИЛКА! Вік повинен бути від {$MIN_AGE} до {$MAX_AGE} років\n";
                    continue;
                }
                $age = (int)$age;
                break;
            }
            $user["name"] = $name;
            $user["age"] = $age;

            echo "\n";
            echo "Ваше ім'я: {$name}\n";
            echo "Ваш вік: {$age}\n";
            echo "\n";
            break;
    case "0":
            echo "Ви обрали: Вийти з програми\n";
            exit;
    default:
            echo "ПОМИЛКА! Введіть правильну команду\n";
    }
}
?>
