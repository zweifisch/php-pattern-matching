<?php

namespace match;

use ReflectionFunction;

function destruct($pattern, $value, &$ret=[])
{
	if(is_string($pattern))
	{
		$ret[$pattern] = $value;
	}
	elseif(is_array($pattern))
	{
		if(!is_array($value)) return [];
		foreach($pattern as $key=>$val)
		{
			if(!array_key_exists($key,$value)) return [];
			if(is_array($val))
			{
				if(!destruct($val, $value[$key], $ret)) return [];
			}
			else
			{
				$ret[$val] = $value[$key];
			}
		}
	}
	else
	{
		return [];
	}
	return $ret;
}

function let()
{
	$args = func_get_args();
	$block = array_pop($args);
	$len = count($args);
	$matched = [];
	for($i=0; $i<$len; $i+=2)
	{
		if(!destruct($args[$i], $args[$i+1], $matched)) return false;
	}
	if(is_null($params = getKeywordArgs($block, $matched)))
	{
		return false;
	}
	return call_user_func_array($block, $params);
}

function getKeywordArgs($closure, $args)
{
	$reflection = new ReflectionFunction($closure);
	$ret= [];
	foreach($reflection->getParameters() as $param)
	{
		if(isset($args[$param->name]))
		{
			$ret[] = $args[$param->name];
		}
		else
		{
			if($param->isOptional())
			{
				$ret[] = $param->getDefaultValue();
			}
			else
			{
				return null;
			}
		}
	}
	return $ret;
}
