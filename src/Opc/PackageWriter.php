<?php

namespace Imoing\Pptx\Opc;

use Imoing\Pptx\Opc\Package\Relationships;

class PackageWriter
{
    private $pkgFile;

    /**
     * @var Relationships
     */
    private $_pkgRels;
    /**
     * @var Part[]
     */
    private array $_parts;

    public function __construct($pkgFile, $pkgRels, array $parts)
    {
        $this->pkgFile = $pkgFile;
        $this->_pkgRels = $pkgRels;
        $this->_parts = $parts;
    }

    public static function write($pkgFile, $pkgRels, array $parts): void
    {
        $instance = new self($pkgFile, $pkgRels, $parts);
        $instance->_write();
    }

    private function _write(): void
    {
        $physWriter = PhysPkgWriter::factory($this->pkgFile);

        try {
            $this->_writeContentTypesStream($physWriter);
            $this->_writePkgRels($physWriter);
            $this->_writeParts($physWriter);
        } finally {
            $physWriter->close();
        }
    }

    private function _writeContentTypesStream($_physWriter): void
    {
        $contentTypesUri = PackURI::contentTypesURI();
        $blob = ContentTypesItem::xmlFor($this->_parts)->saveXML();
        $_physWriter->write($contentTypesUri, $blob);
    }

    private function _writeParts($_physWriter): void
    {
        foreach ($this->_parts as $part) {
            $_physWriter->write($part->partname, $part->blob);
            if (count($part->rels) > 0) { // 假设 $part 具有 _rels 属性
                $_physWriter->write($part->partName->getRelsUri(), $part->rels->xml);
            }
        }
    }

    private function _writePkgRels($_physWriter): void
    {
        $_physWriter->write(PackURI::packageURI()->getRelsUri(), $this->_pkgRels->xml);
    }
}