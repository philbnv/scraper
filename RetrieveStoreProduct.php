<?php
/**
 * Based on URL passed in, this class can determine which
 * scraper to use. It can also scrape a page using the correct
 * scraper and return the product info into a StoreProduct object.
 */
class RetrieveStoreProduct {

  private $url;
  private $scraper;

  // When a URL is passed in, determine if a scraper is available.
  public function setUrl($url) {
    if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
      $this->url = $url;
      $this->_determineScraper();
    }
    else {
      $this->url = NULL;
      return FALSE; 
    }
  }

  private function _determineScraper() {

    if (empty($this->url))
      return FALSE;
    elseif (strpos($this->url, 'newegg.com') !== FALSE)
      $this->scraper = 'NeweggPageScraper';
     elseif (strpos($this->url, 'dell.com') !== FALSE)
      $this->scraper = 'DellPageScraper';  
    else {
      $this->scraper = NULL;
      return FALSE;
    }
  }

  // If valid scraper is available, then scrape
  // with correct scraper and pass the resulting data into
  // a StoreProduct object.
  public function getStoreProduct() {

    if (empty($this->scraper))
      return FALSE;

    $myScraper = new $this->scraper();
    $myScraper->setUrl($this->url);
    $product = $myScraper->scrape();

    if ($product) {
      return new StoreProduct(
        ($product[$myScraper->getProductNameAttr()] ?: NULL),
        ($product[$myScraper->getProductModelAttr()] ?: NULL),
        ($product[$myScraper->getProductPriceAttr()] ?: NULL)
      );
    }
    else
      return FALSE;
  }

}
