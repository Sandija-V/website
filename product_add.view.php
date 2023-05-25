<?php 

    require_once 'Database.php';
    require_once 'Product.php';
    require_once 'Book.php';
    require_once 'DVD.php';
    require_once 'Furniture.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $database = new Database();
        $conn = $database->getConnection();

        $type = $_POST['type'];
        switch ($type) {
            case 'dvd':
                $dvd = new DVD($id, $sku, $name, $price, $type, $size);
                $dvd->addProduct();
                break;
            case 'book':
                $book = new Book($id, $sku, $name, $price, $type, $weight);
                $book->addProduct();
                break;
            case 'furniture':
                $furniture = new Furniture($id, $sku, $name, $price, $type, $height, $width, $length);
                $furniture->addProduct();
                break;
        }

        // Close connection
        $conn = null;

    }

?> 

<!DOCTYPE html>
<html>
<head>
	<title>Product Add</title>
	<link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Product Add</h1>
            <div>
                <button class="btn" id="saveBtn">Save</button>
                <button onclick="location.href='product_list.view.php'" class="btn" id="cancel-product-btn">Cancel</button>
            </div>
        </div>

        <div class="container-form">
        <form action="product_list.view.php" method="POST" id="product_form">
            <div class="form-group">
                <label for="sku">SKU </label>
                <input type="text" id="sku" name="sku" required>
            </div>
            <div class="form-group">
                <label for="name">Name </label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="price">Price($) </label>
                <input type="number" id="price" name="price" min="0" step="0.01" required>
            </div>
            <div class="wrapper">
                <div class="menu">
                    <div class="form-group" id="form-group">
                        <label for="type">Type Switcher </label>
                        <select id="type" name="type" onchange="showFields()" required>
                        <option value="">Type Switcher</option>
                        <option value="dvd" id="DVD">DVD</option>
                        <option value="book" id="Book">Book</option>
                        <option value="furniture" id="Furniture">Furniture</option>
                        </select>
                    </div>
                </div>
            
            <div class="form-group" id="extraFields"></div>

            <div class="content">
                <div id="" class="data">
                </div>
                <div id="dvd" class="data">
                    <div class="form-group" id="form-group">
                        <label for="size">Size (MB) </label>
                        <input type="number" id="size" name="size" min="0" step="0.01" required>
                    </div> 
                    <div style="display: block;">
                        <p>Please provide size in megabytes (MB) when type: DVD is selected. </p>
                    </div> 
                </div>
                <div id="book" class="data">
                    <div class="form-group" id="form-group">
                        <label for="weight">Weight (KG) </label>
                        <input type="number" id="weight" name="weight" min="0" step="0.01" required>
                    </div>
                    <div style="display: block;">
                        <p>Please provide weight in kilograms (KG) when type: Book is selected. </p>
                    </div>
                </div>
                <div id="furniture" class="data">
                    <div class="form-group" id="form-group">
                            <label for="height">Height (CM) </label>
                            <input type="number" id="height" name="height" min="0" step="0.01" required>
                        </div>
                        <div class="form-group" id="form-group">
                            <label for="width">Width (CM) </label>
                            <input type="number" id="width" name="width" min="0" step="0.01" required>
                        </div>
                        <div class="form-group" id="form-group">
                            <label for="length">Length (CM) </label>
                            <input type="number" id="length" name="length" min="0" step="0.01" required>
                        </div>
                        <div style="display: block;">
                            <p>Please provide dimensions in HxWxL format when type: Furniture is selected. </p>
                        </div>
                </div>    
            </div>
            </form>
        </div>
        </div>

        <script>
            $(document).ready(function(){
                $("#type").on('change', function(){
                    $(".data").hide();
                    $("#" + $(this).val()).fadeIn(700);
                }).change();
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#saveBtn').click(function() {
                    $.ajax({
                    url: 'product_add.view.php',
                    type: 'POST',
                    data: $('#product_form').serialize(),
                    success: function(response) {
                        console.log(response);
                        //alert("Connection successfull");
                        window.location.href = 'product_list.view.php';
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        //alert("Not connected");
                    }
                });
            });
        });
        </script>

        <div class="footer">
            <p class="footer-text">A Simple Website</p>
        </div>
    </div>
</body>
</html>