<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 02.01.2018
 * Time: 15:02
 */

use PHPUnit\Framework\TestCase;
use BracketsParser\BracketsParser;

class FirstTest extends TestCase
{
    public function testTrue()
    {
        $this->assertTrue(BracketsParser::run('()'));
    }
    public function testFalse()
    {
        $this->assertFalse(BracketsParser::run('())'));
    }
}