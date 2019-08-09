<?php
namespace Ailixter\Gears;

use Ailixter\Gears\Value;

class FloatValue extends Value
{
    public function __construct(float $value) {
        parent::__construct($value);
    }

    public function __toString(): string
    {
        return (string)$this->getValue();
    }

    public function getValue(): float
    {
        return parent::getValue();
    }

    public function get(): float
    {
        return parent::get();
    }
}

