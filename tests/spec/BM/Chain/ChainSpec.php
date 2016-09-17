<?php
namespace spec\BM\Chain;

use BM\Chain\Chain;
use BM\Chain\ChainContextInterface;
use BM\Chain\ProcessorsQueue;
use PhpSpec\ObjectBehavior;

interface TestContext extends ChainContextInterface
{
    public function ping();
}

/**
 * @mixin Chain
 */
class ChainSpec extends ObjectBehavior
{
    function let(ProcessorsQueue $queue)
    {
        $this->beConstructedWith($queue);
    }

    function it_executes_the_chain(ProcessorsQueue $queue, TestContext $context)
    {
        $stack = new \SplStack();
        $stack[] = function (TestContext $context) {
            $context->ping();
        };

        $context->ping()->shouldBeCalled();

        $queue->getStack()->willReturn($stack);

        $this->execute($context);
    }
}