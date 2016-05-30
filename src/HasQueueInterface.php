<?php

namespace Studiow\Queue;

interface HasQueueInterface
{

    /**
     * Set or replace the current queue
     * 
     * @param \Studiow\Queue\QueueInterface $queue
     * @return this
     */
    public function setQueue(QueueInterface $queue);

    /**
     * Get the current queue, if any
     * 
     * @return \Studiow\Queue\QueueInterface|null $queue 
     */
    public function getQueue();
}
