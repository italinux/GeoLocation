<?php
/**
 * This file is part of the GeoLocation software.
 * (c) 2011 Matteo Montanari <matteo@italinux.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geo;

require_once dirname(__FILE__) . '/../../../lib/Geo/Exception/InvalidService.php';
require_once dirname(__FILE__) . '/../../../lib/Geo/Exception/NoResults.php';
require_once dirname(__FILE__) . '/../../../lib/Geo/Location.php';
require_once dirname(__FILE__) . '/../../../lib/Geo/Service.php';
require_once dirname(__FILE__) . '/../../../lib/Geo/Service/OpenStreetMap/Nominatim.php';
require_once dirname(__FILE__) . '/../../../lib/Geo/Search.php';

class SearchTest extends \PHPUnit_Framework_TestCase
{
  protected $search;

  protected function setUp()
  {
    $this->location = $this->getMock('\Geo\Location', array('getLatitude', 'getLongitude'));
    $this->service = $this->getMock('\Geo\Service\OpenStreetMap\Nominatim', array('search', 'getResults'));
    $this->search = new Search;
  }

  public function testServiceInConstructor()
  {
    $this->service->
           expects($this->once())->
           method('search')->
           with('Milan');

    $this->service->
           expects($this->once())->
           method('getResults')->
           will($this->returnValue(new \ArrayObject(array($this->location))));

    $search = new Search(array($this->service));
    $search->query('Milan');

    $results = $search->getResults();

    $this->assertEquals(1, count($results));
  }

  /**
   * @expectedException \Geo\Exception\InvalidService
   */
  public function testQueryWithoutService()
  {
    $this->search->query('Milan');
  }

  /**
   * @expectedException \Geo\Exception\NoResults
   */
  public function testQueryWithInvalidPlace()
  {
    $this->service->
           expects($this->once())->
           method('search')->
           with('Not found')->
           will($this->throwException(new \Geo\Exception\NoResults));

    $this->search->addService($this->service);
    $this->search->query('Not found');
  }

  public function testQuery()
  {
    $this->service->
           expects($this->once())->
           method('search')->
           with('Milan');

    $this->service->
           expects($this->once())->
           method('getResults')->
           will($this->returnValue(new \ArrayObject(array($this->location))));

    $this->search->addService($this->service);
    $this->search->query('Milan');

    $results = $this->search->getResults();

    $this->assertEquals(1, count($results));
    $this->assertTrue($results[0] === $this->search->getFirst() && $this->search->getFirst() === $this->search->getResult(0));
    $this->assertInternalType('null', $this->search->getResult(1));
  }
}