<?php
/**
 * This class provides cache storage in PHP memory.
 * It persists only during a script run and ignores the object lifetime
 * because of that.
 *
 * Copyright 2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @category Horde
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Cache
 * @package  Cache
 */
class Horde_Cache_Storage_Mock extends Horde_Cache_Storage
{
    /**
     * The storage location for this cache.
     *
     * @var array
     */
    private $_cache = array();

    /**
     */
    public function get($key, $lifetime)
    {
        return isset($this->_cache[$key])
            ? $this->_cache[$key]
            : false;
    }

    /**
     */
    public function set($key, $data, $lifetime)
    {
        $this->_cache[$key] = $data;
    }

    /**
     */
    public function exists($key, $lifetime = 1)
    {
        return isset($this->_cache[$key]);
    }

    /**
     */
    public function expire($key)
    {
        unset($this->_cache[$key]);
    }

}
