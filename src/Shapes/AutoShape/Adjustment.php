<?php

namespace Imoing\Pptx\Shapes\AutoShape;

/**
 * @property float $effectiveValue
 * @property-read int $val
 */
class Adjustment
{
    public string $name;

    public int $defVal;

    public ?int $actual;
    public function __construct(string $name, int $defaultVal, ?int $actual = null)
    {
        $this->name = $name;
        $this->defVal = $defaultVal;
        $this->actual = $actual;
    }

    public function getEffectiveValue(): float
    {
        $rawVal = is_null($this->actual) ? $this->defVal : $this->actual;

        return self::normalize($rawVal);
    }

    public function setEffectiveValue(float $value): void
    {
        $this->actual = self::denormalize($value);
    }

    private static function denormalize(float $val): int
    {
        return intval($val * 100000);
    }

    private static function normalize(int $rawValue): float
    {
        return $rawValue / 100000.0;
    }

    public function getVal(): int
    {
        return is_null($this->actual) ? $this->defVal : $this->actual;
    }
}