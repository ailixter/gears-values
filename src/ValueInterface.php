<?php
/*
 * TODO Description
 * (C) 2019, AII (Alexey Ilyin)
 */

namespace Ailixter\Gears;

interface ValueInterface
{
    /**
     * Get the value.
     * It MUST alert on errors.
     *
     * @return mixed
     * @throws ValueException
     */
    function get();
    /**
     * Get raw stored value.
     * It NEVER alerts or throws.
     *
     * @return mixed
     */
    function getValue();
    /**
     * Get error list.
     *
     * @return array
     */
    function getErrors(): array;
    /**
     * Add an error to list.
     *
     * @param string $topic
     * @param mixed $subject
     * @return ValueInterface fluent
     */
    function addError(string $topic, $subject): ValueInterface;
    /**
     * Clear the error list.
     *
     * @return ValueInterface fluent
     */
    function resetErrors(): ValueInterface;
    /**
     * Get string representation of the stored value.
     *
     * @return string
     */
    function __toString(): string;
}