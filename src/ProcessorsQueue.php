<?php
namespace BM\Chain;

/**
 * Processors queue for the chain.
 *
 * @author Bartosz Maciaszek <bartosz@maciaszek.name>
 */
class ProcessorsQueue implements \Countable
{
    /**
     * Processors.
     *
     * @var callable[]
     */
    private $processors = [];

    /**
     * Constructor.
     *
     * @param array ...$processors The processors array.
     */
    public function __construct(...$processors)
    {
        if (1 === count($processors) && is_array($processors[0])) {
            $processors = $processors[0];
        }

        foreach ($processors as $processor) {
            $this->add($processor);
        }
    }

    /**
     * Registers a new processor in the stack.
     *
     * @param callable $processor The processor to register.
     */
    public function add(callable $processor)
    {
        $this->processors[] = $processor;
    }

    /**
     * Returns the processors queue.
     *
     * @return \callable[]
     */
    public function getQueue(): array
    {
        return $this->processors;
    }

    /**
     * Creates and returns a middleware stack. Injects $next to each middleware.
     *
     * @return \SplStack
     */
    public function getStack(): \SplStack
    {
        $stack = new \SplStack();
        $stack[] = function (ChainContextInterface $context) {
            // terminator
        };

        while ($callable = array_pop($this->processors)) {
            $next = $stack->top();
            $stack[] = function (ChainContextInterface $context) use ($callable, $next) {
                return call_user_func($callable, $context, $next);
            };
        }

        return $stack;
    }

    /**
     * Returns the number of processors in the queue.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->processors);
    }
}
