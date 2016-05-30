<?php

namespace Studiow\Queue;

use Closure;

class Queue implements QueueInterface
{

    private $tasks = [];
    private $target = [];

    /**
     * Default constructor 
     * 
     * @param array $tasks
     * @param object $target
     */
    public function __construct($tasks = [], $target = null)
    {
        $this->setTarget($target? : $this);
        foreach ($tasks as $task) {
            $this->append($task);
        }
    }

    /**
     * Append a task to the queue
     * 
     * @param callable $task
     * @return \Studiow\Queue\Queue
     */
    public function append(callable $task)
    {
        array_push($this->tasks, $task);
        return $this;
    }

    /**
     * Prepend a task to the queue
     * 
     * @param callable $task
     * @return \Studiow\Queue\Queue
     */
    public function prepend(callable $task)
    {
        array_unshift($this->tasks, $task);
        return $this;
    }

    /**
     * Set the target. The target is what $this will resolve to inside a callback 
     * @param object $target
     * @return \Studiow\Queue\Queue
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * Get the target
     * @return object
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Execute the next task in the queue
     * 
     * @param mixed $input
     * @return mixed
     */
    public function __invoke($input)
    {
        $task = array_shift($this->tasks)? : function($input) {
            return $input;
        };
        return call_user_func_array($this->resolve($task), [$input, $this]);
    }

    /**
     * Execute all tasks in the queue
     * @param mixed $input
     * @param object|null $target
     * @return mixed
     */
    public function execute($input, $target = null)
    {
        $clone = clone $this;
        if ($target) {
            $clone->setTarget($target);
        }
        return $clone($input);
    }

    /**
     * 
     * @param callable $task
     * @return callable
     */
    private function resolve(callable $task)
    {
        if ($task instanceof Closure) {
            return Closure::bind($task, $this->target);
        }
        return $task;
    }

}
