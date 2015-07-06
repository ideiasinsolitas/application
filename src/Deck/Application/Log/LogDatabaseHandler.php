
<?php

namespace Deck\Application\Log;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Deck\MVC\Repository\RepositoryInterface;
use Deck\Package\System\Notification;

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
class LogDatabaseHandler extends AbstractProcessingHandler
{

    /**
     * @var
     */
    private $repository;

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    public function __construct(RepositoryInterface $repository, $level = Logger::DEBUG, $bubble = true) 
    {
        
        $this->repository = $repository;
        parent::__construct($level, $bubble);
    }

    /**
     * The short description
     *
     * @access public
     * @param  type [ $varname] description
     * @return type description
     */
    protected function write(array $record) 
    {

        $action = new Action();
        $action->setUserId($record['user_id']);
        $action->setName($record['name']);
        $action->setMessage($record['message']);

        $actionId = $this->repository->create($action);

        $name = $action->getName();

    }

}

?>
