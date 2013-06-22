<?php

namespace match;

function destruct($pattern, $value, &$ret=[])
{
	if(is_string($pattern))
	{
		$ret[$pattern] = $value;
	}
	elseif(is_array($pattern))
	{
		if(!is_array($value)) return false;
		foreach($pattern as $key=>$val)
		{
			if(!array_key_exists($key,$value)) return false;
			if(is_array($val))
			{
				if(!destruct($val, $value[$key], $ret)) return false;
			}
			else
			{
				$ret[$val] = $value[$key];
			}
		}
	}
	else
	{
		return false;
	}
	return $ret;
}

function let()
{
	$args = func_get_args();
	$block = array_pop($args);
	$len = count($args);
	$matched = [];
	for($i=0;$i<$len;$i+=2)
	{
		if(!destruct($args[$i], $args[$i+1], $matched)) return false;
	}
	$block = $block->bindTo((object)$matched);
	return $block();
}
