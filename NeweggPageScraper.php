<?php
/**
 * Takes scraped HTML and formats into data structure required for Newegg products.
 */
class NeweggPageScraper extends PageScraper {

  /**
   *  Product attributes used as array keys to associate a product attribute
   *  with an Xpath expression and data parsing logic.
   *  I used constants to avoid redundancy.
   */
  private const ATTR_PRODUCT_NAME = 'product_name';
  private const ATTR_PRICE = 'price';
  private const ATTR_MODEL = 'model';

  // Set XPath expressions specific to Newegg product pages.
  protected function setXpathExpressions() {
    $this->xpath_expressions = [
      self::ATTR_PRODUCT_NAME => '//h1[@id="grpDescrip_h"]',
      self::ATTR_PRICE => '//meta[@itemprop="price"]/@content',
      self::ATTR_MODEL => '//li[@class="is-current"]/em',
    ];    
  }

  /**
   * Based on the product attribute, parse string to get requested data.
   * 
   * @param  array $attribute
   * @param  string $raw_string
   * @return string|null
   */
  protected function processProductData($attribute, $raw_string) {
    $val = NULL;
    if ($attribute == self::ATTR_PRODUCT_NAME) {
      $val = explode('|', $raw_string);
      if (!empty($val))
        $val = trim($val[0]);
    }
    elseif ($attribute == self::ATTR_PRICE)
      $val = floatval($raw_string);
    elseif ($attribute == self::ATTR_MODEL)
      $val = trim($raw_string);

    return $val;      
  }

  // Encapsulate constants.
  public function getProductNameAttr() {
    return self::ATTR_PRODUCT_NAME;
  }

  public function getProductPriceAttr() {
    return self::ATTR_PRICE;
  }

  public function getProductModelAttr() {
    return self::ATTR_MODEL;
  }   
}
