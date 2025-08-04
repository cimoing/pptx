<?php

namespace Imoing\Pptx\Opc\OXml;

use Imoing\Pptx\Opc\Constants\RelationshipTargetMode;
use Imoing\Pptx\Opc\Part;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @method CTRelationship _insert_relationship(CTRelationship $relationship)
 * @property-read CTRelationship[] $relationship_lst
 */
class CTRelationships extends BaseOXmlElement
{
    #[ZeroOrMore("pr:Relationship")]
    protected array $relationship;

    public static function create(): static
    {
        $dom = new \DOMDocument();
        $dom->encoding = 'UTF-8';
        NsMap::replaceTagClass("pr:Relationships", $dom);
        $node = $dom->createElement("Relationships");
        $uri = NsMap::getNamespaceUri("pr");
        $node->setAttribute("xmlns", $uri);

        return new static($node);
    }

    public function addRelationship(string $relationId, string $relType, string $target, bool $isExternal = false): CTRelationship
    {
        $targetMode = $isExternal ? RelationshipTargetMode::EXTERNAL : RelationshipTargetMode::INTERNAL;
        $relationship = CTRelationship::create($relationId, $relType, $target, $targetMode, $this->ownerDocument);

        return $this->_insert_relationship($relationship);
    }
}