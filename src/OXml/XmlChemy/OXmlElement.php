<?php

namespace Imoing\Pptx\OXml\XmlChemy;

use Imoing\Pptx\OXml\Ns\NamespacePrefixedTag;

class OXmlElement extends BaseOXmlElement
{
    public static function create(string $nspTagStr, array $nsMap = [])
    {
        $tag = new NamespacePrefixedTag($nspTagStr);
        $nsMap = empty($nsMap) ? $tag->getNsMap() : $nsMap;
    }
}