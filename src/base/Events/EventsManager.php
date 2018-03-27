<?php


namespace Neyronius\Base\Events;


class EventsManager
{

    protected $eventStore = [];

    /**
     * Subscribe on event
     *
     * @param string $eventClass
     * @param callable $callback
     */
    public function subscribe(string $eventClass, callable $callback)
    {
        if (!isset($this->eventStore[$eventClass])) {
            $this->eventStore[$eventClass] = [];
        }

        $this->eventStore[$eventClass][] = $callback;
    }

    /**
     * Unsubscribe from event
     *
     * @param string $eventClass
     * @param callable|null $callback
     */
    public function unsubscribe(string $eventClass, callable $callback = null)
    {
        if (!$this->eventStore[$eventClass]) {
            throw new \InvalidArgumentException("There is no callbacks for the event " . $eventClass);
        }

        if ($callback === null) {
            $this->eventStore[$eventClass] = [];
        } else {
            foreach ($this->eventStore[$eventClass] as $k => $cb) {
                if ($cb === $callback) {
                    unset($this->eventStore[$eventClass][$k]);
                }
            }
        }
    }

    /**
     * Emit an event
     *
     * @param Event $event
     */
    public function publish(Event $event)
    {
        $eventClass = get_class($event);

        if (isset($this->eventStore[$eventClass])) {
            foreach ($this->eventStore[$eventClass] as $cb) {
                DI()->call($cb, ['event' => $event]);
            }
        }
    }

}