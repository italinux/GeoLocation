<?php
/**
 * This file is part of the GeoLocation software.
 * (c) 2011 Matteo Montanari <matteo@italinux.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geo\Service\OpenStreetMap;

use Geo\Service;

/**
 * Nominatim service wrap the Nominatim OpenStreetMap Service
 *
 * @package    geoadapter
 * @subpackage service
 * @author     Matteo Montanari <matteo@italinux.com>
 */
class Nominatim extends Service
{
  protected function initLocation($values)
  {
    $location = new \Geo\Location;
    !isset($values['lat'])?:$location->setLatitude($values['lat']);
    !isset($values['lon'])?:$location->setLongitude($values['lon']);
    !isset($values['display_name'])?:$location->setAddress($values['display_name']);

    return $location;
  }
  
  protected function query($q)
  {
    $name = urlencode($q);
    
    $uri = 'http://nominatim.openstreetmap.org/search';
    $parameters = array(
        'format' => 'json',
        'q' => $name,
        'countrycodes' => $this->region,
        'accept-language' => 'it',
        'addressdetails' => 1
    );
    
    $data = file_get_contents($uri.'?'.  \http_build_query($parameters));

    return json_decode($data, true);
  }
}