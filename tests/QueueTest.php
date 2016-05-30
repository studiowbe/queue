<?php

namespace Studiow\Queue\Test;

use PHPUnit_Framework_TestCase;
use Studiow\Queue\Queue;
use Studiow\Queue\Test\HasQueueClass;

class QueueTest extends PHPUnit_Framework_TestCase
{

    public function testSimpleQueue()
    {
        $queue = new Queue([
            function($input, $next) {
                $value = $input + 3;
                return $next($value);
            },
            function($input, $next) {
                $value = $input / 2;
                return $next($value);
            },
        ]);
        $this->assertEquals(2, $queue->execute(1));
    }

    public function testQueueRepeatable()
    {
        $queue = new Queue([
            function($input, $next) {
                $value = $input + 3;
                return $next($value);
            },
            function($input, $next) {
                $value = $input / 2;
                return $next($value);
            },
        ]);
        $this->assertEquals(2, $queue->execute(1));
        $this->assertEquals(3, $queue->execute(3));
    }

    public function testAppendToQueue()
    {
        $queue = new Queue();

        $queue->append(function($input, $next) {
            $value = $input + 3;
            return $next($value);
        });

        $queue->append(function($input, $next) {
            $value = $input / 2;
            return $next($value);
        });

        $this->assertEquals(2, $queue->execute(1));
    }

    public function testprependToQueue()
    {
        $queue = new Queue();

        $queue->prepend(function($input, $next) {
            $value = $input + 3;
            return $next($value);
        });

        $queue->prepend(function($input, $next) {
            $value = $input / 2;
            return $next($value);
        });

        $this->assertEquals(3.5, $queue->execute(1));
    }

    public function testInvokableTask()
    {
        $queue = new Queue();

        $queue->append(new InvokableClass(2));
        $this->assertEquals(2, $queue->execute(1));
    }

    public function testHasQueue()
    {
        $doubler = new HasQueueClass(2);

        $doubler->setQueue(new Queue([
            function($input, $next) {
                $value = $this->multiply($input);
                return $next($value);
            }
        ]));


        $this->assertEquals(2, $doubler->getQueue()->execute(1));
    }

    public function testExecuteTarget()
    {

        $queue = new Queue([
            function($input, $next) {
                $value = $this->multiply($input);
                return $next($value);
            }
        ]);
        $doubler = new HasQueueClass(2);
        $this->assertEquals(2, $queue->execute(1, $doubler));

        $tripler = new HasQueueClass(3);
        $this->assertEquals(3, $queue->execute(1, $tripler));
    }

}
