<?php

class $module$ControllerTest extends \EasyFrame\Test\PhpUnit\EasyFrameTestCase{

    protected $controller;

    public function setup(){
        $this->controller = \$module$\Controllers\$module$Controller::create();
    }

    /**
     * Tests that the controller exists and can be instantiated
     */
    public function test_basicImplementationTest(){
        $this->assertInstanceOf('\$module$\Controllers\$module$Controller', $this->controller);
    }
}