<?php
include('PageScraper.php');
include('DellPageScraper.php');
include('NeweggPageScraper.php');

// Traverse through these URLs and process with DellPageScraper.
$product_urls = [
  'https://www.dell.com/en-us/shop/accessories/apd/210-agnk?c=us&amp%3Bl=en&amp%3Bs=dhs&amp%3Bcs=19&amp%3Bsku=210-AGNK',
  'https://www.dell.com/en-us/shop/accessories/apd/341-2939?c=us&amp%3Bl=en&amp%3Bs=dhs&amp%3Bcs=19&amp%3Bsku=341-2939',
  'https://www.dell.com/en-us/shop/accessories/apd/580-agjp?c=us&amp%3Bl=en&amp%3Bs=dhs&amp%3Bcs=19&amp%3Bsku=580-AGJP',
];  

// DellPageScraper extends off PageScraper to
// scrape dell.com product pages.
$myDellPageScraper = new DellPageScraper();

echo '<h1>Dell Products</h1>';

foreach ($product_urls as $product_url) {
  $myDellPageScraper->setUrl($product_url);
  $product_info = $myDellPageScraper->scrape();

  var_dump($product_info);
  echo '<hr>';
}

// NeweggPageScraper extends off PageScraper to
// scrape newegg.com product pages.
$myNeweggPageScraper = new NeweggPageScraper();

$product_urls = [
  'https://www.newegg.com/acer-aspire-tc-885-accfli5-student-home-office/p/1VK-0017-009F2?Item=1VK-0017-009F2',
  'https://www.newegg.com/lenovo-thinkcentre-m710q-business-desktops-workstations/p/0WX-00DV-00017?Item=0WX-00DV-00017',
  'https://www.newegg.com/amd-ryzen-7-2700x/p/N82E16819113499',
]; 

echo '<h1>Newegg Products</h1>';

foreach ($product_urls as $product_url) {
  $myNeweggPageScraper->setUrl($product_url);
  $product_info = $myNeweggPageScraper->scrape();

  var_dump($product_info);
  echo '<hr>';
}

?>
