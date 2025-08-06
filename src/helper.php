<?php

use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\Parts\Presentation\PresentationPart;
use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\Connector;
use Imoing\Pptx\Shapes\GroupShape;

function presentation(?string $file): \Imoing\Pptx\Presentation
{
    if ($file === null) {
        $file = _defaultPptxPath();
    }

    $presentationPart = \Imoing\Pptx\Opc\Package\OpcPackage::open($file)->getMainDocumentPart();

    return $presentationPart->getPresentation();
}

function _defaultPptxPath(): string
{
    return dirname(__FILE__) . '/Templates/default.pptx';
}

function _isPptxPackage(PresentationPart $part)
{
    $validContentTypes = [
        \Imoing\Pptx\Opc\Constants\ContentType::PML_PRESENTATION_MAIN,
        \Imoing\Pptx\Opc\Constants\ContentType::PML_PRES_MACRO_MAIN,
    ];

    return in_array($part->contentType(), $validContentTypes);
}

function parseXml(string $xml): BaseOXmlElement
{
    $dom = new \DOMDocument();
    $dom->loadXML($xml);
    return NsMap::castDom($dom->documentElement);
}

/**
 * 创建根节点
 * @param DOMDocument $dom
 * @param string $xmlStr xml文本内容
 * @return BaseOXmlElement
 */
function makeOXmlElement(DOMDocument $dom, string $xmlStr): \Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement
{
    $frag = $dom->createDocumentFragment();
    $frag->appendXML($xmlStr);
    $element = $frag->firstChild;
    assert($element instanceof DOMElement);

    return NsMap::castDom($element);
}

function qn(string $namespacePrefixedTag): string
{
    $tag = new \Imoing\Pptx\OXml\Ns\NamespacePrefixedTag($namespacePrefixedTag);
    return $tag->getClarkName();
}

function nsdecls(array|string $prefixList): string
{
    if (is_string($prefixList)) {
        $prefixList = [$prefixList];
    }
    $uriLst = [];
    foreach ($prefixList as $prefix) {
        $uriLst[] = sprintf("xmlns:%s=\"%s\"", $prefix, NsMap::getNamespaceUri($prefix));
    }
    return implode(" ", $uriLst);
}