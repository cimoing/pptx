<?php

namespace Imoing\Pptx\Templates;

use DOMDocument;

class Template
{
    public static function parseFromTemplate(string $templateFileName): \Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement
    {
        $dir = dirname(__FILE__);
        $fileName = $dir . DIRECTORY_SEPARATOR . $templateFileName . '.xml';
        $xml = file_get_contents($fileName);
        $dom = new DOMDocument();
        $dom->loadXML($fileName);
        $tag = $dom->documentElement->tagName;

        return parseXml($tag, $xml);
    }
}