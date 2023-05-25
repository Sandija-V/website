<?php
    // DeleteProducts.php

    require_once 'Database.php';
    require_once 'Product.php';
    require_once 'DVD.php';
    require_once 'Book.php';
    require_once 'Furniture.php';

    class DeleteProducts
    {
        private $selectedProducts;

        public function __construct($selectedProducts)
        {
            $this->selectedProducts = $selectedProducts;
        }

        public function delete()
        {
            // Perform the deletion of selected products from the database
            // Modify the code according to your database structure and deletion logic
            $database = new Database();
            $conn = $database->getConnection();
            
            try {
                // Start a transaction
                $conn->beginTransaction();

                // Prepare the DELETE statements for both tables
                $placeholders = rtrim(str_repeat('?,', count($this->selectedProducts)), ',');
                $deleteProductsSql = "DELETE FROM products WHERE id IN ($placeholders)";
                $deleteProductDetailsSql = "DELETE FROM product_details WHERE product_id IN ($placeholders)";

                // Execute the DELETE statements
                $stmtDeleteProducts = $conn->prepare($deleteProductsSql);
                $stmtDeleteProductDetails = $conn->prepare($deleteProductDetailsSql);
                $stmtDeleteProducts->execute($this->selectedProducts);
                $stmtDeleteProductDetails->execute($this->selectedProducts);

                // Check if any rows were affected in either table
                $rowCountProducts = $stmtDeleteProducts->rowCount();
                $rowCountProductDetails = $stmtDeleteProductDetails->rowCount();

                // Commit the transaction if successful
                $conn->commit();

                // Check if any rows were affected in both tables
                if ($rowCountProducts > 0 || $rowCountProductDetails > 0) {
                    return "Successfully deleted $rowCountProducts product(s) from the products table and $rowCountProductDetails product(s) from the product_details table.";
                } else {
                    return "No products were deleted.";
                }
            } catch (PDOException $e) {
                // Rollback the transaction if an error occurs
                $conn->rollBack();
                return "An error occurred while deleting products: " . $e->getMessage();
            }
        }
    }
