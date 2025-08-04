<?php

namespace Imoing\Pptx\Opc\Serialized;

use Imoing\Pptx\Opc\PackURI;

class ZipPkgWriter extends PhysPkgWriter
{
    private string $_pkgFile;
    public function __construct(string $pkgFile)
    {
        $this->_pkgFile = $pkgFile;
    }


    public function write(PackURI $packUri, string $blob): void
    {
        $this->getZipArchive()->addFromString($packUri->getMemberName(), $blob);
    }

    private ?\ZipArchive $_zip;
    private function getZipArchive(): \ZipArchive
    {
        if ($this->_zip === null) {
            $this->_zip = new \ZipArchive();
            $this->_zip->open($this->_pkgFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        }

        return $this->_zip;
    }

    public function __destruct()
    {
        if (!empty($this->_zip)) {
            $this->_zip->close();
        }
    }
}