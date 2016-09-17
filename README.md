[![Build Status](https://travis-ci.org/bartosz-maciaszek/chain.svg?branch=master)](https://travis-ci.org/bartosz-maciaszek/chain)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg)](https://php.net/)
[![Dependency Status](https://www.versioneye.com/user/projects/57dd386c037c2000458f6b5a/badge.svg?style=flat)](https://www.versioneye.com/user/projects/57dd386c037c2000458f6b5a)

# About

This is a simple library that makes it easier to chain
actions/processors. Useful for any kind of data processing with reusable
pieces of code in a specific order.

The library is inspired with Chain of Responsibility design pattern and
middleware-like approach where one middleware executes its logic and,
conditionally, runs next middleware.

## How do I install it?

    composer require bartosz-maciaszek/chain

## How do I use it?

In three simple steps:

1. Create a context class that implements `BM\Chain\ChainContextInterface`.
2. Create an instance of `BM\Chain\ProcessorsQueue` and register processor with it.
3. Execute the chain by invoking `execute()` method and passing the context object.

## What is the context class?

This is a class that stores some information and is being passed to each
of the registered processor. Context can contain some initial input data
of any type. Processors are meant to use that data during execution.
Obviously, they can always store anything in the context. You're in
charge here.

## What are the processors?

Processors are `callable`'s that contain some logic to be executed. They
can be closures or classes implementing `__invoke` method. The
processors always take two arguments: context and next processor in the
queue. They are responsible for execution of next one, otherwise the
chain breaks.

## What is the processor queue?

Processor queue is an object that aggregates processors in the given
order. It exposes methods that allow managing processors.
 
## What is the Chain?

Chain is a class that is responsible for execution of the processor
queue and passing the context object to them.

## Any examples?

Have a look [here](examples).
