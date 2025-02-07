<?php
$product_ids = $_POST['product_ids'];
$product_quantities = $_POST['product_quantities'];
$product_prices = $_POST['product_prices'];
$product_shippings = $_POST['product_shippings'];
$product_totals = $_POST['product_totals'];

// Exibir

// Exibindo os valores recebidos
echo "Product ID: " . $product_ids . "<br>";
echo "Product Quantity: " . $product_quantities . "<br>";
echo "Product Price: " . $product_prices . "<br>";
echo "Product Shipping: " . $product_shippings . "<br>";
echo "Total Price: " . $product_totals . "<br>";
?>

