<?php

require_once 'Product.php'; 

class Furniture extends Product {
    protected $height;
    protected $width;
    protected $length;

    public function __construct($id, $sku, $name, $price, $type, $height, $width, $length) {
        parent::__construct($id, $sku, $name, $price, $type);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getLength() {
        return $this->length;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    //Write addProduct function to add a furniture product to the database
    public function addProduct() {

        // Set the properties using the setters
        $this->setSku($_POST['sku']);
        $this->setName($_POST['name']);
        $this->setPrice($_POST['price']);
        $this->setType($_POST['type']);
        $this->setHeight($_POST["height"]);
        $this->setWidth($_POST["width"]);
        $this->setLength($_POST["length"]);
    
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
        $sql_add = "INSERT INTO product_details (product_id, height, length, width) VALUES (:product_id, :height, :length, :width)";
        $params = array(
            "product_id" => $product_id,
            "height" => $this->getHeight(),
            "length" => $this->getLength(),
            "width" => $this->getWidth()
        );
        $stmt = $database->prepareStatement($sql_add, $params);
        $stmt->execute();
    }

    // public function displayProducts()
    // {   

    //     //how to display furiture products using setters and getters
    //     $database = new Database();
    //     $conn = $database->getConnection();

    //     $sql = "SELECT * FROM products INNER JOIN product_details ON products.id = product_details.product_id WHERE type = 'furniture'";
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
    //     $height = $this->getHeight();
    //     $length = $this->getLength();
    //     $width = $this->getWidth();

    //     $furniture = new Furniture($id, $sku, $name, $price, $type, $height, $length, $width);

    //     // Get all DVD products from the database
    //     $database = new Database();
    //     $conn = $database->getConnection();
    //     $sql = "SELECT * FROM products p INNER JOIN product_details d ON p.id = d.product_id WHERE p.type = 'furniture'";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute();
    //     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // Loop through the results and display data
    //     foreach ($results as $result) {
    //         // Set the properties of the DVD product using the result
    //         $furniture->setId($result['id']);
    //         $furniture->setSku($result['sku']);
    //         $furniture->setName($result['name']);
    //         $furniture->setPrice($result['price']);
    //         $furniture->setType($result['type']);
    //         $furniture->setHeight($result['height']);   
    //         $furniture->setLength($result['length']);
    //         $furniture->setWidth($result['width']);
    
    //     }

    //     //Display the furniture product data
    //     echo '<div class="card">';
    //     echo '<label>';
    //     echo '<input type="checkbox" class="delete-checkbox">';
    //     echo '<div class="card-content">';
    //     echo '<h2 class="card-title">' . $furniture->getSku() . '</h2>';
    //     echo '<p class="card-text">' . $furniture->getName() . '</p>';
    //     echo '<p class="price">$' . $furniture->getPrice() . '</p>';
    //     echo '<p>Dimension: ' . $furniture->getHeight(). 'x' . $furniture->getLength() . 'x' . $furniture->getWidth() . '</p>';
    //     echo '</div>';
    //     echo '</label>';
    //     echo '</div>';
    // } 

    
    // Method to display the furniture product
    public function displayProducts() {
        echo '<p>SKU: ' . $this->getSku() . '</p>';
        echo '<h2>' . $this->getName() . '</h2>';
        echo '<p>Price: ' . $this->getPrice() . '</p>';
        echo '<p>Dimensions: ' . $this->getHeight() . 'x' . $this->getWidth() . 'x' . $this->getLength() . '</p>';
    }
}

?>