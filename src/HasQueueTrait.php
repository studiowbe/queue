<?php

namespace Studiow\Queue;

trait HasQueueTrait
{

    /**
     * @var \Studiow\Queue\QueueInterface 
     */
    private $queue;

    /**
     * Set or replace the current queue
     * 
     * @param \Studiow\Queue\QueueInterface $queue
     * @return this
     */
    public function setQueue(QueueInterface $queue)
    {
        $this->queue = $queue;
        $this->queue->setTarget($this);
        return $this;
    }

    /**
     * Get the current queue, if any
     * 
     * @return \Studiow\Queue\QueueInterface|null
     */
    public function getQueue()
    {
        return $this->queue;
    }

}
