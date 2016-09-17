<?php
namespace spec\BM\Chain;

use BM\Chain\ProcessorsQueue;
use PhpSpec\ObjectBehavior;

/**
 * @mixin ProcessorsQueue
 */
class ProcessorsQueueSpec extends ObjectBehavior
{
    function it_allows_creating_empty_queue()
    {
        $this->count()->shouldReturn(0);
    }

    function it_constructs_itself_with_single_callable()
    {
        $this->beConstructedWith(function () {});
        $this->count()->shouldReturn(1);
    }

    function it_constructs_itself_with_multiple_callables()
    {
        $this->beConstructedWith(function () {}, function () {}, function () {});
        $this->count()->shouldReturn(3);
    }

    function it_allows_constructing_with_array_of_callables()
    {
        $this->beConstructedWith([function () {}, function () {}, function () {}]);
        $this->count()->shouldReturn(3);
    }

    function it_fails_when_constructed_with_not_a_callable()
    {
        $this->beConstructedWith('test');
        $this->shouldThrow(\TypeError::class)->duringInstantiation();
    }

    function it_allows_adding_processors_runtime()
    {
        $this->add(function () {});
        $this->count()->shouldReturn(1);

        $this->add(function () {});
        $this->count()->shouldReturn(2);

        $this->add(function () {});
        $this->count()->shouldReturn(3);
    }

    function it_returns_a_queue()
    {
        $this->beConstructedWith([function () {}, function () {}, function () {}]);

        $queue = $this->getQueue();
        $queue->shouldHaveCount(3);

        $queue[0]->shouldBeAnInstanceOf(\Closure::class);
        $queue[1]->shouldBeAnInstanceOf(\Closure::class);
        $queue[2]->shouldBeAnInstanceOf(\Closure::class);
    }

    function it_returns_spl_stack()
    {
        $this->beConstructedWith([function () {}, function () {}, function () {}]);

        $stack = $this->getStack();
        $stack->count()->shouldReturn(4); // 3 + terminator
        $stack->offsetGet(0)->shouldBeAnInstanceOf(\Closure::class);
        $stack->offsetGet(1)->shouldBeAnInstanceOf(\Closure::class);
        $stack->offsetGet(2)->shouldBeAnInstanceOf(\Closure::class);
        $stack->offsetGet(3)->shouldBeAnInstanceOf(\Closure::class);
    }
}
