<?php
/**
 * Setup autoloading for the tests.
 *
 * PHP version 5
 *
 * Copyright 2012 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category   Horde
 * @package    Rdo
 * @subpackage UnitTests
 * @author     Ralf Lang <lang@b1-systems.de>
 * @license    http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */

require_once 'Horde/Test/Autoload.php';

/* Catch strict standards */
error_reporting(E_ALL | E_STRICT);

/** Load Mapper definitions */
require_once dirname(__FILE__) . '/Objects/SomeLazyBaseObjectMapper.php';
require_once dirname(__FILE__) . '/Objects/SomeLazyBaseObject.php';
require_once dirname(__FILE__) . '/Objects/SomeEagerBaseObjectMapper.php';
require_once dirname(__FILE__) . '/Objects/SomeEagerBaseObject.php';
require_once dirname(__FILE__) . '/Objects/RelatedThingMapper.php';
require_once dirname(__FILE__) . '/Objects/RelatedThing.php';