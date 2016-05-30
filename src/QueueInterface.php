<?php

namespace Studiow\Queue;

interface QueueInterface
{

    /**
     * Append a task to the queue
     * 
     * @param callable $task
     * @return self
     */
    public function append(callable $task);

    /**
     * Prepend a task to the queue
     * 
     * @param callable $task
     * @return self
     */
    public function prepend(callable $task);

    /**
     * Set the target. The target is what $this will resolve to inside a callback
     * 
     * @param object $target
     * @return self
     */
    public function setTarget($target);

    /**
     * Get the target for the queue
     * 
     * @return object
     */
    public function getTarget();

    /**
     * Execute all tasks in the queue
     * 
     * @param mixed $input
     * @param object|null $target
     * @return mixed
     */
    public function execute($input, $target = null);
}
