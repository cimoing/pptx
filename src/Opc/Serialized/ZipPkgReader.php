<?php

namespace Imoing\Pptx\Opc\Serialized;

use Imoing\Pptx\Opc\PackURI;

class ZipPkgReader extends PhysPkgReader
{
    private string $_pkgFile;

    private ?\ZipArchive $_zip;
    public function __construct(string $pkgFile)
    {
        $this->_pkgFile = $pkgFile;
        $this->_zip = new \ZipArchive();
        $this->_zip->open($this->_pkgFile);
    }

    public function __destruct()
    {
        $this->_zip->close();
    }

    public function has(PackURI $uri): bool
    {
        $blobs = $this->blobs();
        return array_key_exists((string) $uri, $blobs);
    }

    public function getItem(PackURI $uri): string
    {
        if (!$this->has($uri)) {
            throw new \Exception("no member $uri in package");
        }

        $idx = $this->_blobs[(string) $uri];
        return $this->_zip->getFromIndex($idx);
    }

    private array $_blobs = [];
    private function blobs(): array
    {
        if (empty($this->_blobs)) {
            for ($i = 0; $i < $this->_zip->numFiles; $i++) {
                $stat = $this->_zip->statIndex($i);
                $this->_blobs["/{$stat['name']}"] = $i;
            }
        }

        return $this->_blobs;
    }


}