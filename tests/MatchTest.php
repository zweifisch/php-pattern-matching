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
		$this->assertSame(false, \match\destruct(['a','b','c'], [1,2]));
		$this->assertSame(false, \match\destruct(['a','b','c'], null));
		$this->assertSame(false, \match\destruct(['a','a'=>['c']], [1,'a'=>2,'b'=>3]));
	}

	public function testLet()
	{
		$result = \match\let(['a'], [1], 'b', 2, function(){
			return $this->a + $this->b;
		});
		$this->assertEquals(3, $result);
	}

	public function testLetFail()
	{
		$result = \match\let(['a','c'], [1], function(){
			return $this->a + $this->b;
		});
		$this->assertFalse($result);
	}
}
