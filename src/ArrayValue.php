<?php
namespace Ailixter\Gears;

use Ailixter\Gears\Value;

class ArrayValue extends Value
{
    public function __construct(array $value) {
        parent::__construct($value);
    }

    public function __toString(): string
    {
        return \json_encode($this->getValue());
    }

    public function getValue(): array
    {
        return parent::getValue();
    }

    public function get(): array
    {
        return parent::get();
    }
}

