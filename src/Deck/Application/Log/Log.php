<?php

namespace Deck\Application\Log;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Deck\Messaging\DatabaseLogHandler;

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
class Log
{

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function __construct() 
    {

        $logger = new Logger('my_logger');

        $logger->pushHandler(new StreamHandler(__DIR__ . '/my_app.log', Logger::DEBUG));
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function addMessage(Message $message) 
    {

        $logger->addInfo($info, $data);
    }

}

?>
