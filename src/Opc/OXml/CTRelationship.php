<?php

namespace Imoing\Pptx\Opc\OXml;

use Imoing\Pptx\Opc\Constants\RelationshipTargetMode;
use Imoing\Pptx\Opc\Package\Relationship;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\SimpleTypes\STTargetMode;
use Imoing\Pptx\OXml\SimpleTypes\XsdAnyUri;
use Imoing\Pptx\OXml\SimpleTypes\XsdId;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $targetMode
 * @property string $targetRef
 * @property string $rId
 * @property string $relType
 */
class CTRelationship extends BaseOXmlElement
{
    #[RequiredAttribute("Id", XsdId::class)]
    protected string $_rId;

    #[RequiredAttribute("Type", XsdAnyUri::class)]
    protected string $_relType;

    #[RequiredAttribute("Target", XsdAnyUri::class)]
    protected string $_targetRef;

    #[OptionalAttribute("TargetMode", STTargetMode::class, RelationshipTargetMode::INTERNAL)]
    protected string $_targetMode;

    /**
     * @param string $relationId
     * @param string $relType
     * @param string $targetRef
     * @param string $targetMode
     * @param \DOMDocument $dom 需要使用同一个DOM创建
     * @return static
     * @throws \DOMException
     */
    public static function create(string $relationId, string $relType, string $targetRef, string $targetMode, \DOMDocument $dom): static
    {
        NsMap::replaceTagClass("pr:Relationship", $dom);
        /**
         * @var static $node
         */
        $relationship = $dom->createElement('Relationship');
        $nsUri = NsMap::getNamespaceUri("pr");
        $relationship->setAttribute('xmlns', $nsUri);

        $obj = NsMap::castDom($relationship);
        assert($obj instanceof static);

        $obj->rId = $relationId;
        $obj->relType = $relType;
        $obj->targetRef = $targetRef;
        $obj->targetMode = $targetMode;

        return $obj;
    }

    public function isExternal(): bool
    {
        return $this->__get('targetMode') == RelationshipTargetMode::EXTERNAL;
    }
}