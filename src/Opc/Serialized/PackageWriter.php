<?php

namespace Imoing\Pptx\Opc\Serialized;

use Imoing\Pptx\Opc\Package\Relationships;
use Imoing\Pptx\Opc\Part;

class PackageWriter
{
    private string $_pkgFile;
    private Relationships $_pkgRels;

    /**
     * @var Part[]
     */
    private array $_parts;
    public function __construct(string $pkgFile, Relationships $pkgRels, array $parts)
    {
        $this->_pkgFile = $pkgFile;
        $this->_pkgRels = $pkgRels;
        $this->_parts = $parts;
    }

    public static function write(string $pkgFile, Relationships $pkgRels, array $parts): void
    {
        (new static($pkgFile, $pkgRels, $parts))->_write();
    }

    protected function _write(): void
    {

    }
}