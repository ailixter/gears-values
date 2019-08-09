<?php
namespace Ailixter\Gears;

use Ailixter\Gears\Value;

class StringValue extends Value
{
    public function __construct(string $value) {
        parent::__construct($value);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getValue(): string
    {
        return parent::getValue();
    }

    public function get(): string
    {
        return parent::get();
    }
}

