<?php

require_once 'Product.php'; 

class Book extends Product {
    protected $weight;
    
    public function __construct($id, $sku, $name, $price, $type, $weight) {
        parent::__construct($id, $sku, $name, $price, $type);
        $this->weight = $weight;
    }
    
    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function addProduct() {
        // Set the properties using the setters
        $this->setSku($_POST['sku']);
        $this->setName($_POST['name']);
        $this->setPrice($_POST['price']);
        $this->setType($_POST['type']);
        $this->setWeight($_POST["weight"]);
    
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
        $sql_add = "INSERT INTO product_details (product_id, weight) VALUES (:product_id, :weight)";
        $params = array(
            "product_id" => $product_id,
            "weight" => $this->getWeight()
        );
        $stmt = $database->prepareStatement($sql_add, $params);
        $stmt->execute();
    }

    // public function displayProducts()
    // {   
    //     $database = new Database();
    //     $conn = $database->getConnection();

    //     $sql = "SELECT * FROM products INNER JOIN product_details ON products.id = product_details.product_id WHERE type = 'book'";
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
    //     $weight = $this->getWeight();

    //     $book = new Book($id, $sku, $name, $price, $type, $weight);

    //     // Get all DVD products from the database
    //     $database = new Database();
    //     $conn = $database->getConnection();
    //     $sql = "SELECT * FROM products p INNER JOIN product_details d ON p.id = d.product_id WHERE p.type = 'book'";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute();
    //     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // Loop through the results and display data
    //     foreach ($results as $result) {
    //         // Set the properties of the DVD product using the result
    //         $book->setId($result['id']);
    //         $book->setSku($result['sku']);
    //         $book->setName($result['name']);
    //         $book->setPrice($result['price']);
    //         $book->setType($result['type']);
    //         $book->setWeight($result['weight']);
    //     }

    //     // Display the book product data
    //     echo '<div class="card">';
    //     echo '<label>';
    //     echo '<input type="checkbox" class="delete-checkbox">';
    //     echo '<div class="card-content">';
    //     echo '<h2 class="card-title">' . $book->getSku() . '</h2>';
    //     echo '<p class="card-text">' . $book->getName() . '</p>';
    //     echo '<p class="price">$' . $book->getPrice() . '</p>';
    //     echo '<p>Weight: ' . $book->getWeight() . '</p>';
    //     echo '</div>';
    //     echo '</label>';
    //     echo '</div>';
    // } 

    // Method to display the book product
    public function displayProducts() {
        echo '<h2>' . $this->getName() . '</h2>';
        echo '<p>Price: ' . $this->getPrice() . '</p>';
        echo '<p>Dimensions: ' . $this->getWeight() . '</p>';
    }
}

?>