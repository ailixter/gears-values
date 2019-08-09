<?php

use PHPUnit\Framework\TestCase;
use Ailixter\Gears\ArrayValue;

class ArrayTest extends TestCase
{
    /**
     * @dataProvider provideValues
     */
    public function testValueGet(ArrayValue $test, $expected)
    {
        $this->assertSame($expected, $test->getValue());
    }

    public function provideValues()
    {
        return [
            [new ArrayValue([]), []],
            [new ArrayValue([1]), [1]],
        ];
    }

    /**
     * @dataProvider provideErrors
     */
    public function testValueError(ArrayValue $test, $expected)
    {
        if ($expected) {
            $this->assertArraySubset($expected, $test->getErrors());
        } else {
            $this->assertEmpty($test->getErrors());
        }
    }

    public function provideErrors()
    {
        return [
           [(new ArrayValue([])), null],
           [(new ArrayValue([]))->addError('a', 'b'), ['a' => 'b']],
           [(new ArrayValue([]))->addError('a', 'b')->addError('c', 'd'), ['a' => 'b', 'c' => 'd']],
        ];
    }

}