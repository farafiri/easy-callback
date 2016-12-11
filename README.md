easy-callback
=======================


Library for providing short and easy way for creating callback.

Functional programing is very powerful concept and I like to use this paradigm in my work.
However current php closure syntax is quite verbose. Check following example:

```php
/** filter books written by $author */
$books = array_filter($allBooks, function($book) use ($author) {
    return $book->getAuthor() === $author;
});
```

vs:

```php
use EasyCallback\f;

/** filter books written by $author */
$books = array_filter($allBooks, f()->getAuthor()->ecEq($author));
```


Doc / Examples
========

Library always works on instances of EasyCallback\Wrapper class
(all functions in this library returns instance of EasyCallback\Wrapper).

```php
use EasyCallback\f;

f(); //Callable returning first parameter. Equivalent to:
function ($p1) {return $p1;};
f(2); //Callable returning 2-nd parameter. Equivalent to:
function ($p1, $p2) {return $p2;};
f($value, true); //Callable returning $value. Equivalent to
function () use ($value) {return $value;};

//EasyCallback\Wrapper support array syntax:
$f['a']; // Equivalent to:
function(...$params) use ($f) {return $f(...$params)['a'];}

f()['a']; //Equivalent to:
function($p1) {return $p1['a'];};
f(2)['a']; //Equivalent to:
function($p1, $p2) {return $p2['a'];};
f()['a']['b']; //Equivalent to:
function($p1) {return $p1['a']['b'];};
f($value, true)['a']; //Equivalent to:
function() use ($value) {return $value['a'];};
f($value, true)[f()]; //Equivalent to:
function($p1) use ($value) {return $value[$p1];};

//Similarly get property syntax and method call syntax is supported:
f()->exampleProperty; //Equivalent to:
function($p1) {return $p1->exampleProperty;};
f()->exampleMethod(1); //Equivalent to:
function($p1) {return $p1->exampleMethod(1);};
f()->exampleMethod1()->exampleMethod2(); //Equivalent to:
function($p1) {return $p1->exampleMethod1()->exampleMethod2();};
```

