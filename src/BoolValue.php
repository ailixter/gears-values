<?php
namespace Ailixter\Gears;

use Ailixter\Gears\Value;

class BoolValue extends Value
{
    const TRUE_STRING  = '1';
    const FALSE_STRING = '';

    public function __construct(bool $value) {
        parent::__construct($value);
    }

    public function __toString(): string
    {
        return $this->getValue() ? static::TRUE_STRING : static::FALSE_STRING;
    }

    public function getValue(): bool
    {
        return parent::getValue();
    }

    public function get(): bool
    {
        return parent::get();
    }
}

