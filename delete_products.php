<?php
    // delete_products.php

    require_once 'Database.php';
    require_once 'DeleteProducts.php';
    require_once 'product_list.view.php';

    // Check if the selectedProducts array is present in the POST data
    if (isset($_POST['selectedProducts'])) {
        // Retrieve the selected product IDs from the POST data
        $selectedProducts = $_POST['selectedProducts'];

        // Create an instance of DeleteProducts and pass the selected product IDs
        $deleteProducts = new DeleteProducts($selectedProducts);

        // Call the delete method to perform the deletion
        $result = $deleteProducts->delete();

        // Output the result
        echo $result;
    } else {
        echo "No products were selected.";
    }


?>

