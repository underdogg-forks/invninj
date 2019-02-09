<?php

namespace Modules\Notes\Tests;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nwidart\Modules\Facades\Module;
use Tests\TestCase;

class CheckMenuModulesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testModulesAreDetected()
    {
    	$this->assertGreaterThan(0, Module::count());
    }

    public function testNotesModuleExists()
    {
        $module = Module::find('Notes');
        $this->assertNotNull($module);
        
    }

    public function testNoSideBarVariableExists()
    {
        $module = Module::find('Notes');
        $this->assertNotNull($module->get('sidebar'));
    }

    public function testViewsVariableExistsAndIsArray()
    {
        $module = Module::find('Notes');
        $this->assertTrue(is_array($module->get('views')));
    }

    public function testViewsVariableExistsAndContainsCustomers()
    {
        $module = Module::find('Notes');
        $array = $module->get('views');
        $this->assertTrue(in_array('customer', $array)); 
    }

    public function testViewsVariableExistsAndDoesNotContainRandomObject()
    {
        $module = Module::find('Notes');
        $array = $module->get('views');
        $this->assertFalse(in_array('foo', $array)); 
    }

    public function testResolvingTabMenuCorrectly()
    {
        $entity = Customer::class;
        $tabs = [];

    	foreach (Module::getCached() as $module)
		{
			if(!$module['sidebar']
                && $module['active'] == 1
                && in_array( strtolower( class_basename($entity) ), $module['views']))
			{
                $tabs[] = $module;
			}
		}
        $this->assertFalse($module['sidebar']);
        $this->assertEquals(1,$module['active']);
        $this->assertEquals('customer', strtolower(class_basename(Customer::class)));
        $this->assertTrue( in_array(strtolower(class_basename(Customer::class)), $module['views']) );
        $this->assertEquals(1, count($tabs));
    }
  
}
