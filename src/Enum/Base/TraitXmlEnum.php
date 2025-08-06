<?php

namespace Imoing\Pptx\Enum\Base;

/**
 * @method static array getXmlValues()
 */
trait TraitXmlEnum
{
    public static function fromXml(string $xmlValue): static
    {
        foreach (static::getXmlValues() as $msApiValue => $val) {
            if ($val[0] == $xmlValue) {
                return static::from($msApiValue);
            }
        }

        throw new \Exception(sprintf("%s has no XML mapping for %s", __CLASS__, $xmlValue));
    }

    /**
     * @param IBaseXmlEnum $value
     * @return string
     * @throws \Exception
     */
    public static function toXml(IBaseXmlEnum $value): string
    {
        $xmlValue = $value->getXmlValue();
        if (empty($xmlValue)) {
            throw new \Exception(sprintf("%s.%s has no XML representation", __CLASS__, $value->getName()));
        }

        return $xmlValue;
    }

    public static function validate($value): void
    {
        if (!in_array($value, static::getXmlValues(), true)) {
            throw new \Exception(sprintf("%s is not a member of %s enumeration", $value, __CLASS__));
        }
    }

    public function getXmlValue(): string
    {
        return static::getXmlValues()[$this->value][0] ?? '';
    }

    public function getDescription(): string
    {
        return static::getXmlValues()[$this->value][1] ?? '';
    }
}
