<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use App\Lib\DataObject;

class DataObjectTest extends TestCase
{
    public function testGetData()
    {
        $rO = new DataObject();
        $data = $rO->getData();
        $this->assertEquals(2, count($data));
    }

    public function testDataIsArray()
    {
        $rO = new DataObject();
        $data = $rO->getData();
        $this->assertTrue(is_array($data));
    }

    /**
     * @covers DataObject
     */
    public function testSerializeData()
    {
        $rO = new DataObject();
        $serializedData = $rO->serializeData();
    }
}