<?php
/*
 * TODO Description
 * (C) 2019, AII (Alexey Ilyin)
 */

namespace Ailixter\Gears;

use Ailixter\Gears\ValueInterface;
use Ailixter\Gears\Exceptions\ValueException;

class Value implements ValueInterface
{
    private $value;
    private $errors = [];

    /**
     * Construct the value.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
        $this->validate();
        if ($this->getErrors()) {
            $this->alert('construct');
        }
    }

    /**
     * Get the value.
     * It MUST alert on errors.
     *
     * @return mixed
     * @throws ValueException
     */
    public function get()
    {
        if ($this->getErrors()) {
            $this->alert('get');
        }
        return $this->getValue();
    }

    /**
     * Get raw stored value.
     * It NEVER alerts or throws.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set raw stored value.
     *
     * @param mixed $value
     * @return Value
     */
    protected function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Validates the value.
     * Noop by default (to be overridden).
     *
     * @return void
     */
    protected function validate()
    {
        null; // or else addError
    }

    /**
     * Alerts on errors.
     *
     * May just log or throw an exception.
     *
     * @param string $action construct, get or just use
     * @return void
     * @throws ValueException
     */
    protected function alert(string $action = 'use'): void
    {
        throw new ValueException("not allowed to {$action} {$this}", $this);
    }

    /**
     * Get error list.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Add an error to list.
     *
     * @param string $topic
     * @param mixed $subject
     * @return ValueInterface
     */
    public function addError(string $topic, $subject): ValueInterface
    {
        $this->errors[$topic] = $subject;
        return $this;
    }

    /**
     * Clear error.
     *
     * @param string $topic
     * @return ValueInterface
     */
    public function clearError(string $topic): ValueInterface
    {
        unset($this->errors[$topic]);
        return $this;
    }

    /**
     * Clear the error list.
     *
     * @return ValueInterface
     */
    public function resetErrors(): ValueInterface
    {
        $this->errors = [];
        return $this;
    }

    /**
     * Get string representation of the stored value.
     *
     * @return string
     */
    public function __toString(): string
    {
        $value = $this->getValue();
        switch (true) {
            case \is_scalar($value):
                return (string) $value;
            case \is_null($value):
                return '';
            case $value instanceof \Closure:
                return '[' . \get_class($value) . ']';
            case is_callable($value):
                return '[callable]';
            case \is_array($value):
                return '[array]';
            case \is_object($value):
                return '[' . \get_class($value) . ']';
            default:
                return '[' . \gettype($value) . ']';
        }
    }
}
