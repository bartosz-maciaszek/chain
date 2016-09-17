<?php

use BM\Chain\Chain;
use BM\Chain\ChainContextInterface;
use BM\Chain\ProcessorsQueue;

require '../vendor/autoload.php';

class Context implements ChainContextInterface
{
    /**
     * @var string
     */
    private $string = '';

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * @param string $string
     */
    public function setString(string $string)
    {
        $this->string = $string;
    }
}

class Appender
{
    /**
     * @var string
     */
    private $fragment;

    /**
     * Appender constructor.
     * @param string $fragment
     */
    public function __construct(string $fragment)
    {
        $this->fragment = $fragment;
    }

    /**
     * @param Context $context
     * @param callable $next
     */
    public function __invoke(Context $context, callable $next)
    {
        $context->setString($context->getString() . $this->fragment);
        $next($context);
    }
}

$rot13 = function (Context $context, callable $next) {
    $context->setString(str_rot13($context->getString()));
    $next($context);
};

$exclamation = function (Context $context, callable $next) {
    $context->setString($context->getString() . '!');
    $next($context);
};

$queue = new ProcessorsQueue(
    new Appender(', beautiful'),
    new Appender(' world'),
    $exclamation,
    $exclamation,
    $exclamation,
    $rot13
);

$context = new Context();
$context->setString('Hello');

$chain = new Chain($queue);
$chain->execute($context);

var_dump($context->getString()); // Uryyb, ornhgvshy jbeyq!!!"
