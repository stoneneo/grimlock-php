<?php

namespace Grimlock\Tests\Module\Util;

use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\Util\GrimlockList;
use PHPUnit\Framework\TestCase;

/**
 * Class GrimlockListTest
 * @package Grimlock\Test\Util
 */
class GrimlockListTest extends TestCase
{

    /**
     * @throws GrimlockException
     */
    public function testGetItem()
    {
        $lArray = new GrimlockList();
        $object = "Object";
        $lArray->append($object);

        $this->assertTrue($lArray->getItem(0) != null);
    }

    /**
     * @throws GrimlockException
     */
    public function testGetItemException()
    {
        $lArray = new GrimlockList();
        $this->expectException(GrimlockException::class);
        $lArray->getItem(1);
    }

}