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
abstract class AbstractCache
{

    /**
     * @var
     */
    protected $ttl;

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function __construct($ttl) 
    {

        $this->ttl = $ttl;
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    private function generateKeyString(array $params) 
    {

        $string = '';

        foreach ($params as $value) {

            if (is_scalar($value)) {

                $string .= $value;
                
            } else {

                $string .= serialize($value);
            }
        }

        return $string;
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function generateCacheKey(array $params) 
    {

        $string = $this->generateKeyString($params);

        return md5($string);
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    abstract public function set($key, $value);

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    abstract public function get($key);

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    abstract public function clear();
}

?>
