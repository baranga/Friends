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

### PHP 5.4
As in 5.3 or use the trait `Friends_DispatchingTrait`;
