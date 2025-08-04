<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

use Imoing\Pptx\OXml\XmlChemy\AttributeType;

abstract class BaseSimpleType implements AttributeType
{
    /**
     * Convert from XML string value.
     */
    public static function fromXml(string $xmlValue): mixed
    {
        return static::convertFromXml($xmlValue);
    }

    public static function convertFromXml(string $xmlValue)
    {
        throw new \RuntimeException("Not implemented");
    }

    /**
     * Convert to XML string value.
     */
    public static function toXml(mixed $value): string
    {
        static::validate($value);
        return static::convertToXml($value);
    }

    public static function validate(mixed $value)
    {
        throw new \RuntimeException("Not implemented");
    }

    public static function convertToXml($value): string
    {
        throw new \RuntimeException("Not implemented");
    }

    /**
     * Validate float (also accepts int).
     */
    public static function validateFloat(mixed $value): void
    {
        if (!is_numeric($value)) {
            throw new \TypeError("Value must be a number, got " . gettype($value));
        }
    }

    /**
     * Validate integer.
     */
    public static function validateInt(mixed $value): void
    {
        if (!is_int($value)) {
            throw new \TypeError("Value must be an integer, got " . gettype($value));
        }
    }

    /**
     * Validate float in range.
     */
    public static function validateFloatInRange(float $value, float $min, float $max): void
    {
        static::validateFloat($value);
        if ($value < $min || $value > $max) {
            throw new \ValueError("Value must be in range $min to $max inclusive, got $value");
        }
    }

    /**
     * Validate integer in range.
     */
    public static function validateIntInRange(int $value, int $min, int $max): void
    {
        static::validateInt($value);
        if ($value < $min || $value > $max) {
            throw new \ValueError("Value must be in range $min to $max inclusive, got $value");
        }
    }

    /**
     * Validate string type.
     */
    public static function validateString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        // For older PHP versions or special cases
        if (is_object($value) && method_exists($value, '__toString')) {
            return (string)$value;
        }

        throw new \TypeError("Value must be a string, got " . gettype($value));
    }
}
