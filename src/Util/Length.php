<?php

namespace Imoing\Pptx\Util;

use Imoing\Pptx\Common\BaseObject;

/**
 * @property-read float $inches
 * @property-read int $centipoints
 * @property-read float $cm
 * @property-read float $mm
 * @property-read int $emu
 * @property-read float $pt
 * @property-read int $px 转为像素
 */
class Length extends BaseObject
{
    const EMUS_PER_INCH = 914400;
    const EMUS_PER_CENTIPOINT = 127;
    const EMUS_PER_CM = 360000;
    const EMUS_PER_MM = 36000;
    const EMUS_PER_PT = 12700;

    const EMUS_PER_PX = 9144;

    protected int $emu;

    public function __construct(int $emu) {
        parent::__construct([]);
        $this->emu = $emu;
    }

    public function getInches(): float {
        return $this->emu / self::EMUS_PER_INCH;
    }

    public function getCentipoints(): int {
        return (int)($this->emu / self::EMUS_PER_CENTIPOINT);
    }

    public function getCm(): float {
        return $this->emu / self::EMUS_PER_CM;
    }

    public function getEmu(): int {
        return $this->emu;
    }

    public function getMm(): float {
        return $this->emu / self::EMUS_PER_MM;
    }

    public function getPt(): float {
        return $this->emu / self::EMUS_PER_PT;
    }

    public function getPx(): float
    {
        return round($this->emu / self::EMUS_PER_PT * (96 / 72), 3);
    }

    private array $_cache = [];

    public function __get(string $name)
    {
        if (!isset($this->_cache[$name])) {
            if (method_exists($this, $method = 'get' . ucfirst($name))) {
                $this->_cache[$name] = $this->$method();
            } else {
                throw new \Exception("Property $name does not exist");
            }
        }
        return $this->_cache[$name];
    }

    public function __set(string $name, $value)
    {
        throw new \Exception("Cannot set read-only property: {$name}");
    }
}