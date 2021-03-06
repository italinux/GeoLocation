<?php

require_once(__DIR__.'/../lib/Geo/Autoload.php');

Geo\Autoload::register();

class Search extends Geo\Search
{
  protected function configure()
  {
    $this->addService(new Geo\Service\YahooMap\PlaceFinder);
  }
}


$search = new Search();

try
{
  $search->query('12, Spencer road, Greenland  ');
  $location_a = $search->getFirst();
  echo 'Address1: 12, Spencer road, Greenland'.PHP_EOL;
  echo 'Latitude: '.$location_a->getLatitude().PHP_EOL;
  echo 'Longitude: '.$location_a->getLongitude().PHP_EOL.PHP_EOL;


}
catch(Exception $e)
{
  $services = $search->getServices();
  echo 'Status: '.$services[0]->getStatus().PHP_EOL;
  echo 'Service results: '.print_r($services[0]->getServiceResults()).PHP_EOL;
}


try
{
  $search->query('piazza Boccolino, Osimo');
  $location_b = $search->getFirst();
  echo 'Address2: piazza Boccolino, Osimo'.PHP_EOL;
  echo 'Latitude: '.$location_b->getLatitude().PHP_EOL;
  echo 'Longitude: '.$location_b->getLongitude().PHP_EOL.PHP_EOL;
  echo 'Distance from Address1 to Address2: '.$location_a->distance($location_b).' Km'.PHP_EOL;
}
catch(Exception $e)
{
  $services = $search->getServices();
  echo 'Status: '.$services[0]->getStatus().PHP_EOL;
  echo 'Service results: '.print_r($services[0]->getServiceResults()).PHP_EOL;
}


