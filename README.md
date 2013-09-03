# match [![Build Status](https://travis-ci.org/zweifisch/php-pattern-matching.png?branch=master)](https://travis-ci.org/zweifisch/php-pattern-matching)

pattern matching for php

install via composer

```sh
composer require 'zweifisch/match:*'
```

destruct value

```php
$array = [1,[2,[3,4]]];
extract(\match\destruct(['a',['b',['c','d']]], $array)) or die("match failed");
echo "$a $b $c $d"; // "1 2 3 4"
```

passing to a function

```php
$input = ['method'=>'foo', 'params'=>['bar']];
$pattern = ['method'=>'func', 'params'=>['arg1']];
$result = \match\let($pattern, $input, function($arg1, $func){
	return "$func $arg1";
});
// "foo bar"
```

destruct multiple values

```php
$input = ['method'=>'foo', 'params'=>['bar']];
$result = \match\let(
	['method'=>'func', 'params'=>['arg1']], $input
	'now', time(),
	function($func, $arg1, $now){
		return "$func $arg1 $now";
	}
);
```

## tests

```sh
composer install --dev
vendor/bin/phpunit -c tests
```
