<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * @test
 * @covers  App\Utils\NumberHelper
 */
class NestedCollectionTest extends TestCase
{

    public function setUp()
    {
    
	    parent::setUp();

	    $this->map = (object)[
	        'customer' => (object)[
	        	'datatable' => (object)[
	        		'per_page' => 20,
	        		'column_visibility' => (object)[
	        			'__checkbox' => true,
	        			'name' => true,
	        			'contact' => true,
	        			'email' => true,
	        			'customer_created_at' => true,
	        			'last_login' => true,
	        			'balance' => true,
	        			'__component:customer-actions' => true,
	        		]
	        	]
	        ]
	    ];

    }


    public function testPerPageAttribute()
    {
		$this->assertEquals($this->map->customer->datatable->per_page, 20);
    }

    public function testNameAttributeVisibility()
    {
    	$this->assertEquals($this->map->customer->datatable->column_visibility->name, true);
    }

    public function testStringAsEntityProperty()
    {
    	$entity = 'customer';

    	$this->assertEquals($this->map->{$entity}->datatable->column_visibility->name, true);
    }


}