<?php
class StoreProduct {
  private $name;
  private $model;
  private $price;

  public function __construct($name, $model, $price) {
    $this->name = $name;
    $this->model = $model;
    $this->price = $price;
  }

  public function getName() {
    return $this->name;
  }
  
  public function getModel() {
    return $this->model;
  }

  public function getPrice() {
    return $this->price;
  }

}
