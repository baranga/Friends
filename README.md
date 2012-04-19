# Friends - C++ "friend" for PHP
Friends is a libary emulating the C++
["friend"](http://www.parashift.com/c++-faq-lite/friends.html) language feature
for PHP. This is done with the built-in
[Reflection](http://php.net/manual/en/book.reflection.php) feature of PHP.

## Requirements
* version: 5.3.2+
* compiled with reflection

## Usage

### PHP 5.3
Just inherit from `Friends_Base` or implement same magic hooks in your class.
```php
class MyClass
    extends Friends_Base
{
    // thats all :D
}
```
```php
class MyClass
{
    public function __call($method, $arguments)
    {
        $dispatcher = new Friends_Dispatcher($this);
        return $dispatcher->dispatchCall($this, $method, $arguments);
    }
}
```

### PHP 5.4
As in 5.3 or use the trait `Friends_DispatchingTrait`.
```php
class MyClass
    use Friends_DispatchingTrait
{
    // ...
}
```

## Todo
* replace all SPL exceptions with lib exception
* increase code coverage of unit tests
* implement the trait
