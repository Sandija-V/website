<?php

abstract class Product {
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($id, $sku, $name, $price, $type) {
        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
    }

    public function getId() {
        return $this->id;
    }

    public function getSku() {
        echo $this->sku;
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getType() {
        return $this->type;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setType($type) {
        $this->type = $type;
    }

    //Write a function to add a product to the database based on the type of product    
    abstract public function addProduct();

    //Write a function to display a product based on the type of product
    abstract public function displayProducts();


}

?>