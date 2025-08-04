<?php

namespace Imoing\Pptx\OXml\XmlChemy;

class XMLReader
{
    private $dom;

    /**
     * DOMXpath object
     *
     * @var \DOMXpath
     */
    private $xpath;

    /**
     * Get DOMDocument from ZipArchive
     *
     * @param string $zipFile
     * @param string $xmlFile
     *
     * @return \DOMDocument|false
     *
     * @throws \Exception
     */
    public function getDomFromZip(string $zipFile, string $xmlFile)
    {
        if (file_exists($zipFile) === false) {
            throw new \Exception('Cannot find archive file.');
        }

        $zip = new \ZipArchive();
        $zip->open($zipFile);
        $content = $zip->getFromName($xmlFile);

        // Files downloaded from Sharepoint are somehow different and fail on the leading slash.
        if ($content === false && substr($xmlFile, 0, 1) === '/') {
            $content = $zip->getFromName(substr($xmlFile, 1));
        }

        $zip->close();

        if ($content === false) {
            return false;
        }

        return $this->getDomFromString($content);
    }

    /**
     * Get DOMDocument from content string
     *
     * @param string $content
     *
     * @return \DOMDocument
     */
    public function getDomFromString(string $content): \DOMDocument
    {
        $this->dom = new \DOMDocument();
        $this->dom->loadXML($content);


        return $this->dom;
    }

    /**
     * Get elements
     *
     * @param string $path
     * @param \DOMElement $contextNode
     *
     * @return \DOMNodeList<\DOMElement>
     */
    public function getElements(string $path, ?\DOMElement $contextNode = null): \DOMNodeList
    {
        if ($this->dom === null) {
            return new \DOMNodeList();
        }
        if ($this->xpath === null) {
            $this->xpath = new \DOMXpath($this->dom);
        }

        if (is_null($contextNode)) {
            return $this->xpath->query($path);
        }

        return $this->xpath->query($path, $contextNode);
    }

    /**
     * Registers the namespace with the DOMXPath object
     *
     * @param string $prefix The prefix
     * @param string $namespaceURI The URI of the namespace
     *
     * @return bool true on success or false on failure
     *
     * @throws \InvalidArgumentException If called before having loaded the DOM document
     */
    public function registerNamespace($prefix, $namespaceURI): bool
    {
        if ($this->dom === null) {
            throw new \InvalidArgumentException('Dom needs to be loaded before registering a namespace');
        }
        if ($this->xpath === null) {
            $this->xpath = new \DOMXpath($this->dom);
        }

        return $this->xpath->registerNamespace($prefix, $namespaceURI);
    }

    /**
     * Get element
     *
     * @param string $path
     * @param \DOMElement $contextNode
     *
     * @return \DOMElement|null
     */
    public function getElement($path, ?\DOMElement $contextNode = null): ?\DOMElement
    {
        $elements = $this->getElements($path, $contextNode);
        if ($elements->length > 0) {
            return $elements->item(0) instanceof \DOMElement ? $elements->item(0) : null;
        }

        return null;
    }

    /**
     * Get element attribute
     *
     * @param string $attribute
     * @param \DOMElement $contextNode
     * @param string $path
     *
     * @return string|null
     */
    public function getAttribute($attribute, ?\DOMElement $contextNode = null, ?string $path = null)
    {
        $return = null;
        if ($path !== null) {
            $elements = $this->getElements($path, $contextNode);
            if ($elements->length > 0) {
                /** @var \DOMElement $node Type hint */
                $node = $elements->item(0);
                $return = $node->getAttribute($attribute);
            }
        } else {
            if ($contextNode !== null) {
                $return = $contextNode->getAttribute($attribute);
            }
        }

        return ($return == '') ? null : $return;
    }

    /**
     * Get element value
     *
     * @param string $path
     * @param \DOMElement $contextNode
     *
     * @return string|null
     */
    public function getValue($path, ?\DOMElement $contextNode = null)
    {
        $elements = $this->getElements($path, $contextNode);
        if ($elements->length > 0) {
            return $elements->item(0)->nodeValue;
        }

        return null;
    }

    /**
     * Count elements
     *
     * @param string $path
     * @param \DOMElement $contextNode
     *
     * @return int
     */
    public function countElements($path, ?\DOMElement $contextNode = null)
    {
        $elements = $this->getElements($path, $contextNode);

        return $elements->length;
    }

    /**
     * Element exists
     *
     * @param string $path
     * @param \DOMElement $contextNode
     *
     * @return bool
     */
    public function elementExists($path, ?\DOMElement $contextNode = null)
    {
        return $this->getElements($path, $contextNode)->length > 0;
    }
}