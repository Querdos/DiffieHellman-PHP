<?php
use PHPUnit\Framework\TestCase;

/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 4/15/17
 * Time: 4:22 PM
 */
class DiffieHellmanTest extends TestCase
{
    public function testInitialization()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));
    }
}
