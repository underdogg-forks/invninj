<?php

namespace Tests\Unit;

use App\DataMapper\DefaultSettings;
use App\Models\Customer;
use Tests\TestCase;

class EvaluateStringTest extends TestCase
{

	public function testClassNameResolution()
	{
		$this->assertEquals(class_basename(Customer::class), 'Customer');
	}

}