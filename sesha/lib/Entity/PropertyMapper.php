<?php
/**
 * The Sesha_Entity_PropertyMapper class contains all functions related to handling
 * property mapping in Sesha.
 *
 * Copyright 2012-2012 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.horde.org/licenses/gpl.
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category Horde
 * @package  Sesha
 * @license  http://www.horde.org/licenses/gpl GPL
 */


/**
 * The Sesha_Entity_PropertyMapper class contains all functions related to handling
 * property mapping in Sesha.
 *
 * Copyright 2012-2012 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.horde.org/licenses/gpl.
 *
 * @author   Ralf Lang <lang@b1-systems.de>
 * @category Horde
 * @package  Sesha
 * @license  http://www.horde.org/licenses/gpl GPL
 */
class Sesha_Entity_PropertyMapper extends Horde_Rdo_Mapper
{
    /**
     * Inflector doesn't support Horde-style tables yet
     * @var string
     * @access protected
     */
    protected $_table = 'sesha_properties';

    /**
     * Relationships loaded on-demand
     * @var array
     * @access protected
     */
    protected $_lazyRelationships = array();

}
