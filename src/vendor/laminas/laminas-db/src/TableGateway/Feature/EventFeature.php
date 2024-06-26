<?php

namespace Laminas\Db\TableGateway\Feature;

use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\Adapter\Driver\StatementInterface;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Update;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\EventsCapableInterface;

use function get_class;

class EventFeature extends AbstractFeature implements
    EventFeatureEventsInterface,
    EventsCapableInterface
{
    /** @var EventManagerInterface */
    protected $eventManager;

    /** @var ?EventFeature\TableGatewayEvent */
    protected $event;

    public function __construct(
        ?EventManagerInterface $eventManager = null,
        ?EventFeature\TableGatewayEvent $tableGatewayEvent = null
    ) {
        $this->eventManager = $eventManager instanceof EventManagerInterface
                            ? $eventManager
                            : new EventManager();

        $this->eventManager->addIdentifiers([
            TableGateway::class,
        ]);

        $this->event = $tableGatewayEvent ?: new EventFeature\TableGatewayEvent();
    }

    /**
     * Retrieve composed event manager instance
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * Retrieve composed event instance
     *
     * @return EventFeature\TableGatewayEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Initialize feature and trigger "preInitialize" event
     *
     * Ensures that the composed TableGateway has identifiers based on the
     * class name, and that the event target is set to the TableGateway
     * instance. It then triggers the "preInitialize" event.
     *
     * @return void
     */
    public function preInitialize()
    {
        if (get_class($this->tableGateway) !== TableGateway::class) {
            $this->eventManager->addIdentifiers([get_class($this->tableGateway)]);
        }

        $this->event->setTarget($this->tableGateway);
        $this->event->setName(static::EVENT_PRE_INITIALIZE);
        $this->eventManager->triggerEvent($this->event);
    }

    /**
     * Trigger the "postInitialize" event
     *
     * @return void
     */
    public function postInitialize()
    {
        $this->event->setName(static::EVENT_POST_INITIALIZE);
        $this->eventManager->triggerEvent($this->event);
    }

    /**
     * Trigger the "preSelect" event
     *
     * Triggers the "preSelect" event mapping the following parameters:
     * - $select as "select"
     *
     * @return void
     */
    public function preSelect(Select $select)
    {
        $this->event->setName(static::EVENT_PRE_SELECT);
        $this->event->setParams(['select' => $select]);
        $this->eventManager->triggerEvent($this->event);
    }

    /**
     * Trigger the "postSelect" event
     *
     * Triggers the "postSelect" event mapping the following parameters:
     * - $statement as "statement"
     * - $result as "result"
     * - $resultSet as "result_set"
     *
     * @return void
     */
    public function postSelect(StatementInterface $statement, ResultInterface $result, ResultSetInterface $resultSet)
    {
        $this->event->setName(static::EVENT_POST_SELECT);
        $this->event->setParams([
            'statement'  => $statement,
            'result'     => $result,
            'result_set' => $resultSet,
        ]);
        $this->eventManager->triggerEvent($this->event);
    }

    /**
     * Trigger the "preInsert" event
     *
     * Triggers the "preInsert" event mapping the following parameters:
     * - $insert as "insert"
     *
     * @return void
     */
    public function preInsert(Insert $insert)
    {
        $this->event->setName(static::EVENT_PRE_INSERT);
        $this->event->setParams(['insert' => $insert]);
        $this->eventManager->triggerEvent($this->event);
    }

    /**
     * Trigger the "postInsert" event
     *
     * Triggers the "postInsert" event mapping the following parameters:
     * - $statement as "statement"
     * - $result as "result"
     *
     * @return void
     */
    public function postInsert(StatementInterface $statement, ResultInterface $result)
    {
        $this->event->setName(static::EVENT_POST_INSERT);
        $this->event->setParams([
            'statement' => $statement,
            'result'    => $result,
        ]);
        $this->eventManager->triggerEvent($this->event);
    }

    /**
     * Trigger the "preUpdate" event
     *
     * Triggers the "preUpdate" event mapping the following parameters:
     * - $update as "update"
     *
     * @return void
     */
    public function preUpdate(Update $update)
    {
        $this->event->setName(static::EVENT_PRE_UPDATE);
        $this->event->setParams(['update' => $update]);
        $this->eventManager->triggerEvent($this->event);
    }

    /**
     * Trigger the "postUpdate" event
     *
     * Triggers the "postUpdate" event mapping the following parameters:
     * - $statement as "statement"
     * - $result as "result"
     *
     * @return void
     */
    public function postUpdate(StatementInterface $statement, ResultInterface $result)
    {
        $this->event->setName(static::EVENT_POST_UPDATE);
        $this->event->setParams([
            'statement' => $statement,
            'result'    => $result,
        ]);
        $this->eventManager->triggerEvent($this->event);
    }

    /**
     * Trigger the "preDelete" event
     *
     * Triggers the "preDelete" event mapping the following parameters:
     * - $delete as "delete"
     *
     * @return void
     */
    public function preDelete(Delete $delete)
    {
        $this->event->setName(static::EVENT_PRE_DELETE);
        $this->event->setParams(['delete' => $delete]);
        $this->eventManager->triggerEvent($this->event);
    }

    /**
     * Trigger the "postDelete" event
     *
     * Triggers the "postDelete" event mapping the following parameters:
     * - $statement as "statement"
     * - $result as "result"
     *
     * @return void
     */
    public function postDelete(StatementInterface $statement, ResultInterface $result)
    {
        $this->event->setName(static::EVENT_POST_DELETE);
        $this->event->setParams([
            'statement' => $statement,
            'result'    => $result,
        ]);
        $this->eventManager->triggerEvent($this->event);
    }
}
