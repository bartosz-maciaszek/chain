<?php
namespace BM\Chain;

/**
 * The chain aggregates processors and initializes the process of their execution.
 *
 * @author Bartosz Maciaszek <bartosz@maciaszek.name>
 */
class Chain
{
    /**
     * Processors queue.
     *
     * @var ProcessorsQueue
     */
    private $queue;

    /**
     * Constructor.
     *
     * @param ProcessorsQueue $queue The processors queue.
     */
    public function __construct(ProcessorsQueue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Initialized the execution of the processors stack.
     *
     * @param ChainContextInterface $context The chain context.
     *
     * @return mixed
     */
    public function execute(ChainContextInterface $context)
    {
        $start = $this->queue->getStack()->top();

        $result = $start($context);

        return $result;
    }
}
