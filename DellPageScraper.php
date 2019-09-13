<?php
/**
 * Takes scraped HTML and formats into data structure required for Dell products.
 */
class DellPageScraper extends PageScraper {
  
  // Product attributes used as array keys to associate a product attribute
  // with an Xpath expression and data parsing logic.
  // I used constants to avoid redundancy.
  private const ATTR_PRODUCT_NAME = 'product_name';
  private const ATTR_PART_NUMBER = 'manufacturer_part_number';
  private const ATTR_PRICE = 'price';
  private const ATTR_CASH_REWARDS = 'cash_back_rewards';
  private const ATTR_COUPON_CODE = 'coupon_code';
  private const ATTR_MODEL = 'model';

  // Set XPath expressions specific to Dell product pages and correspond
  // to a Product's attribute.
  protected function setXpathExpressions() {
    $this->xpath_expressions = [
      self::ATTR_PRODUCT_NAME => '//h1[@data-testid="sharedPdPageProductTitle"]',
      self::ATTR_PART_NUMBER => '//li[starts-with(., "Manufacturer")]/node()',
      self::ATTR_PRICE => '//h5/strong/span[@data-testid="sharedPSPDellPrice"]',
      self::ATTR_CASH_REWARDS => '//div[@class="dellAdvantage"]',
      self::ATTR_COUPON_CODE => '//div[@class="message-bar-content"]/p',
      self::ATTR_MODEL => '//meta[@name="ProductId"]/@content',
    ];    
  }

  // Based on the Dell product attribute, parse string to get requested data.
  protected function processProductData($attribute, $raw_string) {
    $val = NULL;
    if ($attribute == self::ATTR_PRODUCT_NAME) {
      $val = explode('|', $raw_string);
      if (!empty($val))
        $val = trim($val[0]);
    }
    elseif ($attribute == self::ATTR_PART_NUMBER) {
      $val = explode('Manufacturer part ', $raw_string);
      if (!empty($val))
        $val = trim($val[1]);
    }
    elseif ($attribute == self::ATTR_PRICE)
      $val = floatval(str_replace('$', '', $raw_string));
    elseif ($attribute == self::ATTR_COUPON_CODE) {
      $reg = preg_match('/SAVE\w+/', $raw_string, $matches);
      if (!empty($matches))
        $val = $matches[0];
    }
    elseif ($attribute == self::ATTR_CASH_REWARDS) {
      $reg = preg_match('/\$\d+/', $raw_string, $matches);
      if (!empty($matches))
        $val =  intval(str_replace('$', '', $matches[0]));
    }
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
