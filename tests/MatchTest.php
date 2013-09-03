<?php

class MatchTest extends PHPUnit_Framework_TestCase
{

	public function testDestruct()
	{
		extract(\match\destruct(['a','b','c'], [1,2,3,4]));
		$this->assertEquals($a,1);
		$this->assertEquals($b,2);
		$this->assertEquals($c,3);

		extract(\match\destruct(['a',['b'=>'c']], [2,['a'=>'b', 'b'=>'d']]));
		$this->assertEquals($a,2);
		$this->assertEquals($c,'d');
	}

	public function testDestructFail()
	{
		$this->assertSame([], \match\destruct(['a','b','c'], [1,2]));
		$this->assertSame([], \match\destruct(['a','b','c'], null));
		$this->assertSame([], \match\destruct(['a','a'=>['c']], [1,'a'=>2,'b'=>3]));
		$this->assertSame(0, extract(\match\destruct(['a'], 1)));
	}

	public function testLet()
	{
		$result = \match\let(['a'], [1], 'b', 2, function($a, $b){
			return $a + $b;
		});
		$this->assertEquals(3, $result);
	}

	public function testLetFail()
	{
		$result = \match\let(['a','c'], [1], function($a, $b){
			return $a + $b;
		});
		$this->assertFalse($result);
	}
}
