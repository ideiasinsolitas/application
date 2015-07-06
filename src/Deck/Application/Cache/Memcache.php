<?php

namespace Deck\Application\Cache;

/**
 * The short description
 *
 * As many lines of extendend description as you want {@link element}
 * links to an element
 * {@link http://www.example.com Example hyperlink inline link} links to
 * a website. The inline
 *
 * @package package name
 * @author  Pedro Koblitz
 */
class Memcache extends AbstractCache
{
    /**
     * @var
     */
    protected $connection;

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function __construct($ttl)
    {
        $memcache = new \Memcache();
        $this->connection = $memcache->connect('localhost', 11211);
        parent::__construct($ttl);
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function set($key, $value)
    {
        $this->connection->set($key, $value);
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function get($key)
    {
        return $this->connection->get($key);
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function clear()
    {
        $this->connection->flush();
    }
}
