<?php

namespace Tests\Feature;

use Tests\TestCase;

class LowercaseTest extends TestCase
{
	/**
	 * A basic feature test example.
	 *
	 * @return void
	 */
	public function test_if_custom_lowercase_rule_passes()
	{
		$rule = new \App\Rules\Lowercase();
		if ($rule->passes('nikoloz', 'nikoloz'))
		{
			$this->assertTrue(true);
			$this->assertEquals('nikoloz', 'nikoloz');
			$this->getJson($rule->message());
		}
		else
		{
			$this->assertFalse(true);
		}
	}
}
