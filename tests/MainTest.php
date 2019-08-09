<?php

use PHPUnit\Framework\TestCase;
use Ailixter\Gears\Value;
use Ailixter\Gears\Exceptions\ValueException;
use Ailixter\Gears\ValueInterface;

class MainTest extends TestCase
{
    /**
     * @dataProvider provideValues
     */
    public function testValueGet(ValueInterface $test, $expected)
    {
        $this->assertSame($expected, $test->get());
    }

    public function provideValues()
    {
        return [
            [new Value(1), 1],
            [new Value(false), false],
            [new Value([]), []],
            [new Value([1]), [1]],
        ];
    }

    /** @dataProvider provideTypes */
    public function testToStringBasic($value, $expected)
    {
        $this->assertEquals($expected, (string) new Value($value));
    }


    public function provideTypes()
    {
        return [
            [null, ''],
            [123, '123'],
            [1.23, '1.23'],
            ['abc', 'abc'],
            [[], '[array]'],
            [(object) [], '[stdClass]'],
            [function () { }, '[Closure]'],
            [new Value(0), '[Ailixter\Gears\Value]'],
            [STDERR, '[resource]'],
            [[$this, 'provideTypes'], '[callable]']
        ];
    }
    public function testInvalid()
    {
        $this->expectException(UnexpectedValueException::class);
        new class (0) extends Value
        {
            protected function validate()
            {
                $this->getValue() or $this->addError('invalid', (string)$this);
            }
        };
    }

    public function testInvalid2()
    {
        try {
            new class ([]) extends Value
            {
                protected function validate()
                {
                    $this->getValue() or $this->addError('invalid', (string)$this);
                }
            };
        } catch (ValueException $e) {
            $value = $e->getValue();
            $this->assertEquals((string)$value, $value->getErrors()['invalid']);
            $this->assertContains((string)$value, $e->getMessage());
            $this->assertContains('construct', $e->getMessage());
        }
    }

    /**
     * @dataProvider provideReturn
     */
    public function testReturn(callable $func, $hasErrors)
    {
        if ($hasErrors) {
            $this->expectException(UnexpectedValueException::class);
        }
        $test = (object)[];
        $this->assertEquals($test, $this->returnTest($func($test)->get()));
    }

    private function returnTest($value)
    {
        return $value;
    }

    public function provideReturn()
    {
        $result = [];
        foreach ($this->provideTypes() as [$v]) {
            $result[] = [function ($v) { return (new Value($v)); }, false];
            $result[] = [function ($v) { return (new Value($v))->addError('just', 'error'); }, true];
            $result[] = [function ($v) { return (new Value($v))->addError('just', 'error')->resetErrors(); }, false];
        }
        return $result;
    }
}
