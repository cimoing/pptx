<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class Formula
{

    private array $_variables = [];
    public function __construct(array $variables = [])
    {
        $this->_variables = $variables;
    }

    public function setVariables(array $variables = []): void
    {
        $this->_variables = $variables;
    }

    private array $_avLst = [];

    /**
     * add adjust value 添加预设值
     * @param string $name
     * @param string $fmla
     * @return void
     */
    public function addAv(string $name, string $fmla): void
    {
        $this->_avLst[$name] = $fmla;
        $this->_variables[$name] = $this->execute($fmla);
    }

    public function getAvLst(): array
    {
        return $this->_avLst;
    }

    private array $_gdLst = [];

    /**
     * add shape guide
     * @param string $name
     * @param string $fmla
     * @return void
     */
    public function addGd(string $name, string $fmla): void
    {
        $this->_gdLst[$name] = $fmla;
    }

    public function getGdLst(): array
    {
        return $this->_gdLst;
    }

    /**
     * @param string $fmla
     * @return float|int
     */
    public function execute(string $fmla): float|int
    {
        $tokens = array_filter(explode(' ', trim($fmla)), function ($v) {
            return $v !== '';
        });

        return $this->executeByTokens($tokens);
    }

    protected static array $cmdMaps = [
        'val' => 'cmdVal',
        '+-' => 'cmdAddSub',
        '*/' => 'cmdMulDiv',
        '+/' => 'cmdAddDiv',
        '?:' => 'cmdIfElse',
        'abs' => 'cmdAbs',
        'min' => 'cmdMin',
        'max' => 'cmdMax',
        'sqrt' => 'cmdSqrt',
        'sin' => 'cmdSin',
        'cos' => 'cmdCos',
        'tan' => 'cmdTan',
        'at2' => 'cmdAt2',
        'cat2' => 'cmdCat2',
        'mod' => 'cmdMod',
        'pin' => 'cmdPin',
        'sat2' => 'cmdSa2',
        'sa2' => 'cmdSa2',
    ];

    protected function executeByTokens(array $tokens): float|int
    {
        $op = array_shift($tokens);
        if (self::isCmd($tokens[0])) {
            $argCount = self::getCmdArgCount($op);
            $childTokens = array_slice($tokens, 0, $argCount + 1);
            $childVal = $this->executeByTokens($childTokens);
            $tokens = array_slice($tokens, $argCount + 1);
            array_unshift($tokens, $childVal);
        }

        foreach ($tokens as &$token) {
            if ($this->hasVal($token)) {
                $token = $this->getVal($token); // 转换变量
            }
        }

        $callable = [$this, self::$cmdMaps[$op]];
        return call_user_func($callable, ...$tokens);
    }

    public static function isCmd(string $cmd): bool
    {
        return array_key_exists($cmd, self::$cmdMaps);
    }

    public static function getCmdArgCount(string $cmd): int
    {
        return match ($cmd) {
            'sat2', '+-','*/','+/','?:','cat2', 'mod', 'pin', => 3,
            'sin', 'tan', 'cos', 'at2', 'min', 'max' => 2,
            default => 1,
        };
    }

    public function getVal(string $name): float|int
    {
        if (array_key_exists($name, $this->_variables)) {
            return $this->_variables[$name];
        }

        $command = $this->_avLst[$name] ?? null;
        if (is_null($command)) {
            return 0;
        }

        return $this->execute($command);
    }

    protected function hasVal(string $name): bool
    {
        return array_key_exists($name, $this->_variables) || array_key_exists($name, $this->_gdLst);
    }

    protected function cmdVal(float|int $value): float|int
    {
        return $value;
    }

    protected function cmdAddSub(float|int $v1, float|int $v2, float|int $v3): float|int
    {
        return $v1 + $v2 - $v3;
    }

    protected function cmdMulDiv(float|int $v1, float|int $v2, float|int $v3): float|int
    {
        return $v1 * $v2 / $v3;
    }

    protected function cmdAddDiv(float|int $v1, float|int $v2, float|int $v3): float|int
    {
        return ($v1 + $v2) / $v3;
    }

    /**
     * @param float|int $v1
     * @param float|int $v2
     * @param float|int $v3
     * @return float|int
     */
    protected function cmdIfElse(float|int $v1, float|int $v2, float|int $v3): float|int
    {
        return $v1 > 0 ? $v2 : $v3;
    }

    protected function cmdAbs(float|int $val): float|int
    {
        return abs($val);
    }

    protected function cmdAt2(float $x, float $y): float
    {
        return atan2($y, $x);
    }

    /**
     * Cosine ArcTan Formula
     * @param float $x
     * @param float $y
     * @param float $z
     * @return float
     */
    protected function cmdCat2(float $x, float $y, float $z): float
    {
        return $x * (cos(atan($z/$y)));
    }

    protected function cmdCos(float|int $x, float|int $y): float|int
    {
        return $x * cos($y);
    }

    protected function cmdMod(float|int $x, float|int $y, float|int $z): float|int
    {
        return sqrt($x*$x + $y*$y + $z*$z);
    }

    protected function cmdMin(float|int $v1, float|int $v2): float|int
    {
        return min($v1, $v2);
    }

    protected function cmdMax(float|int $v1, float|int $v2): float|int
    {
        return max($v1, $v2);
    }

    protected function cmdPin(float|int $x, float|int $y, float|int $z): float|int
    {
        return $y < $x ? $x : (min($y, $z));
    }

    protected function cmdSa2(float|int $x, float|int $y, float|int $z): float|int
    {
        return $x * sin(atan($z/$y));
    }

    protected function cmdSin(float|int $x, float|int $y): float|int
    {
        return $x * sin($y);
    }

    protected function cmdSqrt(float|int $x): float|int
    {
        return sqrt($x);
    }

    protected function cmdTan(float|int $x, float|int $y): float|int
    {
        return $x * tan($y);
    }
}