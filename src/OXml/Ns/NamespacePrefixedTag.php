<?php

namespace Imoing\Pptx\OXml\Ns;

class NamespacePrefixedTag
{
    private string $_pfx;
    private string $_local_part;
    private string $_ns_uri;
    public function __construct(string $nsTag)
    {
        list($this->_pfx, $this->_local_part) = explode(':', $nsTag, 2);
        $this->_ns_uri = NsMap::getNamespaceUri($this->_pfx);
    }

    public static function fromClarkName(string $clarkName): static
    {
        list($nsUri, $local_name) = explode('}', $clarkName, 2);
        $nsTag = sprintf("%s:%s", NsMap::getPrefix(ltrim($nsUri,'{')), $local_name);

        return new static($nsTag);
    }

    public function getClarkName(): string
    {
        return sprintf("{%s}%s", $this->_ns_uri, $this->_local_part);
    }

    public function getLocalPart(): string
    {
        return $this->_local_part;
    }

    public function getNsmap(): array
    {
        return [$this->_pfx => $this->_ns_uri];
    }

    public function getNspfx():  string
    {
        return $this->_pfx;
    }

    public function getNsUri(): string
    {
        return $this->_ns_uri;
    }

    public function __toString()
    {
        return sprintf("%s:%s", $this->_pfx, $this->_local_part);
    }
}