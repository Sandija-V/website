<?php

require_once 'Product.php'; 

class DVD extends Product {
    protected $size;

    public function __construct($id, $sku, $name, $price, $type, $size) {
        parent::__construct($id, $sku, $name, $price, $type);
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    //Write addProduct() method to add a DVD to the database
    public function addProduct() {
        // Set the properties using the setters
        $this->setSku($_POST['sku']);
        $this->setName($_POST['name']);
        $this->setPrice($_POST['price']);
        $this->setType($_POST['type']);
        $this->setSize($_POST["size"]);
    
        // Insert the product into the database
        $database = new Database();
        $conn = $database->getConnection();
    
        // Insert data into products table
        $sql = "INSERT INTO products (sku, name, price, type) VALUES (:sku, :name, :price, :type)";
        $params = array(
            "sku" => $this->getSku(),
            "name" => $this->getName(),
            "price" => $this->getPrice(),
            "type" => $this->getType()
        );
        $stmt = $database->prepareStatement($sql, $params);
        $stmt->execute();
        $product_id = $conn->lastInsertId();
    
        // Insert data into product_details table based on type
        $sql_add = "INSERT INTO product_details (product_id, size) VALUES (:product_id, :size)";
        $params = array(
            "product_id" => $product_id,
            "size" => $this->getSize()
        );
        $stmt = $database->prepareStatement($sql_add, $params);
        $stmt->execute();
    }

    // public function displayProducts()
    // {   
    //     $database = new Database();
    //     $conn = $database->getConnection();

    //     $sql = "SELECT * FROM products INNER JOIN product_details ON products.id = product_details.product_id WHERE type = 'dvd'";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute();
    //     $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
    // }

    // public function displayProducts() {
    //     //get the properties of the DVD product
    //     $id = $this->getId();
    //     $sku = $this->getSku();
    //     $name = $this->getName();
    //     $price = $this->getPrice();
    //     $type = $this->getType();
    //     $size = $this->getSize();

    //     $dvd = new DVD($id, $sku, $name, $price, $type, $size);

    //     // Get all DVD products from the database
    //     $database = new Database();
    //     $conn = $database->getConnection();
    //     $sql = "SELECT * FROM products p INNER JOIN product_details d ON p.id = d.product_id WHERE p.type = 'DVD'";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute();
    //     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // Loop through the results and display data
    //     foreach ($results as $result) {
    //         // Set the properties of the DVD product using the result
    //         $dvd->setId($result['id']);
    //         $dvd->setSku($result['sku']);
    //         $dvd->setName($result['name']);
    //         $dvd->setPrice($result['price']);
    //         $dvd->setType($result['type']);
    //         $dvd->setSize($result['size']);
    //     }

    //     // Display the DVD product data
    //     echo '<div class="card">';
    //     echo '<label>';
    //     echo '<input type="checkbox" class="delete-checkbox">';
    //     echo '<div class="card-content">';
    //     echo '<h2 class="card-title">' . $dvd->getSku() . '</h2>';
    //     echo '<p class="card-text">' . $dvd->getName() . '</p>';
    //     echo '<p class="price">$' . $dvd->getPrice() . '</p>';
    //     echo '<p>Size: ' . $dvd->getSize() . '</p>';
    //     echo '</div>';
    //     echo '</label>';
    //     echo '</div>';
    // } 

     // Method to display the DVD product
    public function displayProducts() {
        echo '<h2>' . $this->getName() . '</h2>';
        echo '<p>Price: ' . $this->getPrice() . '</p>';
        echo '<p>Dimensions: ' . $this->getSize() . '</p>';
    }
}

?>