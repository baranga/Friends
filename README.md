# Friends - C++ "friend" for PHP
Friends is a libary emulating the C++
["friend"](http://www.parashift.com/c++-faq-lite/friends.html) language feature
for PHP. This is done with the built-in
[Reflection](http://php.net/manual/en/book.reflection.php) feature of PHP.

[![Build Status](https://secure.travis-ci.org/baranga/Friends.png)](http://travis-ci.org/baranga/Friends)


## Requirements
* version: >= 5.2
* for auto dispatching >= 5.3.2
* compiled with reflection

## Usage

### PHP 5.2
Implement magic hooks with access controll and dispatch magic.

```php
<?php

class MyClass
{
    public function __call($method, $arguments)
    {
        $trace = new Friends_Backtrace();
        $caller = $trace[2];
        $controller = new Friends_AccessController($this);
        $controller->assertCallIsAllowed($method, $caller);
        return call_user_func_array(
            array($this, $method),
            $arguments
        );
    }
}
```

### PHP 5.3 (>= 5.3.2)
As in 5.2 or just inherit from `Friends_Base` or implement same magic hooks in
your class.

```php
<?php

class MyClass
    extends Friends_Base
{
    // thats all :D
}
```

```php
<?php

class MyClass
{
    public function __call($method, $arguments)
    {
        $controller = new Friends_AccessController($this);
        $dispatcher = new Friends_Dispatcher($controller);
        return $dispatcher->dispatchCall($this, $method, $arguments);
    }
}
```

### PHP 5.4
As in 5.3 or use the trait `Friends_DispatchingTrait`.

```php
<?php

class MyClass
    use Friends_DispatchingTrait
{
    // ...
}
```

## Todo
* ~~replace all SPL exceptions with lib exception~~
* improve exceptions (messages, common interface)
* ~~increase code coverage of unit tests~~
* implement the trait
* add some examples
