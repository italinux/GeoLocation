<?php
/**
 * This file is part of the GeoLocation software.
 * (c) 2011 Matteo Montanari <matteo@italinux.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/../lib/Geo/Autoload.php';

setlocale(LC_ALL, 'en_GB');

$classLoader = new Geo\ClassLoader('Geo', __DIR__ . '/../lib');
$classLoader->register();