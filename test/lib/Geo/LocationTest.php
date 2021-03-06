<?php
/**
 * This file is part of the GeoLocation software.
 * (c) 2011 Matteo Montanari <matteo@italinux.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geo;

require_once dirname(__FILE__) . '/../../../lib/Geo/Location.php';

class LocationTest extends \PHPUnit_Framework_TestCase
{

  protected $object;

  protected function setUp()
  {
    $this->object = new Location;
    $this->object->setLatitude('1.1234');
    $this->object->setLongitude('2.4321');
    $this->object->setAddress('12, Spencer road, Greenland');
  }

  public function testGetLatitude()
  {
    $this->assertEquals('1.1234', $this->object->getLatitude());
  }

  public function testGetLongitude()
  {
    $this->assertEquals('2.4321', $this->object->getLongitude());
  }

  public function testGetAddress()
  {
    $this->assertEquals('12, Spencer road, Greenland', $this->object->getAddress());
  }
  
  public function testDistance()
  {
    $this->object->setLatitude('37.5024825');
    $this->object->setLongitude('15.0878345');

    $location = $this->getMock('Geo\Location', array('getLatitude', 'getLongitude'));
    $location->expects($this->once())
             ->method('getLatitude')
             ->will($this->returnValue('37.502482500000'));

    $location->expects($this->once())
             ->method('getLongitude')
             ->will($this->returnValue('15.087834500000'));
    
    $this->assertEquals(0.00, $this->object->distance($location));
  }
}
