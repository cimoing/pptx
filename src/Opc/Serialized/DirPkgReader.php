<?php

namespace Imoing\Pptx\Opc\Serialized;

use Imoing\Pptx\Opc\PackURI;

class DirPkgReader extends PhysPkgReader
{
    private string $_path;
    public function __construct(string $path)
    {
        $this->_path = $path;
    }

    public function has(PackURI $uri): bool
    {
        return file_exists($this->_path . '/' . (string) $uri);
    }

    public function getItem(PackURI $uri): string
    {
        return file_get_contents($this->_path . '/' . (string) $uri);
    }
}