<?php
include('PageScraper.php');
include('DellPageScraper.php');
include('NeweggPageScraper.php');
include('StoreProduct.php');
include('RetrieveStoreProduct.php');

/*
 * RetrieveStoreProduct can scrape pages and pass resulting
 * data back into a StoreProduct object.
 * It is capable of detecting which scraper to use.
 */
$myStoreProductGetter = new RetrieveStoreProduct();

echo '<h1>Getting Dell &amp; Newegg Products as StoreProduct Object</h1>
<p>The products alternate between Dell.com and Newegg.com products.</p>
';

// Traverse through these URLs, $myStoreProductGetter will know which scraper to use.
$product_urls = [
  'https://www.dell.com/en-us/shop/accessories/apd/210-agnk?c=us&amp%3Bl=en&amp%3Bs=dhs&amp%3Bcs=19&amp%3Bsku=210-AGNK',
  'https://www.newegg.com/acer-aspire-tc-885-accfli5-student-home-office/p/1VK-0017-009F2?Item=1VK-0017-009F2',
  'https://www.dell.com/en-us/shop/accessories/apd/341-2939?c=us&amp%3Bl=en&amp%3Bs=dhs&amp%3Bcs=19&amp%3Bsku=341-2939',
  'https://www.newegg.com/lenovo-thinkcentre-m710q-business-desktops-workstations/p/0WX-00DV-00017?Item=0WX-00DV-00017',
  'https://www.dell.com/en-us/shop/accessories/apd/580-agjp?c=us&amp%3Bl=en&amp%3Bs=dhs&amp%3Bcs=19&amp%3Bsku=580-AGJP',
  'https://www.newegg.com/amd-ryzen-7-2700x/p/N82E16819113499',  
];  

foreach ($product_urls as $url) {
  $myStoreProductGetter->setUrl($url);

  $myStoreProduct = $myStoreProductGetter->getStoreProduct();

  if ($myStoreProduct) {
    var_dump($myStoreProduct);
    echo '<p>';
    echo '<strong>URL:</strong> ' . $url . '<br>';
    echo '<strong>Name:</strong> ' . $myStoreProduct->getName() . '<br>';
    echo '<strong>Price:</strong> ' . $myStoreProduct->getPrice() . '<br>';
    echo '<strong>Model</strong>: ' . $myStoreProduct->getModel() . '<br>';
    echo '<hr></p>';
  }
}

?>
