# match

pattern matching for php

destruct value
```php
$matched = \match\destruct(['a',['b',['c','d']]], [1,[2,[3,4]]]);
if ($matched) {
	extract($matched);
	echo "$a $b $c $d"; // "1 2 3 4"
}
```

bind to a closure
```php
$input = ['method'=>'foo', 'params'=>['bar']];
$result = \match\let(['method'=>'func', 'params'=>['arg1']], $input, function(){
	return "$this->func $this->arg1";
});
// "foo bar"
```

destruct and bind multiple values
```php
$input = ['method'=>'foo', 'params'=>['bar']];
$result = \match\let(
	['method'=>'func', 'params'=>['arg1']], $input
	'now', time(),
	function(){
		return "$this->func $this->arg1 $this->now";
	}
);
```

## tests

```sh
composer install --dev
vendor/bin/phpunit -c tests
```
