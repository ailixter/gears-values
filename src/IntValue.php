<?php
namespace Ailixter\Gears;

use Ailixter\Gears\Value;

class IntValue extends Value
{
    public function __construct(int $value) {
        parent::__construct($value);
    }

    public function __toString(): string
    {
        return (string)$this->getValue();
    }

    public function getValue(): int
    {
        return parent::getValue();
    }

    public function get(): int
    {
        return parent::get();
    }
}

