<?php
namespace Ailixter\Gears\Exceptions;

use UnexpectedValueException;
use Ailixter\Gears\ValueInterface;

class ValueException extends UnexpectedValueException
{
    private $value;

    public function __construct($message, ValueInterface $value) {
        parent::__construct($message);
        $this->value = $value;
    }

    /**
     * Get the value of value
     */
    public function getValue(): ValueInterface
    {
        return $this->value;
    }
}

