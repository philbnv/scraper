<?php
/**
 * Performs cURL requests to scrape HTML from web pages.
 * Parsing of HTML performed by extended classes.
 */
abstract class PageScraper {

  // Properties common for all scrapers.
  protected $url;
  protected $xpath_expressions;

  function __construct() {
    // Xpath expressions are unique per parser,
    // child class will define these.
    $this->setXpathExpressions();
  }

  // Set and validate URL passed in.
  public function setUrl($url) {
    if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL))
      $this->url = $url;
    else
      $this->url = NULL;   
  }

  // Scrape page and send html to parser (if there is any),
  // Returns an associative array with product info in it or FALSE upon failure.
  public function scrape() {
    if (is_null($this->url))
      return FALSE;
    else {
      $ch = curl_init($this->url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      $html = curl_exec($ch);
      curl_close($ch);
      
      if ($html)
        return $this->_parse($html);
      else
        return FALSE;
    }
  }

  /*
  Using the scraped HTML and Xpath expressions,
  traverse through the $nodes and parse data based
  on the product attribute type. 
  The parsing logic is defined in the child parser.
  */
  private function _parse($html) {

    if (!$html || empty($this->xpath_expressions))
      return FALSE;

    $return_arr = [];

    $dom = new DOMDocument();
    $internalErrors = libxml_use_internal_errors(TRUE);

    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    foreach ($this->xpath_expressions as $attribute => $expression) {
      $nodes = $xpath->query($expression);

      if (count($nodes)) {
        foreach ($nodes as $node)
          $return_arr[$attribute] = $this->processProductData($attribute, $node->nodeValue);
      }
    }

    libxml_clear_errors();
    return $return_arr;
  }

  abstract protected function setXpathExpressions();
  abstract protected function processProductData($attribute, $raw_string);
  abstract public function getProductNameAttr();
  abstract public function getProductPriceAttr();
  abstract public function getProductModelAttr();

}
